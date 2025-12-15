@extends('layout.mainlayout')

@section('title', 'Write Testimonial')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0"><i class="fas fa-pen me-2"></i>Write Your Testimonial</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('testimonials.store') }}" method="POST">
                            @csrf

                            <div class="alert alert-info">
                                <i class="fas fa-info-circle me-2"></i>
                                Share your experience with Po Bakery! Your testimonial will be visible to all visitors.
                            </div>

                            <div class="mb-4">
                                <label for="testimonial" class="form-label fw-semibold">
                                    <i class="fas fa-comment me-2"></i>Your Testimonial
                                </label>
                                <textarea class="form-control @error('testimonial') is-invalid @enderror" 
                                          id="testimonial" name="testimonial" rows="6" 
                                          placeholder="Tell us about your experience..." required>{{ old('testimonial') }}</textarea>
                                <small class="text-muted">Minimum 10 characters, maximum 1000 characters</small>
                                @error('testimonial')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-check me-2"></i>Submit Testimonial
                                </button>
                                <a href="{{ route('testimonials.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-times me-2"></i>Cancel
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
