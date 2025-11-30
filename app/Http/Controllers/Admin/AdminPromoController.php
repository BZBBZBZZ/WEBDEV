<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Promo;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminPromoController extends Controller
{
    public function index()
    {
        $promos = Promo::withCount('products')->latest()->paginate(15);
        return view('admin.promos.index', compact('promos'));
    }

    public function create()
    {
        $products = Product::all();
        return view('admin.promos.create', compact('products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'discount_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'products' => ['array'],
            'products.*' => ['exists:products,id']
        ]);

        $promo = Promo::create($request->only(['name', 'discount_percentage', 'start_date', 'end_date']));
        
        if ($request->has('products')) {
            $promo->products()->attach($request->products);
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo created successfully.');
    }

    public function show(Promo $promo)
    {
        $promo->load('products');
        return view('admin.promos.show', compact('promo'));
    }

    public function edit(Promo $promo)
    {
        $products = Product::all();
        $promo->load('products');
        return view('admin.promos.edit', compact('promo', 'products'));
    }

    public function update(Request $request, Promo $promo)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'discount_percentage' => ['required', 'integer', 'min:1', 'max:100'],
            'start_date' => ['required', 'date'],
            'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            'products' => ['array'],
            'products.*' => ['exists:products,id']
        ]);

        $promo->update($request->only(['name', 'discount_percentage', 'start_date', 'end_date']));
        
        if ($request->has('products')) {
            $promo->products()->sync($request->products);
        } else {
            $promo->products()->detach();
        }

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo updated successfully.');
    }

    public function destroy(Promo $promo)
    {
        $promo->products()->detach();
        $promo->delete();

        return redirect()->route('admin.promos.index')
            ->with('success', 'Promo deleted successfully.');
    }
}
