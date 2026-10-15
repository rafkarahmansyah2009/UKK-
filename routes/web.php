<?php

use App\Http\Controllers\Admin\BookController as AdminBookController;
use App\Http\Controllers\Admin\BorrowingController as AdminBorrowingController;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FineController as AdminFineController;
use App\Http\Controllers\Admin\MemberController as AdminMemberController;
use App\Http\Controllers\Admin\ReportController as AdminReportController;
use App\Http\Controllers\Admin\ReturnController as AdminReturnController;
use App\Http\Controllers\Member\BookCatalogController as MemberBookCatalogController;
use App\Http\Controllers\Member\BorrowingController as MemberBorrowingController;
use App\Http\Controllers\Member\DashboardController as MemberDashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\PublicController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PublicController::class, 'home'])->name('home');
Route::get('/katalog', [PublicController::class, 'katalog'])->name('katalog');
Route::get('/pengumuman', [PublicController::class, 'pengumuman'])->name('pengumuman');
Route::get('/pengumuman/{slug}', [PublicController::class, 'pengumumanDetail'])->name('pengumuman.show');
Route::get('/tentang', [PublicController::class, 'tentang'])->name('tentang');

/*
|--------------------------------------------------------------------------
| Role-based Dashboard Redirection
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->isAdmin()) {
        return redirect()->route('admin.dashboard');
    }

    return redirect()->route('member.dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected: auth & role:admin)
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->as('admin.')->middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
    Route::get('/dashboard/chart-data', [AdminDashboardController::class, 'chartData'])->name('dashboard.chart-data');

    // Books
    Route::get('books/export', [AdminBookController::class, 'export'])->name('books.export');
    Route::post('books/{id}/restore', [AdminBookController::class, 'restore'])->name('books.restore');
    Route::delete('books/{id}/force-delete', [AdminBookController::class, 'forceDelete'])->name('books.force-delete');
    Route::resource('books', AdminBookController::class);

    // Categories
    Route::resource('categories', AdminCategoryController::class)->except(['show']);

    // Members
    Route::resource('members', AdminMemberController::class);
    Route::patch('members/{member}/toggle-status', [AdminMemberController::class, 'toggleStatus'])->name('members.toggle-status');

    // Borrowings
    Route::get('borrowings', [AdminBorrowingController::class, 'index'])->name('borrowings.index');
    Route::get('borrowings/create', [AdminBorrowingController::class, 'create'])->name('borrowings.create');
    Route::post('borrowings', [AdminBorrowingController::class, 'store'])->name('borrowings.store');

    // Returns
    Route::get('returns', [AdminReturnController::class, 'index'])->name('returns.index');
    Route::post('returns/{borrowing}/process', [AdminReturnController::class, 'process'])->name('returns.process');

    // Fines
    Route::get('fines', [AdminFineController::class, 'index'])->name('fines.index');
    Route::post('fines/{fine}/pay', [AdminFineController::class, 'pay'])->name('fines.pay');

    // Reports
    Route::get('reports', [AdminReportController::class, 'index'])->name('reports.index');
});

/*
|--------------------------------------------------------------------------
| Member Routes (Protected: auth & role:member)
|--------------------------------------------------------------------------
*/
Route::prefix('member')->as('member.')->middleware(['auth', 'role:member'])->group(function () {
    Route::get('/dashboard', [MemberDashboardController::class, 'index'])->name('dashboard');

    // Books Catalog
    Route::get('/katalog', [MemberBookCatalogController::class, 'index'])->name('books.index');
    Route::get('/buku/{book}', [MemberBookCatalogController::class, 'show'])->name('books.show');

    // Borrowing Flow
    Route::post('/pinjam', [MemberBorrowingController::class, 'store'])->name('borrowings.store');
    Route::get('/peminjaman-saya', [MemberBorrowingController::class, 'current'])->name('borrowings.current');
    Route::get('/riwayat-peminjaman', [MemberBorrowingController::class, 'history'])->name('borrowings.history');
});

/*
|--------------------------------------------------------------------------
| Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
