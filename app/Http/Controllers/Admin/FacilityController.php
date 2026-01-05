<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Facility;
use App\Models\Building;
use Illuminate\Http\Request;

# ============================================================================
# FacilityController - Facility (Room/Space) Management
# ============================================================================
# Manages individual facilities/spaces within buildings
# 
# Purpose: Create/manage specific rooms, labs, classrooms in buildings
# Features: CRUD, building association, type tracking, capacity management
# Use: Track specific facilities where issues are reported (which lab, room)
#

class FacilityController extends Controller
{
    public function index()
    {
        $facilities = Facility::with('building')
            ->orderBy('name')
            ->paginate(20);

        $total_facilities = Facility::count();
        $active_facilities = Facility::where('is_active', true)->count();
        $facility_types = Facility::distinct()->count('type');

        return view('admin.facilities.index', compact('facilities', 'total_facilities', 'active_facilities', 'facility_types'));
    }

    public function create()
    {
        $buildings = Building::orderBy('name')->get();

        return view('admin.facilities.create', compact('buildings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:facilities,code',
            'floor' => 'nullable|integer',
            'room_number' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer',
            'type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        Facility::create($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Facility created successfully.');
    }

    public function show(Facility $facility)
    {
        $facility->load(['building', 'reports' => function ($query) {
            $query->latest()->take(10);
        }]);

        return view('admin.facilities.show', compact('facility'));
    }

    public function edit(Facility $facility)
    {
        $buildings = Building::orderBy('name')->get();

        return view('admin.facilities.edit', compact('facility', 'buildings'));
    }

    public function update(Request $request, Facility $facility)
    {
        $validated = $request->validate([
            'building_id' => 'required|exists:buildings,id',
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:facilities,code,' . $facility->id,
            'floor' => 'nullable|integer',
            'room_number' => 'nullable|string|max:20',
            'capacity' => 'nullable|integer',
            'type' => 'nullable|string|max:50',
            'description' => 'nullable|string',
        ]);

        $validated['is_active'] = $request->has('is_active');

        $facility->update($validated);

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Facility updated successfully.');
    }

    public function destroy(Facility $facility)
    {
        if ($facility->reports()->count() > 0) {
            return redirect()->route('admin.facilities.index')
                ->with('error', 'Cannot delete facility with existing reports.');
        }

        $facility->delete();

        return redirect()->route('admin.facilities.index')
            ->with('success', 'Facility deleted successfully.');
    }
}
