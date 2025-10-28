<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->has('search')) {
            $products = Product::with('category')
                ->where('name', 'like', '%' . $request->search . '%')
                ->orWhere('short_description', 'like', '%' . $request->search . '%')
                ->orWhereHas('category', function($query) use ($request) {
                    $query->where('name', 'like', '%' . $request->search . '%');
                })
                ->paginate(9)
                ->withQueryString();
        } else {
            $products = Product::with('category')->paginate(9);
        }
        
        return view('products', compact('products'));
    }

    public function show(Product $product)
    {
        $product->load('category');
        
        return view('productdetails', compact('product'));
    }
}
