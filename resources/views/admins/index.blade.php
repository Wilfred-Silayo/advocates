@extends('layout.app')

@section('title', 'Admins')

@section('content')
<div class="container mt-5">

    <!-- Error and Success Alerts -->
    <!-- Error Alerts -->
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
        <h1 class="fw-bold">Admins</h1>

        <div class="col-4">
            <input type="text" class="form-control" id="search" placeholder="Search admins..." />

        </div>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createAdminModal">
            Create Admin
        </button>
    </div>

    <div id="admins-table">
        @include('admins.table')
    </div>

</div>

<!-- Create Admin Modal -->
<x-admin-modal />

<!-- Update Admin Modal -->
<div class="modal fade" id="updateAdminModal" tabindex="-1" aria-labelledby="updateAdminModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateAdminModalLabel">Update Admin</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updateAdminForm" method="POST">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="update-admin-id" name="id">

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
                    <button type="submit" class="btn btn-primary">Update Admin</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteConfirmationModal" tabindex="-1" aria-labelledby="deleteConfirmationModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteConfirmationModalLabel">Confirm Deletion</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                Are you sure you want to delete this admin?
            </div>
            <div class="modal-footer">
                <form id="deleteAdminForm" method="POST" style="display: inline;">
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
        // Show Update Admin Modal and Populate Fields
        $('.btn-edit').on('click', function() {
            var button = $(this);
            var adminId = button.data('id');
            var name = button.data('name');
            var email = button.data('email');
            var phone = button.data('phone');
            var address = button.data('address');
            var role = button.data('role');

            $('#update-admin-id').val(adminId);
            $('#update-name').val(name);
            $('#update-email').val(email);
            $('#update-phone').val(phone);
            $('#update-address').val(address);
            $('#update-role').val(role);

            // Set the form action URL for the update
            $('#updateAdminForm').attr('action', '/admins/' + adminId);

            $('#updateAdminModal').modal('show');
        });

        // Show Delete Confirmation Modal and Set Form Action
        $('.btn-delete').on('click', function() {
            var adminId = $(this).data('id');

            // Set the form action URL for the delete
            $('#deleteAdminForm').attr('action', '/admins/' + adminId);

            $('#deleteConfirmationModal').modal('show');
        });

        $('#search').on('keyup', function() {
            var query = $(this).val();
            $.ajax({
                url: "{{ route('admins.search') }}",
                type: 'GET',
                data: {
                    search: query
                },
                dataType: 'json',
                success: function(data) {
                    $('#admins-table').html(data.html);
                    $('#pagination').html(data.pagination);
                }
            });
        });
    });
</script>
@endsection