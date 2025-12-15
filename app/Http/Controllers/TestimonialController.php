<?php

namespace App\Http\Controllers;

use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of testimonials
     */
    public function index()
    {
        $testimonials = Testimonial::with('user')
            ->latest()
            ->paginate(12);

        $canCreate = Auth::check() ? Auth::user()->canCreateTestimonial() : false;

        return view('testimonials.index', compact('testimonials', 'canCreate'));
    }

    /**
     * Show the form for creating a new testimonial
     */
    public function create()
    {
        if (!Auth::user()->canCreateTestimonial()) {
            return redirect()->route('testimonials.index')
                ->with('error', 'You need at least 1 paid transaction to create a testimonial, or you already have one.');
        }

        return view('testimonials.create');
    }

    /**
     * Store a newly created testimonial
     */
    public function store(Request $request)
    {
        if (!Auth::user()->canCreateTestimonial()) {
            return redirect()->route('testimonials.index')
                ->with('error', 'You cannot create a testimonial at this time.');
        }

        $request->validate([
            'testimonial' => 'required|string|min:10|max:1000',
        ]);

        Testimonial::create([
            'user_id' => Auth::id(),
            'testimonial' => $request->testimonial,
        ]);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial created successfully!');
    }

    /**
     * Show the form for editing the testimonial
     */
    public function edit(Testimonial $testimonial)
    {
        if ($testimonial->user_id !== Auth::id()) {
            abort(403);
        }

        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the testimonial
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        if ($testimonial->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'testimonial' => 'required|string|min:10|max:1000',
        ]);

        $testimonial->update([
            'testimonial' => $request->testimonial,
        ]);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial updated successfully!');
    }

    /**
     * Remove the testimonial
     */
    public function destroy(Testimonial $testimonial)
    {
        if ($testimonial->user_id !== Auth::id()) {
            abort(403);
        }

        $testimonial->delete();

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial deleted successfully!');
    }
}
