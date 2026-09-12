<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PublicController extends Controller
{
    /**
     * Display the public landing page.
     */
    public function home(): View
    {
        $featuredBooks = Book::with('category')
            ->orderBy('publication_year', 'desc')
            ->take(6)
            ->get();

        $categories = Category::withCount('books')->get();

        $stats = [
            'total_books' => Book::sum('stock'),
            'total_titles' => Book::count(),
            'total_members' => User::where('role', 'member')->count(),
            'total_categories' => Category::count(),
        ];

        return view('welcome', compact('featuredBooks', 'categories', 'stats'));
    }

    /**
     * Display the public book catalog.
     */
    public function katalog(Request $request): View
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

        $books = $query->paginate(12)->withQueryString();
        $categories = Category::withCount('books')->get();

        return view('public.katalog', compact('books', 'categories'));
    }

    /**
     * Display the library info page.
     */
    public function tentang(): View
    {
        return view('public.tentang');
    }
}
