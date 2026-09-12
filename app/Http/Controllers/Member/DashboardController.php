<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Borrowing;
use App\Models\Fine;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the member dashboard.
     */
    public function index(): View
    {
        $user = auth()->user();

        $activeBorrowings = Borrowing::with('book')
            ->where('user_id', $user->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->latest()
            ->get();

        $totalActive = $activeBorrowings->count();

        $totalOverdue = $activeBorrowings->filter(fn ($b) => $b->isOverdue())->count();

        $unpaidFines = Fine::where('user_id', $user->id)
            ->where('status', 'unpaid')
            ->sum('amount');

        $recommendedBooks = Book::with('category')
            ->where('available_stock', '>', 0)
            ->inRandomOrder()
            ->take(4)
            ->get();

        return view('member.dashboard', compact(
            'user',
            'activeBorrowings',
            'totalActive',
            'totalOverdue',
            'unpaidFines',
            'recommendedBooks'
        ));
    }
}
