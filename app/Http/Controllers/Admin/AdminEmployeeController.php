<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminEmployeeController extends Controller
{
    public function index()
    {
        $employees = Employee::latest()->paginate(15);
        return view('admin.employees.index', compact('employees'));
    }

    public function create()
    {
        return view('admin.employees.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'image' => ['required', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('employees', env('FILESYSTEM_DISK', 'public'));
            $data['image'] = Storage::url($imagePath);
        }

        Employee::create($data);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee created successfully.');
    }

    public function show(Employee $employee)
    {
        return view('admin.employees.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('admin.employees.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'position' => ['required', 'string', 'max:255'],
            'image' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
        ]);

        $data = $request->all();

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($employee->image) {
                $oldPath = str_replace(Storage::url(''), '', $employee->image);
                Storage::disk(env('FILESYSTEM_DISK', 'public'))->delete($oldPath);
            }

            $imagePath = $request->file('image')->store('employees', env('FILESYSTEM_DISK', 'public'));
            $data['image'] = Storage::url($imagePath);
        } else {
            unset($data['image']); 
        }

        $employee->update($data);

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee updated successfully.');
    }

    public function destroy(Employee $employee)
    {       
        if ($employee->image) {
            $oldPath = str_replace(Storage::url(''), '', $employee->image);
            Storage::disk(env('FILESYSTEM_DISK', 'public'))->delete($oldPath);
        }

        $employee->delete();

        return redirect()->route('admin.employees.index')
            ->with('success', 'Employee deleted successfully.');
    }
}