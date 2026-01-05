<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Faculty;
use Illuminate\Http\Request;

# ============================================================================
# DepartmentController - Academic Department Management
# ============================================================================
# Manages academic departments within faculties
# 
# Purpose: Create/manage departments under faculties with leadership info
# Features: CRUD, faculty association, active/inactive, student tracking
# Use: Organize academic structure, track student demographics
#

class DepartmentController extends Controller
{
    public function index()
    {
        $departments = Department::with('faculty')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.departments.index', compact('departments'));
    }

    public function create()
    {
        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();

        return view('admin.departments.create', compact('faculties'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code',
            'head_of_department' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Department::create($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department created successfully.');
    }

    public function show(Department $department)
    {
        $department->load(['faculty', 'studentProfiles']);

        return view('admin.departments.show', compact('department'));
    }

    public function edit(Department $department)
    {
        $faculties = Faculty::where('is_active', true)->orderBy('name')->get();

        return view('admin.departments.edit', compact('department', 'faculties'));
    }

    public function update(Request $request, Department $department)
    {
        $validated = $request->validate([
            'faculty_id' => 'required|exists:faculties,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:departments,code,' . $department->id,
            'head_of_department' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $department->update($validated);

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department updated successfully.');
    }

    public function destroy(Department $department)
    {
        if ($department->studentProfiles()->count() > 0) {
            return redirect()->route('admin.departments.index')
                ->with('error', 'Cannot delete department with existing students.');
        }

        $department->delete();

        return redirect()->route('admin.departments.index')
            ->with('success', 'Department deleted successfully.');
    }
}
