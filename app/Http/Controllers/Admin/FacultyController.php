<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    public function index()
    {
        $faculties = Faculty::withCount('departments')
            ->orderBy('name')
            ->paginate(20);

        return view('admin.faculties.index', compact('faculties'));
    }

    public function create()
    {
        return view('admin.faculties.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:faculties,code',
            'dean_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Faculty::create($validated);

        return redirect()->route('admin.faculties.index')
            ->with('success', 'Faculty created successfully.');
    }

    public function show(Faculty $faculty)
    {
        $faculty->load('departments');

        return view('admin.faculties.show', compact('faculty'));
    }

    public function edit(Faculty $faculty)
    {
        return view('admin.faculties.edit', compact('faculty'));
    }

    public function update(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:faculties,code,' . $faculty->id,
            'dean_name' => 'nullable|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $faculty->update($validated);

        return redirect()->route('admin.faculties.index')
            ->with('success', 'Faculty updated successfully.');
    }

    public function destroy(Faculty $faculty)
    {
        if ($faculty->departments()->count() > 0) {
            return redirect()->route('admin.faculties.index')
                ->with('error', 'Cannot delete faculty with existing departments.');
        }

        $faculty->delete();

        return redirect()->route('admin.faculties.index')
            ->with('success', 'Faculty deleted successfully.');
    }
}
