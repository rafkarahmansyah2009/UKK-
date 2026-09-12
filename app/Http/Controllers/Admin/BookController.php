<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Book;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of books.
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

        $books = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::all();

        return view('admin.books.index', compact('books', 'categories'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        $categories = Category::all();

        return view('admin.books.create', compact('categories'));
    }

    /**
     * Store a newly created book.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'publication_year' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'isbn' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'shelf_location' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'cover_file' => ['nullable', 'image', 'max:5120'], // max 5MB
            'cover_image_url' => ['nullable', 'url', 'max:1000'],
        ]);

        $coverImage = $validated['cover_image_url'] ?? null;

        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('covers', 'public');
            $coverImage = Storage::url($path);
        }

        $book = Book::create([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'author' => $validated['author'],
            'publisher' => $validated['publisher'],
            'publication_year' => $validated['publication_year'],
            'isbn' => $validated['isbn'] ?? null,
            'stock' => $validated['stock'],
            'available_stock' => $validated['stock'], // Initial available stock equals total stock
            'shelf_location' => $validated['shelf_location'] ?? null,
            'description' => $validated['description'] ?? null,
            'cover_image' => $coverImage,
        ]);

        ActivityLog::record('book_created', "Buku baru ditambahkan: '{$book->title}' oleh Admin.");

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan ke koleksi perpustakaan.');
    }

    /**
     * Show detail modal or view for a book.
     */
    public function show(Book $book): View
    {
        $book->load('category', 'borrowings.user');

        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the book.
     */
    public function edit(Book $book): View
    {
        $categories = Category::all();

        return view('admin.books.edit', compact('book', 'categories'));
    }

    /**
     * Update the specified book.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:255'],
            'author' => ['required', 'string', 'max:255'],
            'publisher' => ['required', 'string', 'max:255'],
            'publication_year' => ['required', 'integer', 'min:1900', 'max:'.(date('Y') + 1)],
            'isbn' => ['nullable', 'string', 'max:50'],
            'stock' => ['required', 'integer', 'min:0'],
            'shelf_location' => ['nullable', 'string', 'max:50'],
            'description' => ['nullable', 'string'],
            'cover_file' => ['nullable', 'image', 'max:5120'],
            'cover_image_url' => ['nullable', 'url', 'max:1000'],
        ]);

        $coverImage = $book->cover_image;
        if ($request->hasFile('cover_file')) {
            $path = $request->file('cover_file')->store('covers', 'public');
            $coverImage = Storage::url($path);
        } elseif (! empty($validated['cover_image_url'])) {
            $coverImage = $validated['cover_image_url'];
        }

        // Calculate available_stock adjustment safely
        $diff = $validated['stock'] - $book->stock;
        $newAvailable = max(0, min($validated['stock'], $book->available_stock + $diff));

        $book->update([
            'category_id' => $validated['category_id'],
            'title' => $validated['title'],
            'author' => $validated['author'],
            'publisher' => $validated['publisher'],
            'publication_year' => $validated['publication_year'],
            'isbn' => $validated['isbn'] ?? null,
            'stock' => $validated['stock'],
            'available_stock' => $newAvailable,
            'shelf_location' => $validated['shelf_location'] ?? null,
            'description' => $validated['description'] ?? null,
            'cover_image' => $coverImage,
        ]);

        ActivityLog::record('book_updated', "Data buku '{$book->title}' diperbarui oleh Admin.");

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');
    }

    /**
     * Remove the specified book.
     */
    public function destroy(Book $book): RedirectResponse
    {
        if ($book->borrowings()->where('status', 'borrowed')->exists()) {
            return back()->with('error', 'Buku tidak dapat dihapus karena saat ini sedang dipinjam oleh anggota.');
        }

        $title = $book->title;
        $book->delete();

        ActivityLog::record('book_deleted', "Buku '{$title}' dihapus dari sistem.");

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil dihapus dari koleksi.');
    }
}
