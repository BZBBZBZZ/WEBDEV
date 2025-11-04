@extends('layout.mainlayout')

@section('title', 'User Details')

@section('content')
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card shadow-sm">
                    <div class="card-header bg-info text-white">
                        <h4 class="mb-0"><i class="fas fa-user me-2"></i>User Details</h4>
                    </div>
                    <div class="card-body p-4">
                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">ID:</div>
                            <div class="col-md-8">{{ $user->id }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Full Name:</div>
                            <div class="col-md-8">{{ $user->name }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Email:</div>
                            <div class="col-md-8">{{ $user->email }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Role:</div>
                            <div class="col-md-8">
                                @if ($user->role === 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @else
                                    <span class="badge bg-secondary">User</span>
                                @endif
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Joined:</div>
                            <div class="col-md-8">{{ $user->created_at->format('d M Y H:i') }}</div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-md-4 fw-semibold">Last Updated:</div>
                            <div class="col-md-8">{{ $user->updated_at->format('d M Y H:i') }}</div>
                        </div>

                        <hr class="my-4">

                        <div class="d-flex gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-warning">
                                <i class="fas fa-edit me-2"></i>Edit User
                            </a>
                            <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                                <i class="fas fa-arrow-left me-2"></i>Back to List
                            </a>
                            @if ($user->id !== auth()->id())
                                <form action="{{ route('admin.users.destroy', $user) }}" method="POST" class="d-inline"
                                    onsubmit="return confirm('Are you sure?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">
                                        <i class="fas fa-trash me-2"></i>Delete User
                                    </button>
                                </form>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
