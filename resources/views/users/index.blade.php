@extends('layout.app')

@section('title', 'Users')

@section('content')
<div class="container mt-5">

    <!-- Error and Success Alerts -->
    @if($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <ul class="mb-0">
            @foreach($errors->all() as $error)
            <li>{{ $error }}</li>
            @endforeach
        </ul>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible fade show" role="alert">
        {{ session('success') }}
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="fw-bold">Users</h1>

        <div class="col-4">
            <input type="text" class="form-control" id="search" placeholder="Search users..." />
        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createUserModal">
            Create User
        </button>
    </div>

    <div id="users-table">
        @include('users.table')
        <!-- Make sure you have this view -->
    </div>

</div>

<!-- Create User Modal -->
<x-user-modal />

<!-- Update User Modal -->
<div class="modal fade" id="updateUserModal" tabindex="-1" aria-labelledby="updateUserModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateUserModalLabel">Update User</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateUserForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="update-user-id" name="id">

                    <div class="mb-3">
                        <label for="update-name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="update-name" name="name" required>
                    </div>

                    <div class="mb-3">
                        <label for="update-email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="update-email" name="email" required>
                    </div>

                    <div class="mb-3">
                        <label for="update-phone" class="form-label">Phone (optional)</label>
                        <input type="text" class="form-control" id="update-phone" name="phone">
                    </div>

                    <div class="mb-3">
                        <label for="update-address" class="form-label">Address (optional)</label>
                        <input type="text" class="form-control" id="update-address" name="address">
                    </div>

                    <div class="mb-3">
                        <label for="update-password" class="form-label">Password (Leave blank to keep current password)</label>
                        <input type="password" class="form-control" id="update-password" name="password">
                    </div>

                    <div class="mb-3">
                        <label for="update-password-confirmation" class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" id="update-password-confirmation" name="password_confirmation">
                    </div>

                    <div class="mb-3">
                        <label for="update-role" class="form-label">Role</label>
                        <select class="form-select" id="update-role" name="role">
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                            <option value="superuser" {{ old('role') == 'superuser' ? 'selected' : '' }}>Superuser</option>
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update User</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this user?
            </div>
            <div class="modal-footer">
                <form id="deleteUserForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        // Show Update User Modal and Populate Fields
        $('.btn-edit').on('click', function() {
            var button = $(this);
            var userId = button.data('id');
            var name = button.data('name');
            var email = button.data('email');
            var phone = button.data('phone');
            var address = button.data('address');
            var role = button.data('role');

            // Check if data attributes exist and are not empty
            if (userId) $('#update-user-id').val(userId);
            if (name) $('#update-name').val(name);
            if (email) $('#update-email').val(email);
            if (phone) $('#update-phone').val(phone);
            if (address) $('#update-address').val(address);
            if (role) $('#update-role').val(role);

            // Set the form action URL for the update
            $('#updateUserForm').attr('action', '/users/' + userId);

            $('#updateUserModal').modal('show');
        });

        // Show Delete Confirmation Modal and Set Form Action
        $('.btn-delete').on('click', function() {
            var userId = $(this).data('id');

            // Set the form action URL for the delete
            $('#deleteUserForm').attr('action', '/users/' + userId);

            $('#deleteConfirmationModal').modal('show');
        });

        $('#search').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: "{{ route('users.search') }}",
                type: 'GET',
                data: {
                    search: query
                },
                dataType: 'json',
                success: function(data) {
                    $('#users-table').html(data.html);
                    $('#pagination').html(data.pagination);
                }
            });
        });
    });
</script>
@endsection