<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard.
     */
    public function index(Request $request): View
    {
        // 1. Core Metrics
        $totalBooks = Book::sum('stock');
        $totalMembers = User::where('role', 'member')->count();
        $borrowedCount = Borrowing::where('status', 'borrowed')->count();
        $overdueCount = Borrowing::where('status', 'overdue')
            ->orWhere(function ($q) {
                $q->where('status', 'borrowed')->where('due_date', '<', Carbon::today());
            })->count();

        // 2. Chart: Borrowing trends (default 7 days)
        $chartData = $this->getBorrowingTrendData($request->get('period', '7_days'));
        $dayLabels = $chartData['labels'];
        $chartCounts = $chartData['data'];

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

    /**
     * Return JSON borrowing trend chart data for AJAX filter requests.
     */
    public function chartData(Request $request): JsonResponse
    {
        $period = $request->get('period', '7_days');
        $data = $this->getBorrowingTrendData($period);

        return response()->json($data);
    }

    /**
     * Helper to compute labels and data points based on period.
     *
     * @return array{labels: list<string>, data: list<int>}
     */
    protected function getBorrowingTrendData(string $period): array
    {
        $labels = [];
        $data = [];

        if ($period === '30_days') {
            for ($i = 29; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $labels[] = $date->translatedFormat('d M');
                $data[] = Borrowing::whereDate('created_at', $date)->count();
            }
        } elseif ($period === 'this_year') {
            $year = Carbon::now()->year;
            for ($m = 1; $m <= 12; $m++) {
                $date = Carbon::create($year, $m, 1);
                $labels[] = $date->translatedFormat('M');
                $data[] = Borrowing::whereYear('created_at', $year)
                    ->whereMonth('created_at', $m)
                    ->count();
            }
        } else {
            // Default: 7 Hari Terakhir
            for ($i = 6; $i >= 0; $i--) {
                $date = Carbon::today()->subDays($i);
                $labels[] = $date->translatedFormat('D, d M');
                $data[] = Borrowing::whereDate('created_at', $date)->count();
            }
        }

        return [
            'labels' => $labels,
            'data' => $data,
        ];
    }
}
