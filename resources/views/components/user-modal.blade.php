
<div class="modal fade" id="createUserModal" tabindex="-1" aria-labelledby="createUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="createUserForm" method="POST" action="{{ route('users.store') }}">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="create-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="create-name" name="name" value="{{old('name')}}"required>
                    </div>
                    <div class="mb-3">
                        <label for="create-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="create-email" name="email" value="{{old('email')}}"required>
                    </div>
                    <div class="mb-3">
                        <label for="create-phone" class="form-label">Phone (optional)</label>
                        <input type="text" class="form-control" id="create-phone" name="phone"value="{{old('phone')}}">
                    </div>
                    <div class="mb-3">
                        <label for="create-address" class="form-label">Address (optional)</label>
                        <input type="text" class="form-control" id="create-address" name="address"value="{{old('address')}}">
                    </div>
                    <div class="mb-3">
                        <label for="create-password" class="form-label">Password</label>
                        <input type="password" class="form-control" id="create-password" name="password" required>
                    </div>
                    <div class="mb-3">
                        <label for="create-password-confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="create-password-confirmation" name="password_confirmation" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create User</button>
                </div>
            </form>
        </div>
    </div>
</div>
