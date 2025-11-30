@extends('layout.mainlayout')

@section('title', 'Manage Custom Orders')

@section('content')
    <div class="container py-5">
        <div class="row mb-4">
            <div class="col-md-6">
                <h2><i class="fas fa-clipboard-list me-2 text-warning"></i>Manage Custom Orders</h2>
                <p class="text-muted">Total Orders: {{ $customOrders->total() }}</p>
            </div>
            <div class="col-md-6 text-end">
                <a href="{{ route('admin.custom-orders.create') }}" class="btn btn-warning">
                    <i class="fas fa-plus me-2"></i>Add New Custom Order
                </a>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show">
                <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
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
                                <th>Customer</th>
                                <th>Order Name</th>
                                <th>Description</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customOrders as $order)
                                <tr>
                                    <td>{{ $order->id }}</td>
                                    <td>
                                        <i class="fas fa-user me-2 text-primary"></i>
                                        <strong>{{ $order->customer_name }}</strong>
                                    </td>
                                    <td>{{ $order->order_name }}</td>
                                    <td>{{ Str::limit($order->description, 50) }}</td>
                                    <td>
                                        <span class="badge {{ $order->getStatusBadgeClass() }}">
                                            {{ $order->getStatusLabel() }}
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="{{ route('admin.custom-orders.show', $order) }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="{{ route('admin.custom-orders.edit', $order) }}" class="btn btn-warning">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="{{ route('admin.custom-orders.destroy', $order) }}" method="POST"
                                                class="d-inline"
                                                onsubmit="return confirm('Are you sure you want to delete this order?')">
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
                                    <td colspan="6" class="text-center py-4 text-muted">
                                        <i class="fas fa-clipboard-list fa-3x mb-3 d-block"></i>
                                        No custom orders found.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="mt-4">
            {{ $customOrders->links() }}
        </div>
    </div>
@endsection
