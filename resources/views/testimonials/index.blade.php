@extends('layout.mainlayout')

@section('title', 'Customer Testimonials')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-8">
                <h2><i class="fas fa-comments me-2 text-primary"></i>Customer Testimonials</h2>
                <p class="text-muted">See what our customers say about us</p>
            </div>
            <div class="col-md-4 text-end">
                @auth
                    @if (Auth::user()->testimonial)
                        <a href="{{ route('testimonials.edit', Auth::user()->testimonial) }}" class="btn btn-warning">
                            <i class="fas fa-edit me-2"></i>Edit My Testimonial
                        </a>
                    @elseif(Auth::user()->canCreateTestimonial())
                        <a href="{{ route('testimonials.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>Write Testimonial
                        </a>
                    @endif
                @endauth
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show">
                <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if ($testimonials->count() > 0)
            <div class="row g-4">
                @foreach ($testimonials as $testimonial)
                    <div class="col-md-6">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <div class="d-flex align-items-center mb-3">
                                    <div class="bg-primary rounded-circle d-flex align-items-center justify-content-center"
                                        style="width: 50px; height: 50px;">
                                        <i class="fas fa-user fa-2x text-white"></i>
                                    </div>
                                    <div class="ms-3">
                                        <h5 class="mb-0">{{ $testimonial->user->name }}</h5>
                                        <small class="text-muted">{{ $testimonial->created_at->format('d M Y') }}</small>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <i class="fas fa-quote-left text-primary me-2"></i>
                                    <p class="mb-0 text-muted">{{ $testimonial->testimonial }}</p>
                                    <i class="fas fa-quote-right text-primary ms-2"></i>
                                </div>

                                @auth
                                    @if ($testimonial->user_id === Auth::id())
                                        <div class="d-flex gap-2">
                                            <a href="{{ route('testimonials.edit', $testimonial) }}"
                                                class="btn btn-sm btn-warning">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <form action="{{ route('testimonials.destroy', $testimonial) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete your testimonial?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    @endif
                                @endauth
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $testimonials->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-comments fa-5x text-muted mb-3"></i>
                <h4 class="text-muted">No testimonials yet</h4>
                <p class="text-muted">Be the first to share your experience!</p>
                @auth
                    @if (Auth::user()->canCreateTestimonial())
                        <a href="{{ route('testimonials.create') }}" class="btn btn-primary mt-3">
                            <i class="fas fa-plus me-2"></i>Write First Testimonial
                        </a>
                    @endif
                @endauth
            </div>
        @endif
    </div>
@endsection
