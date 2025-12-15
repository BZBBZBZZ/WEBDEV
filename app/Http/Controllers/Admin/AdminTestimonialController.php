<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    // Admin list semua testimoni
    public function index()
    {
        $testimonials = Testimonial::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    // Admin delete testimoni
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully!');
    }
}