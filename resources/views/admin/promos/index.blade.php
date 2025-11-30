@extends('layout.mainlayout')

@section('title', 'Manage Promos')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-tags me-2 text-success"></i>Manage Promos</h2>
                <p class="text-muted">Total Promos: {{ $promos->total() }}</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.promos.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>Add New Promo
                </a>
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

        <div class="card shadow-sm">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead class="bg-light">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Discount</th>
                                <th>Duration</th>
                                <th>Products</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($promos as $promo)
                                <tr>
                                    <td>{{ $promo->id }}</td>
                                    <td>
                                        <i class="fas fa-tag me-2 text-success"></i>
                                        <strong>{{ $promo->name }}</strong>
                                    </td>
                                    <td>
                                        <span class="badge bg-danger">{{ $promo->discount_percentage }}% OFF</span>
                                    </td>
                                    <td>
                                        <small class="text-muted">
                                            {{ $promo->start_date->format('d M Y') }} - {{ $promo->end_date->format('d M Y') }}
                                        </small>
                                    </td>
                                    <td>
                                        <span class="badge bg-info">{{ $promo->products_count }} products</span>
                                    </td>
                                    <td>
                                        @if($promo->isActive())
                                            <span class="badge bg-success">Active</span>
                                        @else
                                            <span class="badge bg-secondary">Inactive</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.promos.show', $promo) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.promos.edit', $promo) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.promos.destroy', $promo) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this promo?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-danger">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="text-center py-4 text-muted">
                                        <i class="fas fa-tags fa-3x mb-3 d-block"></i>
                                        No promos found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $promos->links() }}
        </div>
    </div>
@endsection
