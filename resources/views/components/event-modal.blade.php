<!-- Modal for Creating Event -->
<div class="modal fade" id="createEventModal" tabindex="-1" aria-labelledby="createEventModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventModalLabel">Create New Event</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createEventForm" action="{{ route('events.store') }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    <div class="mb-3">
                        <label for="name" class="form-label">Event Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="content" class="form-label">Content</label>
                        <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="date_time" class="form-label">Event Date and Time</label>
                        <input type="datetime-local" class="form-control" id="date_time" name="date_time" required>
                    </div>
                    <div class="mb-3">
                        <label for="images" class="form-label">Event Images</label>
                        <input type="file" class="form-control" id="images" name="images[]" multiple>
                        <small class="form-text text-muted">Select multiple images if needed.</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Create Event</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>