@extends('layout.app')

@section('title', 'Reports')

@section('content')
<div class="container mt-5">

    <!-- Error and Success Alerts -->
    @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            {{ session('error') }}
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
        <h1 class="fw-bold">Reports</h1>
        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createReportModal">
            Create Report
        </button>
    </div>

    <div class="row">
        @forelse($reports as $report)
        <div class="col-md-4 mb-4">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title text-break">{{ $report->title }}</h5>
                    <p class="card-text text-break text-muted">{{ $report->description }}</p>
                    <div class="row mt-1 border-top">
                        <p>Date created: {{$report->created_at}}</p>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <a href="{{ route('reports.download', $report->id) }}" class="btn btn-info btn-sm">
                            Download
                        </a>
                        <!-- Edit Button with Correct Attributes -->
                        <button class="btn btn-warning btn-sm btn-edit" 
                            data-bs-toggle="modal" data-bs-target="#editReportModal" 
                            data-id="{{ $report->id }}" 
                            data-title="{{ $report->title }}" 
                            data-description="{{ $report->description }}" 
                            data-file="{{ asset('storage/' . $report->file_path) }}">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm btn-delete" 
                            data-id="{{ $report->id }}" 
                            data-bs-toggle="modal" 
                            data-bs-target="#deleteConfirmationModal">
                            Delete
                        </button>
                    </div>
                </div>
            </div>
        </div>
        @empty
        <div class="alert alert-info" role="alert">
            No reports found. Click "Create Report" to add one!
        </div>
        @endforelse
    </div>

    <!-- Custom Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $reports->links('pagination.pagination') }}
    </div>

</div>

<x-report-modal/>

<!-- Edit Report Modal -->
<div class="modal fade" id="editReportModal" tabindex="-1" aria-labelledby="editReportModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editReportModalLabel">Edit Report</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="editReportForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="modal-body">
                    <input type="hidden" id="edit-report-id" name="id">
                    <div class="mb-3">
                        <label for="edit-title text-break" class="form-label">Title</label>
                        <input type="text" class="form-control" id="edit-title" name="title" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit-description" class="form-label">Description</label>
                        <textarea class="form-control" id="edit-description" name="description"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit-file" class="form-label">Update PDF File (optional)</label>
                        <input type="file" class="form-control" id="edit-file" name="file" accept="application/pdf">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update Report</button>
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
                Are you sure you want to delete this report?
            </div>
            <div class="modal-footer">
                <form id="deleteReportForm" method="POST" style="display: inline;">
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
        // Populate Edit Modal
        $('#editReportModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var reportId = button.data('id');
            var title = button.data('title');
            var description = button.data('description');
            var file = button.data('file');

            var modal = $(this);
            modal.find('#edit-report-id').val(reportId);
            modal.find('#edit-title').val(title);
            modal.find('#edit-description').val(description);
            modal.find('#editReportForm').attr('action', '/reports/' + reportId);
        });

        // Populate Delete Modal
        $('#deleteConfirmationModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget);
            var reportId = button.data('id');
            
            var form = $(this).find('#deleteReportForm');
            form.attr('action', '/reports/' + reportId);
        });
    });
</script>

@endsection
