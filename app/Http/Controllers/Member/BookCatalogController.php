<?php

namespace App\Http\Controllers\Member;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BookCatalogController extends Controller
{
    /**
     * Display the member book catalog.
     */
    public function index(Request $request): View
    {
        $query = Book::with('category');

        if ($request->filled('q')) {
            $searchTerm = $request->input('q');
            $query->where(function ($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                    ->orWhere('author', 'like', "%{$searchTerm}%")
                    ->orWhere('isbn', 'like', "%{$searchTerm}%");
            });
        }

        if ($request->filled('kategori')) {
            $query->where('category_id', $request->input('kategori'));
        }

        $books = $query->latest()->paginate(8)->withQueryString();
        $categories = Category::withCount('books')->get();

        return view('member.books.index', compact('books', 'categories'));
    }

    /**
     * Display the specified book detail.
     */
    public function show(Book $book): View
    {
        $book->load('category');
        $user = auth()->user();

        // Check if user currently has an active borrowing of this book
        $hasActiveBorrowing = $user->borrowings()
            ->where('book_id', $book->id)
            ->whereIn('status', ['borrowed', 'overdue'])
            ->exists();

        return view('member.books.show', compact('book', 'hasActiveBorrowing'));
    }
}
