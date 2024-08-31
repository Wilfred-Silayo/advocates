  <!-- Admins Table -->
  <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Address</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($admins as $admin)
                <tr>
                    <td>{{ $admin->name }}</td>
                    <td>{{ $admin->email }}</td>
                    <td>{{ $admin->phone ?? 'N/A' }}</td>
                    <td>{{ $admin->address ?? 'N/A' }}</td>
                    <td>
                        <button class="btn btn-warning btn-sm mb-1 btn-edit"
                            data-id="{{ $admin->id }}"
                            data-name="{{ $admin->name }}"
                            data-email="{{ $admin->email }}"
                            data-phone="{{ $admin->phone }}"
                            data-role="{{ $admin->role }}"
                            data-address="{{ $admin->address }}"
                            data-bs-toggle="modal"
                            data-bs-target="#updateAdminModal">
                            Edit
                        </button>
                        <button class="btn btn-danger btn-sm mb-1 btn-delete"
                            data-id="{{ $admin->id }}"
                            data-bs-toggle="modal"
                            data-bs-target="#deleteConfirmationModal">
                            Delete
                        </button>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="text-center">No admins found. Click "Create Admin" to add one!</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Custom Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $admins->links('pagination.pagination') }}
    </div>