<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    public function index()
    {
        $buildings = Building::withCount('facilities')
            ->orderBy('name')
            ->paginate(20);

        $total_buildings = Building::count();
        $total_facilities = \App\Models\Facility::count();
        $avg_facilities = $total_buildings > 0 ? round($total_facilities / $total_buildings, 1) : 0;

        return view('admin.buildings.index', compact('buildings', 'total_buildings', 'total_facilities', 'avg_facilities'));
    }

    public function create()
    {
        return view('admin.buildings.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:buildings,code',
            'floors' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        Building::create($validated);

        return redirect()->route('admin.buildings.index')
            ->with('success', 'Building created successfully.');
    }

    public function show(Building $building)
    {
        $building->load('facilities');

        return view('admin.buildings.show', compact('building'));
    }

    public function edit(Building $building)
    {
        return view('admin.buildings.edit', compact('building'));
    }

    public function update(Request $request, Building $building)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'required|string|max:10|unique:buildings,code,' . $building->id,
            'floors' => 'nullable|integer|min:1',
            'description' => 'nullable|string',
        ]);

        $building->update($validated);

        return redirect()->route('admin.buildings.index')
            ->with('success', 'Building updated successfully.');
    }

    public function destroy(Building $building)
    {
        if ($building->facilities()->count() > 0) {
            return redirect()->route('admin.buildings.index')
                ->with('error', 'Cannot delete building with existing facilities.');
        }

        $building->delete();

        return redirect()->route('admin.buildings.index')
            ->with('success', 'Building deleted successfully.');
    }
}
