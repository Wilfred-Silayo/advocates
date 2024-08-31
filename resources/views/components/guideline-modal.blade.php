<!-- Create Guideline Modal -->
<div class="modal fade" id="createGuidelineModal" tabindex="-1" aria-labelledby="createGuidelineModalLabel"
    aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createGuidelineModalLabel">Create Guideline</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('guidelines.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="title" class="form-label">Title</label>
                        <input type="text" class="form-control" id="title" name="title" value="{{old('title')}}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="description" class="form-label">Description</label>
                        <textarea class="form-control" id="description" name="description">{{old('content')}}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="file" class="form-label">PDF File</label>
                        <input type="file" class="form-control" id="file" name="file" value="{{old('file')}}"
                            accept="application/pdf" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Guideline</button>
                </div>
            </form>
        </div>
    </div>
</div>