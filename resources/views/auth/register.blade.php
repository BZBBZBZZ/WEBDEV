@extends('layout.mainlayout')

@section('title', 'Register')

@section('content')
    <div class="min-vh-100 d-flex align-items-center bg-danger">
        <div class="container py-4 py-md-5">
            <div class="row justify-content-center">
                <div class="col-11 col-sm-10 col-md-8 col-lg-6 col-xl-5">
                    <div class="text-center mb-3 mb-md-4">
                        <div class="bg-white rounded-circle d-inline-flex p-2 p-md-3 shadow-lg mb-2 mb-md-3">
                            <i class="fas fa-birthday-cake fa-2x fa-md-3x text-danger"></i>
                        </div>
                        <h2 class="text-white fw-bold fs-3 fs-md-2 mb-1 mb-md-2">Join Po Bakery!</h2>
                        <p class="text-white mb-0 small">Create your account to get started</p>
                    </div>

                    <div class="card shadow-lg border-0 rounded-4">
                        <div class="card-body p-3 p-sm-4 p-md-5">
                            <form method="POST" action="{{ route('register') }}">
                                @csrf

                                <div class="mb-3 mb-md-4">
                                    <label for="name" class="form-label fw-semibold small">
                                        <i class="fas fa-user text-danger me-1 me-md-2"></i>Full Name
                                    </label>
                                    <input type="text"
                                        class="form-control form-control-lg @error('name') is-invalid @enderror"
                                        id="name" name="name" value="{{ old('name') }}"
                                        placeholder="Enter your full name" required autofocus>
                                    @error('name')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3 mb-md-4">
                                    <label for="email" class="form-label fw-semibold small">
                                        <i class="fas fa-envelope text-danger me-1 me-md-2"></i>Email Address
                                    </label>
                                    <input type="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        id="email" name="email" value="{{ old('email') }}"
                                        placeholder="Enter your email" required>
                                    @error('email')
                                        <div class="invalid-feedback">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-3 mb-md-4">
                                    <label for="password" class="form-label fw-semibold small">
                                        <i class="fas fa-lock text-danger me-1 me-md-2"></i>Password
                                    </label>
                                    <div class="input-group">
                                        <input type="password"
                                            class="form-control form-control-lg @error('password') is-invalid @enderror"
                                            id="password" name="password" placeholder="Create a password" required>
                                        <button class="btn btn-outline-secondary" type="button"
                                            data-toggle-password="#password">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                        @error('password')
                                            <div class="invalid-feedback">
                                                <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                    <small class="text-muted">
                                        <i class="fas fa-info-circle me-1"></i>Minimum 8 characters
                                    </small>
                                </div>

                                <button type="submit" class="btn btn-danger btn-lg w-100 mb-3 shadow">
                                    <i class="fas fa-user-plus me-2"></i>Create Account
                                </button>

                                <div class="text-center mb-3">
                                    <span class="text-muted small">OR</span>
                                </div>

                                <div class="text-center">
                                    <p class="mb-2 text-muted small">Already have an account?</p>
                                    <a href="{{ route('login') }}" class="btn btn-outline-danger w-100">
                                        <i class="fas fa-sign-in-alt me-2"></i>Login Here
                                    </a>
                                </div>
                            </form>
                        </div>
                        <div class="text-center mb-3 mb-md-5">
                            <a href="/" class="text-danger text-decoration-none small">
                                <i class="fas fa-home me-1 me-md-2"></i>Back to Home
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
