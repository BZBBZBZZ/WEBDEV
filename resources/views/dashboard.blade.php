@extends('layout.mainlayout')

@section('title', 'Dashboard')

@section('content')
    <div class="container py-5">
        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-header bg-primary text-white">
                        <h4 class="mb-0">
                            <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                        </h4>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <div class="alert alert-success mb-4">
                            <i class="fas fa-check-circle me-2"></i>You're logged in!
                        </div>

                        <div class="row g-4">
                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-user fa-3x text-primary mb-3"></i>
                                        <h5>Welcome Back!</h5>
                                        <p class="text-muted mb-0">
                                            <strong>{{ Auth::user()->name }}</strong>
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="card bg-light">
                                    <div class="card-body text-center">
                                        <i class="fas fa-envelope fa-3x text-success mb-3"></i>
                                        <h5>Your Email</h5>
                                        <p class="text-muted mb-0">{{ Auth::user()->email }}</p>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h5 class="mb-3">
                                            <i class="fas fa-link me-2"></i>Quick Links
                                        </h5>
                                        <div class="d-grid gap-2 d-md-flex">
                                            <a href="{{ route('profile.edit') }}" class="btn btn-outline-primary">
                                                <i class="fas fa-user-edit me-2"></i>Edit Profile
                                            </a>
                                            <a href="/products" class="btn btn-outline-success">
                                                <i class="fas fa-shopping-bag me-2"></i>Browse Products
                                            </a>
                                            <a href="/employees" class="btn btn-outline-info">
                                                <i class="fas fa-users me-2"></i>Our Team
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection