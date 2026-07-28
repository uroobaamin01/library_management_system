<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publisher;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PublisherController extends Controller
{
    public function index(): View
    {
        $publishers = Publisher::withCount('books')->latest()->paginate(10);
        return view('admin.publishers.index', compact('publishers'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:publishers,name',
            'email' => 'nullable|email',
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = Auth::id();

        $publisher = Publisher::create($validated);

        ActivityLogService::log('CREATE_PUBLISHER', "Created publisher: {$publisher->name}", 'Publishers');

        return back()->with('success', 'Publisher added successfully.');
    }

    public function destroy(Publisher $publisher): RedirectResponse
    {
        if ($publisher->books()->count() > 0) {
            return back()->with('error', 'Publisher has active books attached.');
        }

        $publisher->delete();
        ActivityLogService::log('DELETE_PUBLISHER', 'Deleted a publisher record', 'Publishers');

        return back()->with('success', 'Publisher removed successfully.');
    }
}