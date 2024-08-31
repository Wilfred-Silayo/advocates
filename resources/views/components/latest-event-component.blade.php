@if($latestEvent)
<div class="latest-event bg-white shadow-sm rounded border p-5">
    <h2>{{ $latestEvent->name }}</h2>
    <p class="text-muted text-break">{{ $latestEvent->date_time->format('d M Y, h:i A') }}</p>

    <!-- Event Description with More/Less Button -->
    <div id="event-description">
        <p class="short-content text-break">{{ Str::limit($latestEvent->content, 100) }}</p>
        <p class="full-content text-break d-none">{{ $latestEvent->content }}</p>
        <button id="toggle-description" class="btn btn-info">More</button>
    </div>

    <!-- Carousel for Images -->
    @if($latestEvent->images)
    <div id="eventImagesCarousel" class="carousel slide mt-3">
        <div class="carousel-inner">
            @foreach($latestEvent->images as $index => $image)
            <div class="carousel-item {{ $index == 0 ? 'active' : '' }}">
                <img src="{{ asset('storage/'.$image) }}" class="d-block w-100" alt="Event Image">
            </div>
            @endforeach
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#eventImagesCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#eventImagesCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
    @endif
</div>

<script>
    $(document).ready(function() {
        $('#toggle-description').click(function() {
            var shortContent = $('.short-content');
            var fullContent = $('.full-content');
            var button = $(this);

            if (fullContent.hasClass('d-none')) {
                fullContent.removeClass('d-none').hide().slideDown(300); // Slide down animation
                button.text('Less');
            } else {
                fullContent.slideUp(300, function() {
                    fullContent.addClass('d-none');
                }); // Slide up animation
                button.text('More');
            }
        });
    });
</script>
@endif
