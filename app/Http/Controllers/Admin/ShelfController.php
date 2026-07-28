<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rack;
use App\Models\Shelf;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ShelfController extends Controller
{
    /**
     * Display a listing of the shelves and the create form modal data.
     */
    public function index(): View
    {
        $shelves = Shelf::with('rack')->latest()->paginate(10);

        // Safely fetch active racks using direct query condition
        $racks = Rack::where('status', 'active')->get();

        return view('admin.shelves.index', compact('shelves', 'racks'));
    }

    /**
     * Store a newly created shelf in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'rack_id' => 'required|exists:racks,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shelves,code',
            'capacity' => 'required|integer|min:1',
            'status' => 'nullable|in:active,inactive',
        ]);

        if (!isset($validated['status'])) {
            $validated['status'] = 'active';
        }

        Shelf::create($validated);

        return redirect()->route('admin.shelves.index')
            ->with('success', 'Shelf created successfully.');
    }

    /**
     * Update the specified shelf in storage.
     */
    public function update(Request $request, Shelf $shelf): RedirectResponse
    {
        $validated = $request->validate([
            'rack_id' => 'required|exists:racks,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:50|unique:shelves,code,' . $shelf->id,
            'capacity' => 'required|integer|min:1',
            'status' => 'required|in:active,inactive',
        ]);

        $shelf->update($validated);

        return redirect()->route('admin.shelves.index')
            ->with('success', 'Shelf updated successfully.');
    }

    /**
     * Remove the specified shelf from storage.
     */
    public function destroy(Shelf $shelf): RedirectResponse
    {
        $shelf->delete();

        return redirect()->route('admin.shelves.index')
            ->with('success', 'Shelf deleted successfully.');
    }
}