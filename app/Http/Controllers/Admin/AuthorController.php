<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Author\StoreAuthorRequest;
use App\Http\Requests\Admin\Author\UpdateAuthorRequest;
use App\Models\Author;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthorController extends Controller
{
    public function index(): View
    {
        $authors = Author::withCount('books')->latest()->paginate(10);
        return view('admin.authors.index', compact('authors'));
    }

    public function create(): View
    {
        return view('admin.authors.create');
    }

    public function store(StoreAuthorRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = Auth::id();

        $author = Author::create($validated);

        ActivityLogService::log('CREATE_AUTHOR', "Created author: {$author->name}", 'Authors', $author->toArray());

        return redirect()->route('admin.authors.index')->with('success', 'Author created successfully.');
    }

    public function edit(Author $author): View
    {
        return view('admin.authors.edit', compact('author'));
    }

    public function update(UpdateAuthorRequest $request, Author $author): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['updated_by'] = Auth::id();

        $author->update($validated);

        ActivityLogService::log('UPDATE_AUTHOR', "Updated author: {$author->name}", 'Authors', $author->toArray());

        return redirect()->route('admin.authors.index')->with('success', 'Author updated successfully.');
    }

    public function destroy(Author $author): RedirectResponse
    {
        if ($author->books()->count() > 0) {
            return back()->with('error', 'Cannot delete author with associated books.');
        }

        $authorName = $author->name;
        $author->delete();

        ActivityLogService::log('DELETE_AUTHOR', "Deleted author: {$authorName}", 'Authors');

        return redirect()->route('admin.authors.index')->with('success', 'Author deleted successfully.');
    }
}