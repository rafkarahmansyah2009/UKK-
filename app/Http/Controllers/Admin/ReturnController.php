<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Borrowing;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReturnController extends Controller
{
    /**
     * Display a listing of return-eligible borrowings and completed returns.
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

        return view('admin.returns.index', compact('borrowings'));
    }

    /**
     * Process return of a borrowed book.
     */
    public function process(Request $request, Borrowing $borrowing): RedirectResponse
    {
        // Prevent returning an already returned transaction
        if ($borrowing->status === 'returned') {
            return back()->with('error', 'Transaksi ini sudah pernah dikembalikan sebelumnya.');
        }

        $returnDate = Carbon::today();
        $borrowing->return_date = $returnDate;
        $borrowing->status = 'returned';
        $borrowing->save();

        // Increment book available stock safely
        $borrowing->book->incrementAvailableStock(1);

        // Check for overdue days and calculate fine (Rp 1.000 / day)
        $dueDate = Carbon::parse($borrowing->due_date);
        $fineCreated = false;
        if ($returnDate->gt($dueDate)) {
            $daysOverdue = $dueDate->diffInDays($returnDate);
            $fineAmount = $daysOverdue * 1000;

            Fine::firstOrCreate(
                ['borrowing_id' => $borrowing->id],
                [
                    'user_id' => $borrowing->user_id,
                    'amount' => $fineAmount,
                    'days_overdue' => $daysOverdue,
                    'status' => 'unpaid',
                    'notes' => "Terlambat {$daysOverdue} hari dari tenggat waktu.",
                ]
            );
            $fineCreated = true;
        }

        ActivityLog::record(
            'return_processed',
            "Pengembalian buku '{$borrowing->book->title}' untuk transaksi {$borrowing->transaction_code} ({$borrowing->user->name}) telah diproses.".($fineCreated ? ' Dikenakan denda keterlambatan.' : ''),
            auth()->id()
        );

        $msg = "Pengembalian transaksi {$borrowing->transaction_code} berhasil diproses.";
        if ($fineCreated) {
            $msg .= ' Buku terlambat dikembalikan, denda otomatis dicatat.';
        }

        return redirect()->route('admin.returns.index')->with('success', $msg);
    }
}
