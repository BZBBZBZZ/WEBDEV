<section>
    <header class="mb-4">
        <h6 class="text-muted">Ensure your account is using a long, random password to stay secure.</h6>
    </header>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- Current Password -->
        <div class="mb-3">
            <label for="update_password_current_password" class="form-label">
                <i class="fas fa-lock me-2"></i>Current Password
            </label>
            <input type="password" 
                   class="form-control @error('current_password', 'updatePassword') is-invalid @enderror" 
                   id="update_password_current_password" 
                   name="current_password">
            @error('current_password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- New Password -->
        <div class="mb-3">
            <label for="update_password_password" class="form-label">
                <i class="fas fa-key me-2"></i>New Password
            </label>
            <input type="password" 
                   class="form-control @error('password', 'updatePassword') is-invalid @enderror" 
                   id="update_password_password" 
                   name="password">
            @error('password', 'updatePassword')
                <div class="invalid-feedback">{{ $message }}</div>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="mb-3">
            <label for="update_password_password_confirmation" class="form-label">
                <i class="fas fa-lock me-2"></i>Confirm Password
            </label>
            <input type="password" class="form-control" 
                   id="update_password_password_confirmation" 
                   name="password_confirmation">
        </div>

        <div class="d-flex align-items-center gap-3">
            <button type="submit" class="btn btn-warning">
                <i class="fas fa-save me-2"></i>Update Password
            </button>

            @if (session('status') === 'password-updated')
                <small class="text-success">
                    <i class="fas fa-check-circle me-1"></i>Password updated!
                </small>
            @endif
        </div>
    </form>
</section>