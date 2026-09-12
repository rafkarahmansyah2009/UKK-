<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Borrowing;
use App\Models\Fine;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ReportController extends Controller
{
    /**
     * Display library reports with date range filtering.
     */
    public function index(Request $request): View
    {
        $startDate = $request->input('start_date', Carbon::today()->subMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::today()->format('Y-m-d'));

        $borrowingsQuery = Borrowing::with(['user', 'book'])
            ->whereBetween('borrow_date', [$startDate, $endDate]);

        $totalTransactions = (clone $borrowingsQuery)->count();
        $returnedCount = (clone $borrowingsQuery)->where('status', 'returned')->count();
        $activeCount = (clone $borrowingsQuery)->where('status', 'borrowed')->count();
        $overdueCount = (clone $borrowingsQuery)->where('status', 'overdue')->count();

        $finesCollected = Fine::where('status', 'paid')
            ->whereBetween('payment_date', [Carbon::parse($startDate)->startOfDay(), Carbon::parse($endDate)->endOfDay()])
            ->sum('amount');

        $transactions = $borrowingsQuery->latest()->paginate(15)->withQueryString();

        return view('admin.reports.index', compact(
            'transactions',
            'startDate',
            'endDate',
            'totalTransactions',
            'returnedCount',
            'activeCount',
            'overdueCount',
            'finesCollected'
        ));
    }
}
