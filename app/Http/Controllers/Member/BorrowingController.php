<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Borrowing;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Display member's current active borrowings.
     */
    public function current(): View
    {
        $user = auth()->user();

        $borrowings = Borrowing::with('book.category')
            ->where('user_id', $user->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->latest()
            ->paginate(10);

        return view('member.borrowings.current', compact('borrowings'));
    }

    /**
     * Display member's past borrowing history.
     */
    public function history(): View
    {
        $user = auth()->user();

        $borrowings = Borrowing::with(['book.category', 'fine'])
            ->where('user_id', $user->id)
            ->where('status', 'returned')
            ->latest('return_date')
            ->paginate(10);

        return view('member.borrowings.history', compact('borrowings'));
    }

    /**
     * Store a newly created borrowing request by the member.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'book_id' => ['required', 'exists:books,id'],
            'notes' => ['nullable', 'string', 'max:255'],
        ]);

        $user = auth()->user();

        // 1. Check if member account is active
        if (! $user->isActive()) {
            return back()->with('error', 'Akun anggota Anda sedang tidak aktif. Tidak dapat melakukan peminjaman buku.');
        }

        // 2. Check maximum active borrowings (limit: 3 books)
        $activeCount = $user->borrowings()->whereIn('status', ['borrowed', 'overdue'])->count();
        if ($activeCount >= 3) {
            return back()->with('error', 'Anda telah mencapai batas maksimal peminjaman (3 buku). Kembalikan buku terlebih dahulu.');
        }

        // 3. Find book & check available stock
        $book = Book::findOrFail($validated['book_id']);
        if ($book->available_stock <= 0) {
            return back()->with('error', "Maaf, stok buku '{$book->title}' sedang tidak tersedia.");
        }

        // 4. Check if member already has an active loan of this exact book
        $alreadyBorrowed = $user->borrowings()
            ->where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->exists();

        if ($alreadyBorrowed) {
            return back()->with('error', "Anda sedang meminjam buku '{$book->title}'. Harap kembalikan terlebih dahulu sebelum meminjam kembali.");
        }

        // 5. Create transaction
        $trxCode = 'TRX-'.strtoupper(Str::random(5));
        while (Borrowing::where('transaction_code', $trxCode)->exists()) {
            $trxCode = 'TRX-'.strtoupper(Str::random(5));
        }

        $borrowDate = Carbon::today();
        $dueDate = (clone $borrowDate)->addDays(7); // Standard loan duration: 7 days

        $borrowing = Borrowing::create([
            'transaction_code' => $trxCode,
            'user_id' => $user->id,
            'book_id' => $book->id,
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'status' => 'borrowed',
            'notes' => $validated['notes'] ?? 'Peminjaman mandiri oleh anggota melalui portal digital.',
        ]);

        // 6. Decrement available stock safely
        $book->decrementAvailableStock(1);

        // 7. Record system activity
        $memberId = $user->nis ?? $user->nip ?? 'Anggota';
        ActivityLog::record(
            'member_borrowed',
            "Anggota {$user->name} ({$memberId}) meminjam buku '{$book->title}' (TRX: {$trxCode}).",
            $user->id
        );

        return redirect()->route('member.borrowings.current')
            ->with('success', "Buku '{$book->title}' berhasil dipinjam dengan kode {$trxCode}. Batas waktu pengembalian: {$dueDate->translatedFormat('d F Y')}.");
    }
}
