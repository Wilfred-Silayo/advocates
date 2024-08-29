@if ($users->lastPage() > 1)
    <ul class="pagination">
        {{-- First Page Link --}}
        @if ($users->onFirstPage())
            <li class="page-item disabled"><span class="page-link">« First</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $users->url(1) }}">« First</a></li>
        @endif

        {{-- Previous Page Link --}}
        @if ($users->onFirstPage())
            <li class="page-item disabled"><span class="page-link">‹</span></li>
        @else
            <li class="page-item"><a class="page-link" href="{{ $users->previousPageUrl() }}">‹</a></li>
        @endif

        {{-- Pagination Links --}}
        @foreach ($users->getUrlRange(1, $users->lastPage()) as $page => $url)
            @if ($page == $users->currentPage())
                <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
            @else
                <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
            @endif
        @endforeach

        {{-- Next Page Link --}}
        @if ($users->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $users->nextPageUrl() }}">›</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">›</span></li>
        @endif

        {{-- Last Page Link --}}
        @if ($users->hasMorePages())
            <li class="page-item"><a class="page-link" href="{{ $users->url($users->lastPage()) }}">Last »</a></li>
        @else
            <li class="page-item disabled"><span class="page-link">Last »</span></li>
        @endif
    </ul>
@endif
