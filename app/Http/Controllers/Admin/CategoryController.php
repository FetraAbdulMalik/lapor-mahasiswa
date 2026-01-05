<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ReportCategory;
use Illuminate\Http\Request;

# ============================================================================
# CategoryController - Report Category Management
# ============================================================================
# Manages report categories (issue types) used for classification
# 
# Purpose: Create/manage issue type categories with colors and icons
# Features: CRUD, active/inactive toggle, report counting, dependency checks
# Use: Students select category when submitting reports for classification
#

class CategoryController extends Controller
{
    public function index()
    {
        $categories = ReportCategory::withCount('reports')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('admin.categories.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:report_categories,code',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
        ]);

        $validated['is_active'] = $request->has('is_active');

        ReportCategory::create($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully.');
    }

    public function show(ReportCategory $category)
    {
        $category->load(['reports' => function ($query) {
            $query->with(['user', 'facility'])->latest()->take(10);
        }]);

        return view('admin.categories.show', compact('category'));
    }

    public function edit(ReportCategory $category)
    {
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, ReportCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:50',
            'color' => 'nullable|string|max:7',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $category->update($validated);

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category updated successfully.');
    }

    public function destroy(ReportCategory $category)
    {
        if ($category->reports()->count() > 0) {
            return redirect()->route('admin.categories.index')
                ->with('error', 'Cannot delete category with existing reports.');
        }

        $category->delete();

        return redirect()->route('admin.categories.index')
            ->with('success', 'Category deleted successfully.');
    }

    public function toggle($id)
    {
        $category = ReportCategory::findOrFail($id);
        $category->is_active = !$category->is_active;
        $category->save();

        return response()->json([
            'success' => true,
            'is_active' => $category->is_active
        ]);
    }
}
