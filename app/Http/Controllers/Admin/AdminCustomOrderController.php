<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomOrder;
use Illuminate\Http\Request;

class AdminCustomOrderController extends Controller
{
    public function index()
    {
        $customOrders = CustomOrder::latest()->paginate(15);
        return view('admin.custom-orders.index', compact('customOrders'));
    }

    public function create()
    {
        return view('admin.custom-orders.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'order_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:not_made,in_progress,finished'],
        ]);

        CustomOrder::create($request->all());

        return redirect()->route('admin.custom-orders.index')
            ->with('success', 'Custom order created successfully.');
    }

    public function show(CustomOrder $customOrder)
    {
        return view('admin.custom-orders.show', compact('customOrder'));
    }

    public function edit(CustomOrder $customOrder)
    {
        return view('admin.custom-orders.edit', compact('customOrder'));
    }

    public function update(Request $request, CustomOrder $customOrder)
    {
        $request->validate([
            'customer_name' => ['required', 'string', 'max:255'],
            'order_name' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'status' => ['required', 'in:not_made,in_progress,finished'],
        ]);

        $customOrder->update($request->all());

        return redirect()->route('admin.custom-orders.index')
            ->with('success', 'Custom order updated successfully.');
    }

    public function destroy(CustomOrder $customOrder)
    {
        $customOrder->delete();

        return redirect()->route('admin.custom-orders.index')
            ->with('success', 'Custom order deleted successfully.');
    }
}
