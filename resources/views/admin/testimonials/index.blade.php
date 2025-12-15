@extends('layout.mainlayout')

@section('title', 'Manage Testimonials')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-12">
                <h2><i class="fas fa-comments me-2 text-primary"></i>Manage Testimonials</h2>
                <p class="text-muted">Total Testimonials: {{ $testimonials->total() }}</p>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Testimonial</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($testimonials as $testimonial)
                                <tr>
                                    <td>{{ $testimonial->id }}</td>
                                    <td>
                                        <strong>{{ $testimonial->user->name }}</strong><br>
                                        <small class="text-muted">{{ $testimonial->user->email }}</small>
                                    </td>
                                    <td>{{ Str::limit($testimonial->testimonial, 80) }}</td>
                                    <td>{{ $testimonial->created_at->format('d M Y') }}</td>
                                    <td>
                                        <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" method="POST" 
                                              onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger">
                                                <i class="fas fa-trash"></i> Delete
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-4">
                                        <i class="fas fa-comments fa-3x text-muted mb-3 d-block"></i>
                                        <p class="text-muted">No testimonials found</p>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $testimonials->links() }}
        </div>
    </div>
@endsection
