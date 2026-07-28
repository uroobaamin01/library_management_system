<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ActivityLog;
use App\Models\Author;
use App\Models\Book;
use App\Models\Category;
use App\Models\Notification;
use App\Services\DashboardService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    protected DashboardService $dashboardService;

    public function __construct(DashboardService $dashboardService)
    {
        $this->dashboardService = $dashboardService;
    }

    public function index(): View
    {
        $metrics = $this->dashboardService->getMetrics();
        $chartData = $this->dashboardService->getChartData();

        $recentBooks = Book::with(['category', 'author'])->latest()->take(5)->get();
        $latestCategories = Category::withCount('books')->latest()->take(5)->get();
        $recentAuthors = Author::withCount('books')->latest()->take(5)->get();
        $latestNotifications = Notification::unread()->latest()->take(5)->get();
        $latestActivities = ActivityLog::with('user')->latest()->take(8)->get();

        return view('admin.dashboard', compact(
            'metrics',
            'chartData',
            'recentBooks',
            'latestCategories',
            'recentAuthors',
            'latestNotifications',
            'latestActivities'
        ));
    }
}