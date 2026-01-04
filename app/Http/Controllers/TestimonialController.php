<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoretestimonialRequest;
use App\Http\Requests\UpdatetestimonialRequest;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('user')
            ->latest()
            ->paginate(12);

        return view('testimonials.index', compact('testimonials'));
    }

    public function create()
    {
        $user = Auth::user();

        if (!$user->canCreateTestimonial()) {
            return redirect()->route('testimonials.index')
                ->with('error', 'You need to complete at least one paid transaction to create a testimonial.');
        }

        return view('testimonials.create');
    }

    public function store(Request $request)
    {
        $user = Auth::user();

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

    public function edit(Testimonial $testimonial)
    {
        if ($testimonial->user_id !== Auth::id()) {
            abort(403);
        }

        return view('testimonials.edit', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
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
