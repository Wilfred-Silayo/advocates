@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid p-2 overflow-hidden">
    <div class="container my-1 bg-light shadow-sm">
        <div class="row">
            <div class="col">
                <p class="fw-bold">Welcome: <span class="text-primary">{{$user->name}}</span></p>
            </div>
            <div class="col text-end">
                <p class="fw-bold text-danger">{{strtoupper($user->role)}}</p>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row justify-content-between">
            <div class="col-12 col-md-5 card mt-2 me-md-3 shadow-sm">
                <h5>Visitors Traffic</h5>
                <div class="row">
                    <div class="col-6">
                        <label for="filterSelect">Select Filter:</label>
                        <select id="filterSelect" class="form-select mb-3">
                            <option value="week">This Week</option>
                            <option value="year">Year</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label for="filterValueSelect" class="d-block">Select Value:</label>
                        <select id="filterValueSelect" class="form-select mb-3">
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </div>
                <div class="row">
                    <canvas id="visitorsChart"></canvas>
                </div>
            </div>

            <div class="col-12 col-md-5 card  mt-2 ms-md-3 shadow-sm">
                <h5>Users Registered</h5>
                <div class="row">
                    <div class="col-6">
                        <label for="filterSelectUsers">Select Filter:</label>
                        <select id="filterSelectUsers" class="form-select mb-3">
                            <option value="week">This Week</option>
                            <option value="year">Year</option>
                        </select>
                    </div>

                    <div class="col-6">
                        <label for="filterValueSelectUsers" class="d-block">Select Value:</label>
                        <select id="filterValueSelectUsers" class="form-select mb-3">
                            <!-- Options will be populated dynamically -->
                        </select>
                    </div>
                </div>
                <div class="row">
                    <canvas id="usersChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    @if($user->hasRole('admin'))
    <div class="container">
        <!-- Additional admin content -->
    </div>
    @endif
</div>

@endsection