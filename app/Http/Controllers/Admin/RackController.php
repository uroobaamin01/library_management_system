<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Rack;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class RackController extends Controller
{
    public function index(): View
    {
        $racks = Rack::withCount('shelves')->latest()->paginate(10);
        return view('admin.racks.index', compact('racks'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:racks,name',
            'code' => 'required|string|max:50|unique:racks,code',
            'description' => 'nullable|string',
        ]);

        Rack::create($validated);
        ActivityLogService::log('CREATE_RACK', "Created Rack: {$request->name}", 'Locations');

        return back()->with('success', 'Rack added successfully.');
    }
}