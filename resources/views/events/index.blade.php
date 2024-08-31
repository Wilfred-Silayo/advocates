@extends('layout.app')

@section('title', 'Events')

@section('content')

<div class="container mt-5">
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
        <h1 class="fw-bold">Events</h1>
        @if(auth()->check())
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createEventModal">
            Create Event
        </button>
        @endif
    </div>

    <div class="row">
        @forelse($events as $event)
        <div class="col-md-4 mb-4 d-flex">
            <div class="card shadow-sm flex-fill">
                @if(!empty($event->images))
                <div id="eventImagesCarousel_{{ $event->id }}" class="carousel slide">
                    <div class="carousel-inner">
                        @foreach($event->images as $index => $image)
                        <div class="carousel-item {{ $index === 0 ? 'active' : '' }}">
                            <img src="{{ asset('storage/'.$image) }}" class="d-block w-100" alt="Event Image">
                        </div>
                        @endforeach
                    </div>
                    <button class="carousel-control-prev" type="button" data-bs-target="#eventImagesCarousel_{{ $event->id }}" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>
                    <button class="carousel-control-next" type="button" data-bs-target="#eventImagesCarousel_{{ $event->id }}" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
                @endif
                <div class="card-body">
                    <h5 class="card-title">{{ $event->name }}</h5>
                    <p class="card-text text-muted">{{ Str::limit($event->content, 100) }}</p>
                    <div class="d-flex justify-content-between align-items-center">
                        <button type="button" class="btn btn-info btn-sm" data-bs-toggle="modal" data-bs-target="#viewEventModal_{{ $event->id }}">
                            View
                        </button>
                        @if(auth()->check())
                        <button type="button" class="btn btn-warning btn-sm" data-bs-toggle="modal" data-bs-target="#editEventModal_{{ $event->id }}">
                            Edit
                        </button>
                        <button type="button" class="btn btn-danger btn-sm delete-btn" data-id="{{ $event->id }}">Delete</button>
                        @endif
                    </div>
                </div>
                <div class="card-footer text-muted">
                    <p class="card-text text-muted">Event Date and Time: {{ $event->date_time->format('d M Y, h:i A') }}</p>
                </div>
            </div>
        </div>

        <!-- Modal for Viewing Event -->
        <div class="modal fade" id="viewEventModal_{{ $event->id }}" tabindex="-1" aria-labelledby="viewEventModalLabel_{{ $event->id }}" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewEventModalLabel_{{ $event->id }}">Event Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <h5 class="card-title">{{ $event->name }}</h5>
                        <p class="card-text text-break">{{ $event->content }}</p>
                        <p class="text-muted">Event Date and Time: {{ $event->date_time->format('d M Y, h:i A') }}</p>
                        @if($event->images)
                        <div id="eventImagesCarouselModal_{{ $event->id }}" class="carousel slide">
                            <div class="carousel-inner">
                                @foreach($event->images as $index => $image)
                                <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                                    <img src="{{ asset('storage/'.$image) }}" class="d-block w-100" alt="Event Image">
                                </div>
                                @endforeach
                            </div>
                            <button class="carousel-control-prev" type="button" data-bs-target="#eventImagesCarouselModal_{{ $event->id }}" data-bs-slide="prev">
                                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Previous</span>
                            </button>
                            <button class="carousel-control-next" type="button" data-bs-target="#eventImagesCarouselModal_{{ $event->id }}" data-bs-slide="next">
                                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                <span class="visually-hidden">Next</span>
                            </button>
                        </div>
                        @endif
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal for Editing Event -->
        <div class="modal fade" id="editEventModal_{{ $event->id }}" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editEventModalLabel">Edit Event</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editEventForm" action="{{ route('events.update', $event->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Event Name</label>
                                <input type="text" class="form-control" id="name" name="name" value="{{ $event->name }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="content" class="form-label">Content</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required>{{ $event->content }}</textarea>
                            </div>
                            <div class="mb-3">
                                <label for="date_time" class="form-label">Event Date and Time</label>
                                <input type="datetime-local" class="form-control" id="date_time" name="date_time" value="{{ $event->date_time->format('Y-m-d\TH:i') }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="images" class="form-label">Event Images</label>
                                <input type="file" class="form-control" id="images" name="images[]" multiple>
                                <small class="form-text text-muted">Select multiple images if needed. Existing images will not be overwritten.</small>
                            </div>
                            <button type="submit" class="btn btn-primary">Update Event</button>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
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
                        Are you sure you want to delete this event?
                    </div>
                    <div class="modal-footer">
                        <form id="deleteEventForm" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger">Delete</button>
                        </form>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>


        @empty
        <div class="alert alert-info" role="alert">
            No events found. Click "Create New Event" to add one!
        </div>
        @endforelse
    </div>

    <!-- Custom Pagination Links -->
    <div class="d-flex justify-content-center mt-4">
        {{ $events->links('pagination.pagination') }}
    </div>
</div>

<x-event-modal />

<script>
    $(document).ready(function() {
        $('.delete-btn').click(function() {
            let eventId = $(this).data('id');
            $('#deleteEventForm').attr('action', '/events/' + eventId);
            $('#deleteConfirmationModal').modal('show');
        });
    });
</script>
@endsection