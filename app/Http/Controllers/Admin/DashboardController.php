<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(): View
    {
        // 1. Core Metrics
        $totalBooks = Book::sum('stock');
        $totalMembers = User::where('role', 'member')->count();
        $borrowedCount = Borrowing::where('status', 'borrowed')->count();
        $overdueCount = Borrowing::where('status', 'overdue')
            ->orWhere(function ($q) {
                $q->where('status', 'borrowed')->where('due_date', '<', Carbon::today());
            })->count();

        // 2. Chart: Borrowing trends over past 7 days
        $days = collect();
        $chartCounts = [];
        $dayLabels = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $dayLabels[] = $date->translatedFormat('D');
            $count = Borrowing::whereDate('borrow_date', $date)->count();
            $chartCounts[] = $count;
        }

        // 3. Popular Books (top borrowed)
        $popularBooks = Book::with('category')
            ->withCount('borrowings')
            ->orderByDesc('borrowings_count')
            ->take(3)
            ->get();

        // 4. Low stock books (available_stock <= 2)
        $lowStockBooks = Book::where('available_stock', '<=', 2)
            ->take(4)
            ->get();

        // 5. Recent Borrowings
        $recentBorrowings = Borrowing::with(['user', 'book'])
            ->latest()
            ->take(5)
            ->get();

        // 6. Recent Activity Logs (dynamic!)
        $recentActivities = ActivityLog::with('user')
            ->latest()
            ->take(6)
            ->get();

        return view('admin.dashboard', compact(
            'totalBooks',
            'totalMembers',
            'borrowedCount',
            'overdueCount',
            'dayLabels',
            'chartCounts',
            'popularBooks',
            'lowStockBooks',
            'recentBorrowings',
            'recentActivities'
        ));
    }
}
