<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoretestimonialRequest;
use App\Http\Requests\UpdatetestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $testimonials = Testimonial::with('user')
            ->latest()
            ->paginate(12);

        return view('testimonials.index', compact('testimonials'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();

        // Validasi: User harus punya transaksi paid
        if (!$user->canCreateTestimonial()) {
            return redirect()->route('testimonials.index')
                ->with('error', 'You need to complete at least one paid transaction to create a testimonial.');
        }

        return view('testimonials.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::user();

        // Validasi: User harus punya transaksi paid dan belum punya testimoni
        if (!$user->canCreateTestimonial()) {
            return redirect()->route('testimonials.index')
                ->with('error', 'You cannot create a testimonial.');
        }

        $request->validate([
            'testimonial' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        Testimonial::create([
            'user_id' => $user->id,
            'testimonial' => $request->testimonial,
        ]);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(testimonial $testimonial)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Testimonial $testimonial)
    {
        // Validasi: User hanya bisa edit testimoninya sendiri
        if ($testimonial->user_id !== Auth::id()) {
            abort(403);
        }

        return view('testimonials.edit', compact('testimonial'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Testimonial $testimonial)
    {
        // Validasi: User hanya bisa edit testimoninya sendiri
        if ($testimonial->user_id !== Auth::id()) {
            abort(403);
        }

        $request->validate([
            'testimonial' => ['required', 'string', 'min:10', 'max:1000'],
        ]);

        $testimonial->update([
            'testimonial' => $request->testimonial,
        ]);

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Testimonial $testimonial)
    {
        // Validasi: User hanya bisa delete testimoninya sendiri
        if ($testimonial->user_id !== Auth::id()) {
            abort(403);
        }

        $testimonial->delete();

        return redirect()->route('testimonials.index')
            ->with('success', 'Testimonial deleted successfully!');
    }
}
