@props(['route', 'title', 'id' => ''])

@php

$fullRoute = $id ? route($route) . '#' . $id : route($route);

@endphp

<a href="{{ $fullRoute }}" class="nav-link text-white fs-4">
    <p>{{ $title }}</p>
</a>