@extends('layout.app')
@section('title','Home')

@section('content')
<div class="container-fluid p-0  overflow-hidden">
    <div class="row bg-primary min-vh-50 p-0">
        <x-home-component />
        <x-about-component />
    </div>
    <div class="row align-items-center justify-content-center bg-light">
        <div class="col-12 col-md-8 p-3">
            <x-latest-event-component :latestEvent="$latestEvent" />
        </div>
        <div class="row align-items-center justify-content-center">
            <div class="col-4">
                <a href="{{route('guest.event')}}" class="btn my-5 btn-outline-success">More events</a>
            </div>
        </div>
    </div>
    <div class="row home-title2 min-vh-50">
        <x-mission-component />
    </div>
    <div class="row bg-primary min-vh-50  d-flex justify-content-end">
        <x-more-info-component />
    </div>
    <div>
        <x-our-team-component />
    </div>
    <div class="row bg-dark min-vh-50">
        <x-service-component />
    </div>
    <div class="row bg-light min-vh-50">
        <x-contact-component />
    </div>
    <x-cookie-consent-component />
    <div class="row btn-teal">
        <x-footer-component />
    </div>

</div>
@endsection