<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Category;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(): View
    {
        $categories = Category::withCount('books')->latest()->paginate(10);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create(): View
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:20', 'unique:categories,code'],
            'description' => ['nullable', 'string'],
        ]);

        $category = Category::create($validated);

        ActivityLog::record('category_created', "Kategori '{$category->name}' ({$category->code}) ditambahkan.");

        return redirect()->route('admin.categories.index')->with('success', 'Kategori buku berhasil ditambahkan.');
    }

    /**
     * Show the form for editing the category.
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:100'],
            'code' => ['required', 'string', 'max:20', 'unique:categories,code,'.$category->id],
            'description' => ['nullable', 'string'],
        ]);

        $category->update($validated);

        ActivityLog::record('category_updated', "Kategori '{$category->name}' diperbarui.");

        return redirect()->route('admin.categories.index')->with('success', 'Kategori buku berhasil diperbarui.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category): RedirectResponse
    {
        if ($category->books()->withTrashed()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih memiliki koleksi buku.');
        }

        $name = $category->name;
        $category->delete();

        ActivityLog::record('category_deleted', "Kategori '{$name}' telah dihapus.");

        return redirect()->route('admin.categories.index')->with('success', 'Kategori buku berhasil dihapus.');
    }
}
