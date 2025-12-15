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

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($testimonials->count() > 0)
            <div class="card shadow-sm">
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Testimonial</th>
                                    <th>Date</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($testimonials as $testimonial)
                                    <tr>
                                        <td>{{ $testimonial->id }}</td>
                                        <td>
                                            <i class="fas fa-user me-2 text-primary"></i>
                                            <strong>{{ $testimonial->user->name }}</strong>
                                        </td>
                                        <td>
                                            <span class="text-muted">
                                                {{ Str::limit($testimonial->testimonial, 100) }}
                                            </span>
                                        </td>
                                        <td>{{ $testimonial->created_at->format('d M Y') }}</td>
                                        <td>
                                            <form action="{{ route('admin.testimonials.destroy', $testimonial) }}" 
                                                  method="POST" 
                                                  class="d-inline"
                                                  onsubmit="return confirm('Are you sure you want to delete this testimonial?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger btn-sm">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="mt-4">
                {{ $testimonials->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-comments fa-5x text-muted mb-3"></i>
                <h4 class="text-muted">No testimonials yet</h4>
            </div>
        @endif
    </div>
@endsection