<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminLocationController extends Controller
{
    public function index()
    {
        $locations = Location::latest()->paginate(15);
        return view('admin.locations.index', compact('locations'));
    }

    public function create()
    {
        return view('admin.locations.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('locations', 'public');
            $data['image'] = '/storage/' . $imagePath;
        }

        Location::create($data);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location created successfully.');
    }

    public function show(Location $location)
    {
        return view('admin.locations.show', compact('location'));
    }

    public function edit(Location $location)
    {
        return view('admin.locations.edit', compact('location'));
    }

    public function update(Request $request, Location $location)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            if ($location->image && str_starts_with($location->image, '/storage/')) {
                Storage::disk('public')->delete(str_replace('/storage/', '', $location->image));
            }

            $imagePath = $request->file('image')->store('locations', 'public');
            $data['image'] = '/storage/' . $imagePath;
        } else {
            unset($data['image']);
        }

        $location->update($data);

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location updated successfully.');
    }

    public function destroy(Location $location)
    {
        if ($location->image && str_starts_with($location->image, '/storage/')) {
            Storage::disk('public')->delete(str_replace('/storage/', '', $location->image));
        }

        $location->delete();

        return redirect()->route('admin.locations.index')
            ->with('success', 'Location deleted successfully.');
    }
}
