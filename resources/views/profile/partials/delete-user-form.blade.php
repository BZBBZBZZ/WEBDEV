<section>
    <header class="mb-4">
        <h6 class="text-danger fw-semibold">
            <i class="fas fa-exclamation-triangle me-2"></i>Delete Account
        </h6>
        <p class="text-muted small mb-0">
            Once your account is deleted, all of its resources and data will be permanently deleted.
            Before deleting your account, please download any data or information that you wish to retain.
        </p>
    </header>

    <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
        <i class="fas fa-trash-alt me-2"></i>Delete Account
    </button>

    <div class="modal fade" id="confirmUserDeletionModal"
        data-has-errors="{{ $errors->userDeletion->any() ? 'true' : 'false' }}" tabindex="-1"
        aria-labelledby="confirmUserDeletionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form method="POST" action="{{ route('profile.destroy') }}">
                    @csrf
                    @method('delete')

                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title" id="confirmUserDeletionLabel">
                            <i class="fas fa-exclamation-triangle me-2"></i>Confirm Account Deletion
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        <div class="alert alert-warning mb-4">
                            <i class="fas fa-exclamation-circle me-2"></i>
                            <strong>Warning!</strong> This action cannot be undone.
                        </div>

                        <p class="text-muted mb-4">
                            Are you sure you want to delete your account? Please enter your password to confirm.
                        </p>

                        <div class="mb-3">
                            <label for="password" class="form-label fw-semibold">
                                <i class="fas fa-lock text-danger me-2"></i>Password
                            </label>
                            <input type="password"
                                class="form-control @error('password', 'userDeletion') is-invalid @enderror"
                                id="password" name="password" placeholder="Enter your password to confirm" required>
                            @error('password', 'userDeletion')
                                <div class="invalid-feedback d-block">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancel
                        </button>
                        <button type="submit" class="btn btn-danger">
                            <i class="fas fa-trash-alt me-2"></i>Yes, Delete My Account
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</section>
