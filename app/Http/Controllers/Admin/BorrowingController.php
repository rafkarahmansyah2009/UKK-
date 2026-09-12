<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BorrowingController extends Controller
{
    /**
     * Display a listing of borrowings.
     */
    public function index(Request $request): View
    {
        $query = Borrowing::with(['user', 'book', 'fine']);

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('transaction_code', 'like', "%{$searchTerm}%")
                    ->orWhereHas('user', function ($uq) use ($searchTerm) {
                        $uq->where('name', 'like', "%{$searchTerm}%")
                            ->orWhere('nis', 'like', "%{$searchTerm}%")
                            ->orWhere('nip', 'like', "%{$searchTerm}%");
                    })
                    ->orWhereHas('book', function ($bq) use ($searchTerm) {
                        $bq->where('title', 'like', "%{$searchTerm}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $borrowings = $query->latest()->paginate(10)->withQueryString();

        return view('admin.borrowings.index', compact('borrowings'));
    }

    /**
     * Show the form for creating a new borrowing transaction.
     */
    public function create(): View
    {
        $members = User::where('role', 'member')->where('status', 'active')->orderBy('name')->get();
        $books = Book::where('available_stock', '>', 0)->orderBy('title')->get();

        return view('admin.borrowings.create', compact('members', 'books'));
    }

    /**
     * Store a newly created borrowing transaction.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'book_id' => ['required', 'exists:books,id'],
            'borrow_date' => ['required', 'date'],
            'duration_days' => ['required', 'integer', 'in:3,7,14,30'],
            'notes' => ['nullable', 'string'],
        ]);

        $member = User::findOrFail($validated['user_id']);
        if (! $member->isActive()) {
            return back()->withInput()->with('error', 'Anggota tidak aktif atau sedang dinonaktifkan. Peminjaman ditolak.');
        }

        $book = Book::findOrFail($validated['book_id']);
        if ($book->available_stock <= 0) {
            return back()->withInput()->with('error', "Stok buku '{$book->title}' sedang habis.");
        }

        $borrowDate = Carbon::parse($validated['borrow_date']);
        $dueDate = (clone $borrowDate)->addDays((int) $validated['duration_days']);

        $trxCode = 'TRX-'.strtoupper(Str::random(5));
        while (Borrowing::where('transaction_code', $trxCode)->exists()) {
            $trxCode = 'TRX-'.strtoupper(Str::random(5));
        }

        $borrowing = Borrowing::create([
            'transaction_code' => $trxCode,
            'user_id' => $member->id,
            'book_id' => $book->id,
            'borrow_date' => $borrowDate,
            'due_date' => $dueDate,
            'status' => 'borrowed',
            'notes' => $validated['notes'] ?? null,
        ]);

        // Decrement available stock
        $book->decrementAvailableStock(1);

        ActivityLog::record(
            'borrowing_created',
            "Transaksi {$borrowing->transaction_code}: {$member->name} meminjam '{$book->title}'.",
            auth()->id()
        );

        return redirect()->route('admin.borrowings.index')->with('success', "Transaksi {$borrowing->transaction_code} berhasil dicatat.");
    }
}
