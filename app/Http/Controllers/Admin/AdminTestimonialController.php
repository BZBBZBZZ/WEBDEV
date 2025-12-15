<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class AdminTestimonialController extends Controller
{
    /**
     * Display a listing of all testimonials
     */
    public function index()
    {
        $testimonials = Testimonial::with('user')
            ->latest()
            ->paginate(15);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    /**
     * Remove the specified testimonial
     */
    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index')
            ->with('success', 'Testimonial deleted successfully!');
    }
}
