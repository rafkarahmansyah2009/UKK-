<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Fine;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class FineController extends Controller
{
    /**
     * Display a listing of fines.
     */
    public function index(Request $request): View
    {
        $query = Fine::with(['user', 'borrowing.book', 'paidTo']);

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->where(function ($q) use ($searchTerm) {
                $q->whereHas('user', function ($uq) use ($searchTerm) {
                    $uq->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('nis', 'like', "%{$searchTerm}%")
                        ->orWhere('nip', 'like', "%{$searchTerm}%");
                })
                    ->orWhereHas('borrowing', function ($bq) use ($searchTerm) {
                        $bq->where('transaction_code', 'like', "%{$searchTerm}%");
                    });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->input('status'));
        }

        $fines = $query->latest()->paginate(10)->withQueryString();

        $totalUnpaid = Fine::where('status', 'unpaid')->sum('amount');
        $totalPaid = Fine::where('status', 'paid')->sum('amount');

        return view('admin.fines.index', compact('fines', 'totalUnpaid', 'totalPaid'));
    }

    /**
     * Settle / pay the fine.
     */
    public function pay(Request $request, Fine $fine): RedirectResponse
    {
        if ($fine->isPaid()) {
            return back()->with('error', 'Denda ini sudah lunas dan tidak dapat dibayar kembali.');
        }

        $notes = $request->input('notes', 'Pembayaran denda tunai di kasir perpustakaan.');

        $fine->markAsPaid(auth()->user(), $notes);

        ActivityLog::record(
            'fine_paid',
            'Pembayaran denda sebesar Rp '.number_format($fine->amount, 0, ',', '.')." untuk anggota {$fine->user->name} telah diverifikasi oleh ".auth()->user()->name.'.',
            auth()->id()
        );

        return redirect()->route('admin.fines.index')->with('success', 'Pembayaran denda berhasil dikonfirmasi dan dicatat lunas.');
    }
}
