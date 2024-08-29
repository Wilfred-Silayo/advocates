<!-- resources/views/visitors/index.blade.php -->

@extends('layout.app')
@section('title', 'Visitors')

@section('content')
<div class="container">
    <h1>Visitors</h1>
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>IP Address</th>
                <th>Browser</th>
                <th>Device</th>
                <th>Visited At</th>
            </tr>
        </thead>
        <tbody>
            @foreach($visitors as $visitor)
            <tr>
                <td>{{ $visitor->ip_address }}</td>
                <td>{{ $visitor->browser }}</td>
                <td>{{ $visitor->device }}</td>
                <td>{{ $visitor->created_at }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    {{ $visitors->links('pagination-links') }} 
</div>
@endsection
