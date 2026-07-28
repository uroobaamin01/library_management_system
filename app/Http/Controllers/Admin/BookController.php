<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class BookController extends Controller
{
    /**
     * Display a listing of the books.
     */
    public function index(Request $request): View
    {
        $query = Book::with(['category', 'author', 'publisher', 'language'])
            ->withCount('copies');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('author_id')) {
            $query->where('author_id', $request->author_id);
        }

        $books = $query->latest()->paginate(10)->withQueryString();
        $categories = Category::active()->get();
        $authors = Author::active()->get();

        return view('admin.books.index', compact('books', 'categories', 'authors'));
    }

    /**
     * Show the form for creating a new book.
     */
    public function create(): View
    {
        $categories = Category::active()->get();
        $authors = Author::active()->get();
        $publishers = Publisher::active()->get();
        $languages = Language::active()->get();

        return view('admin.books.create', compact('categories', 'authors', 'publishers', 'languages'));
    }

    /**
     * Store a newly created book in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'language_id' => 'nullable|exists:languages,id',
            'isbn' => 'required|string|unique:books,isbn|max:20',
            'edition' => 'nullable|integer|min:1',
            'publish_year' => 'nullable|integer|digits:4',
            'price' => 'nullable|numeric|min:0',
            'summary' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,discontinued',
        ]);

        $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books/covers', 'public');
            $validated['cover_image'] = $path;
        }

        Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book created successfully.');
    }

    /**
     * Display the specified book.
     */
    public function show(Book $book): View
    {
        // Safe relationship eager loading
        $relations = ['category', 'author', 'publisher', 'language', 'copies'];
        
        // Dynamically check if images relationship method exists before loading
        if (method_exists($book, 'images')) {
            $relations[] = 'images';
        }

        $book->load($relations);

        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified book.
     */
    public function edit(Book $book): View
    {
        $categories = Category::active()->get();
        $authors = Author::active()->get();
        $publishers = Publisher::active()->get();
        $languages = Language::active()->get();

        return view('admin.books.edit', compact('book', 'categories', 'authors', 'publishers', 'languages'));
    }

    /**
     * Update the specified book in storage.
     */
    public function update(Request $request, Book $book): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'author_id' => 'required|exists:authors,id',
            'publisher_id' => 'nullable|exists:publishers,id',
            'language_id' => 'nullable|exists:languages,id',
            'isbn' => 'required|string|max:20|unique:books,isbn,' . $book->id,
            'edition' => 'nullable|integer|min:1',
            'publish_year' => 'nullable|integer|digits:4',
            'price' => 'nullable|numeric|min:0',
            'summary' => 'nullable|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'status' => 'required|in:available,discontinued',
        ]);

        if ($request->title !== $book->title) {
            $validated['slug'] = Str::slug($validated['title']) . '-' . Str::random(5);
        }

        if ($request->hasFile('cover_image')) {
            $path = $request->file('cover_image')->store('books/covers', 'public');
            $validated['cover_image'] = $path;
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Book updated successfully.');
    }

    /**
     * Remove the specified book from storage.
     */
    public function destroy(Book $book): RedirectResponse
    {
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Book deleted successfully.');
    }
}