<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Publisher;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Render landing page with statistics and active catalog collections.
     */
    public function index()
    {
        // Dynamic Counts for Hero Stats
        $stats = [
            'total_books' => Book::count(),
            'total_authors' => Author::count(),
            'total_students' => User::where('role', 'student')->count(),
            'total_publishers' => Publisher::count(),
        ];

        // Fetch categories with book counts
        $categories = Category::withCount('books')->latest()->take(8)->get();

        // Featured, Latest, and Popular Books from Admin Catalog
        $featuredBooks = Book::with(['category', 'author', 'publisher'])
            ->where('is_featured', true)
            ->latest()
            ->take(6)
            ->get();

        $latestBooks = Book::with(['category', 'author', 'publisher'])
            ->latest()
            ->take(8)
            ->get();

        // Dynamic Authors & Publishers
        $authors = Author::latest()->take(6)->get();
        $publishers = Publisher::latest()->take(6)->get();

        return view('frontend.home', compact('stats', 'categories', 'featuredBooks', 'latestBooks', 'authors', 'publishers'));
    }
}