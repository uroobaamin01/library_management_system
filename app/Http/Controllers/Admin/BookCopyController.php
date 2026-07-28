<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookCopy;
use App\Services\ActivityLogService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class BookCopyController extends Controller
{
    public function updateStatus(Request $request, BookCopy $copy): RedirectResponse
    {
        $validated = $request->validate([
            'status' => 'required|in:available,issued,reserved,lost,damaged,maintenance',
            'condition' => 'required|in:new,good,fair,poor',
        ]);

        $copy->update($validated);

        ActivityLogService::log(
            'UPDATE_COPY_STATUS',
            "Updated copy {$copy->barcode} status to {$copy->status}",
            'BookCopies'
        );

        return back()->with('success', 'Book copy status updated successfully.');
    }
}