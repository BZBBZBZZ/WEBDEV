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

                            <div class="mb-4">
                                <label for="testimonial" class="form-label fw-semibold">
                                    <i class="fas fa-comments me-2"></i>Your Testimonial
                                </label>
                                <textarea class="form-control @error('testimonial') is-invalid @enderror" id="testimonial" name="testimonial"
                                    rows="6" placeholder="Share your experience with us..." required>{{ old('testimonial') }}</textarea>
                                @error('testimonial')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Minimum 10 characters, maximum 1000 characters</small>
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Submit Testimonial
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
