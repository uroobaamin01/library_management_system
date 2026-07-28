<?php

namespace App\Services;

use App\Models\Author;
use App\Models\Book;
use App\Models\BookCopy;
use App\Models\Category;
use App\Models\DashboardStatistic;
use App\Models\Language;
use App\Models\Publisher;
use App\Models\Rack;
use App\Models\Shelf;

class DashboardService
{
    public function getMetrics(): array
    {
        $metrics = [
            'total_books' => Book::count(),
            'available_copies' => BookCopy::where('status', 'available')->count(),
            'issued_books' => BookCopy::where('status', 'issued')->count(),
            'lost_books' => BookCopy::where('status', 'lost')->count(),
            'total_authors' => Author::count(),
            'total_categories' => Category::count(),
            'total_publishers' => Publisher::count(),
            'total_languages' => Language::count(),
            'total_shelves' => Shelf::count(),
            'total_racks' => Rack::count(),
            'registered_students' => 0, // Placeholder until Student Module integration
            'active_librarians' => 0,   // Placeholder until Librarian Module integration
            'overdue_books' => 0,
            'returned_today' => 0,
            'pending_requests' => 0,
        ];

        foreach ($metrics as $key => $value) {
            DashboardStatistic::updateMetric($key, $value);
        }

        return $metrics;
    }

    public function getChartData(): array
    {
        $categoryData = Category::withCount('books')
            ->orderBy('books_count', 'desc')
            ->take(6)
            ->get();

        $booksPerCategory = [
            'labels' => $categoryData->pluck('name')->toArray(),
            'data' => $categoryData->pluck('books_count')->toArray(),
        ];

        $copyStatuses = [
            'available' => BookCopy::where('status', 'available')->count(),
            'issued' => BookCopy::where('status', 'issued')->count(),
            'reserved' => BookCopy::where('status', 'reserved')->count(),
            'lost' => BookCopy::where('status', 'lost')->count(),
            'damaged' => BookCopy::where('status', 'damaged')->count(),
        ];

        return [
            'books_per_category' => $booksPerCategory,
            'copy_status_distribution' => [
                'labels' => array_map('ucfirst', array_keys($copyStatuses)),
                'data' => array_values($copyStatuses),
            ],
        ];
    }
}