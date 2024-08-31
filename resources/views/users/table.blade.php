  <!-- Users Table -->
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
              @forelse($users as $user)
              <tr>
                  <td>{{ $user->name }}</td>
                  <td>{{ $user->email }}</td>
                  <td>{{ $user->phone ?? 'N/A' }}</td>
                  <td>{{ $user->address ?? 'N/A' }}</td>
                  <td>
                      <button class="btn btn-warning btn-sm mb-1 btn-edit"
                          data-id="{{ $user->id }}"
                          data-name="{{ $user->name }}"
                          data-email="{{ $user->email }}"
                          data-phone="{{ $user->phone }}"
                          data-role="{{ $user->role }}"
                          data-address="{{ $user->address }}"
                          data-bs-toggle="modal"
                          data-bs-target="#updateUserModal">
                          Edit
                      </button>
                      <button class="btn btn-danger btn-sm mb-1 btn-delete"
                          data-id="{{ $user->id }}"
                          data-bs-toggle="modal"
                          data-bs-target="#deleteConfirmationModal">
                          Delete
                      </button>
                  </td>
              </tr>
              @empty
              <tr>
                  <td colspan="5" class="text-center">No users found. Click "Create User" to add one!</td>
              </tr>
              @endforelse
          </tbody>
      </table>
  </div>

  <!-- Custom Pagination Links -->
  <div class="d-flex justify-content-center mt-4">
      {{ $users->links('pagination.pagination') }}
  </div>