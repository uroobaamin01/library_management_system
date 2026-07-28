<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Language;
use App\Models\Publisher;
use Illuminate\Http\Request;

class BookCatalogController extends Controller
{
    /**
     * Display searchable book catalog using Admin catalog data.
     */
    public function index(Request $request)
    {
        $query = Book::with(['category', 'author', 'publisher', 'language', 'copies']);

        // Search Filter (Book Name / ISBN)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('isbn', 'like', "%{$search}%");
            });
        }

        // Category Filter
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // Author Filter
        if ($request->filled('author')) {
            $query->where('author_id', $request->author);
        }

        // Publisher Filter
        if ($request->filled('publisher')) {
            $query->where('publisher_id', $request->publisher);
        }

        // Language Filter
        if ($request->filled('language')) {
            $query->where('language_id', $request->language);
        }

        $books = $query->paginate(12)->withQueryString();

        // Filter Options fetched directly from Admin tables
        $categories = Category::all();
        $authors = Author::all();
        $publishers = Publisher::all();
        $languages = Language::all();

        return view('frontend.books.index', compact('books', 'categories', 'authors', 'publishers', 'languages'));
    }

    /**
     * Display Single Book Details.
     */
    public function show(Book $book)
    {
        // Removed non-existent relationships 'rack' and 'shelf' from eager loading
        $book->load(['category', 'author', 'publisher', 'language', 'copies']);
        
        // Related Books from same category
        $relatedBooks = Book::where('category_id', $book->category_id)
            ->where('id', '!=', $book->id)
            ->take(4)
            ->get();

        return view('frontend.books.show', compact('book', 'relatedBooks'));
    }
}