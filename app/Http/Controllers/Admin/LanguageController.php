<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Language;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LanguageController extends Controller
{
    public function index(): View
    {
        $languages = Language::withCount('books')->get();
        return view('admin.languages.index', compact('languages'));
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:languages,name',
            'code' => 'required|string|max:10|unique:languages,code',
        ]);

        Language::create($validated);
        ActivityLogService::log('CREATE_LANGUAGE', "Added language: {$request->name}", 'Languages');

        return back()->with('success', 'Language created successfully.');
    }
}