@if($latestEvent)
<div class="latest-event bg-white shadow-sm rounded border p-5">
    <h2>{{ $latestEvent->name }}</h2>
    <p class="text-muted text-break">{{ $latestEvent->date_time->format('d M Y, h:i A') }}</p>

    <!-- Event Description with More/Less Button -->
    <div id="event-description">
        <!-- Short content with Bootstrap truncation -->
        <p class="short-content mb-0 text-break text-ellipsis" >
            {{ Str::limit($latestEvent->content, 100) }}
        </p>
        <!-- Full content hidden by default -->
        <p class="full-content d-none text-break">
            {{ $latestEvent->content }}
        </p>
        @if(strlen($latestEvent->content) > 100)
            <button id="toggle-description" class="btn btn-info mt-2">More</button>
        @endif
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
                // Show full content
                fullContent.removeClass('d-none').hide().slideDown(300);
                shortContent.addClass('d-none'); // Hide short content
                button.text('Less');
            } else {
                // Hide full content
                fullContent.slideUp(300, function() {
                    fullContent.addClass('d-none');
                });
                shortContent.removeClass('d-none'); // Show short content
                button.text('More');
            }
        });
    });
</script>
@endif
