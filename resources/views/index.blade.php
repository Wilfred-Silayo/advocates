@extends('layout.app')
@section('title','Home')

@section('content')
<div class="container-fluid p-0  overflow-hidden">
    <div class="row home-title min-vh-50 p-0">
        <x-home-component />
        <x-about-component />
    </div>
    <div class="row home-title2 min-vh-50">
        <x-mission-component />
    </div>
    <div class="row home-title3 min-vh-50  d-flex justify-content-end">
        <x-more-info-component />
    </div>
    <div class="row home-title4 min-vh-50">
        <x-our-team-component />
    </div>
    <div class="row bg-dark min-vh-50">
        <x-service-component />
    </div>
    <div class="row bg-light min-vh-50">
        <x-contact-component />
    </div>
    <div class="row btn-teal">
        <x-footer-component />
    </div>

</div>
@endsection