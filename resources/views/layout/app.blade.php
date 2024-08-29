<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @hasSection('title')
    <title>PCAG | @yield('title')</title>
    @else
    <title>PCAG</title>
    @endif
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }} ">
    <link rel="shortcut icon" href="{{ asset('images/logo.png') }}" type="image/png">
    <link rel="stylesheet" href="{{ asset('custom.css') }} ">
    <script src="{{asset('jquery-3.7.1.min.js')}}"></script>
    @vite(['resources/js/app.js'])
</head>

<body>
    <x-nav-bar />
    @yield('content')

    @if(!auth()->check())
    <!-- Chat Bubble -->
    <div class="position-fixed bottom-0 end-0 m-1" id="chatBubbleContainer">
        <div class="card" id="chatBubble" style="width: 15rem;">
            <div class="card-body">
                <button type="button" class="btn-close float-end" aria-label="Close" onclick="dismissChatBubble()"></button>
                <h5 class="card-title">Chat with us</h5>
                <p class="card-text">How can we help you today?</p>
                <a href="{{route('chat')}}" class="btn btn-primary">Start Chat</a>
            </div>
        </div>
    </div>
    @endif

    <script src="{{asset('custom.js')}}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
</body>

</html>