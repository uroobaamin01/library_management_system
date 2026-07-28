<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\Category\StoreCategoryRequest;
use App\Http\Requests\Admin\Category\UpdateCategoryRequest;
use App\Models\Category;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\View\View;

class CategoryController extends Controller
{
    public function index(): View
    {
        $categories = Category::withCount('books')->latest()->paginate(10);
        return view('admin.categories.index', compact('categories'));
    }

    public function create(): View
    {
        return view('admin.categories.create');
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['created_by'] = Auth::id();

        $category = Category::create($validated);

        ActivityLogService::log(
            'CREATE_CATEGORY',
            "Created category: {$category->name}",
            'Categories',
            $category->toArray()
        );

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function edit(Category $category): View
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(UpdateCategoryRequest $request, Category $category): RedirectResponse
    {
        $validated = $request->validated();
        $validated['slug'] = Str::slug($validated['name']);
        $validated['updated_by'] = Auth::id();

        $category->update($validated);

        ActivityLogService::log(
            'UPDATE_CATEGORY',
            "Updated category: {$category->name}",
            'Categories',
            $category->toArray()
        );

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(Category $category): RedirectResponse
    {
        if ($category->books()->count() > 0) {
            return back()->with('error', 'Cannot delete category containing linked books.');
        }

        $categoryName = $category->name;
        $category->delete();

        ActivityLogService::log(
            'DELETE_CATEGORY',
            "Deleted category: {$categoryName}",
            'Categories'
        );

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category soft-deleted successfully.');
    }
}