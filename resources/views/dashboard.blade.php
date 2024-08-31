@extends('layout.app')

@section('title', 'Dashboard')

@section('content')
<div class="container my-4">
    <div class="card bg-success border-0 shadow-lg rounded-3">
        <div class="card-body p-4">
            <div class="d-flex align-items-center">
                <div class="me-4">
                    <i class="bi bi-person-circle text-primary" style="font-size: 3rem;"></i>
                </div>
                <div>
                    <h5 class="card-title mb-0 text-white">Welcome:</h5>
                    <p class="fs-4 fw-bold text-warning mb-0">{{ $user->name }}</p>
                </div>
                <div class="ms-auto text-end">
                    <i class="bi bi-shield-check text-danger" style="font-size: 3rem;"></i>
                    <p class="fs-5 fw-bold text-warning mb-0">{{ strtoupper($user->role) }}</p>
                </div>
            </div>
        </div>
    </div>
</div>

@if($user->hasRole('admin')|| $user->hasRole('superuser'))
<div class="container my-4">
    <div class="row">
        <div class="col-md-6 col-lg-4">
            <div class="card custom-card bg-success text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Admins</h5>
                    <p class="card-text">Manage admins and add new admins with ease. Click the links below to perform actions.</p>
                    <a href="/add-admin" class="btn btn-outline-warning ">
                        Add New Admin
                    </a>
                    <a href="/manage-admin" class="btn ms-2 btn-outline-warning">
                        Manage Admin
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card custom-card bg-secondary text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Users</h5>
                    <p class="card-text">Manage users and add new users with ease. Click the links below to perform actions.</p>
                    <a href="/add-admin" class="btn btn-outline-warning ">
                        Add New User
                    </a>
                    <a href="/manage-admin" class="btn ms-2 btn-outline-warning">
                        Manage Users
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card custom-card bg-success text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Events</h5>
                    <p class="card-text">Manage events and add new events with ease. Click the links below to perform actions.</p>
                    <a href="#" class="btn btn-outline-warning " data-bs-toggle="modal" data-bs-target="#createEventModal">
                        Add New Event
                    </a>
                    <a href="{{route('events.index')}}" class="btn ms-2 btn-outline-warning">
                        Manage Events
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card custom-card bg-success text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Reports</h5>
                    <p class="card-text">Manage reports and add new reports with ease. Click the links below to perform actions.</p>
                    <a href="#" class="btn btn-outline-warning "  data-bs-toggle="modal" data-bs-target="#createReportModal">
                        Add New Report
                    </a>
                    <a href="{{route('reports.index')}}" class="btn ms-2 btn-outline-warning">
                        Manage Reports
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card custom-card bg-secondary text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Articles</h5>
                    <p class="card-text">Manage articles and add new articles with ease. Click the links below to perform actions.</p>
                    <a href="#" class="btn btn-outline-warning" data-bs-toggle="modal" data-bs-target="#postArticleModal">
                        Add New Article
                    </a>

                    <a href="{{route('articles.index')}}" class="btn ms-2 btn-outline-warning">
                        Manage Articles
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-6 col-lg-4">
            <div class="card custom-card bg-success text-white mb-4">
                <div class="card-body">
                    <h5 class="card-title">Guidelines</h5>
                    <p class="card-text">Manage guidelines and add new guidelines with ease. Click the links below to perform actions.</p>
                    <div class="d-flex justify-content-between">
                        <a href="#" class="btn btn-outline-warning " data-bs-toggle="modal" data-bs-target="#createGuidelineModal">
                            Add New Guideline
                        </a>
                        <a href="{{route('guidelines.index')}}" class="btn ms-2 btn-outline-warning">
                            Manage Guidelines
                        </a>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>


<div class="container">
    <div class="row">
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Visitors</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="fw-bold fs-5 total-visitors">0</span> <!-- Total Visitors -->
                            <span>Visitors Over Time</span>
                        </p>
                        <p class="ms-auto d-flex flex-column text-end">
                            <span class="text-success percentage-increase">
                                <i class="bi bi-arrow-up"></i> 0%
                                <!-- Percentage Increase -->
                            </span>
                            <span class="text-secondary">Since last week</span>
                        </p>
                    </div>
                    <div class="position-relative mb-4">
                        <div id="visitors-chart"></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header border-0">
                    <div class="d-flex justify-content-between">
                        <h3 class="card-title">Users</h3>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex">
                        <p class="d-flex flex-column">
                            <span class="fw-bold fs-5 total-users">0</span> <!-- Total Users -->
                            <span>Users Over Time</span>
                        </p>
                        <p class="ms-auto d-flex flex-column text-end">
                            <span class="text-success percentage-increase">
                                <i class="bi bi-arrow-up"></i> 0%
                                <!-- Percentage Increase -->
                            </span>
                            <span class="text-secondary">Since last week</span>
                        </p>
                    </div>
                    <div class="position-relative mb-4">
                        <div id="users-chart"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    @if($user->hasRole('user'))
    <div class="container">
        <!-- Additional admin content -->
    </div>
    @endif
</div>

<!-- modals -->
<x-article-modal />
<x-event-modal />
<x-report-modal/>
<x-guideline-modal/>



<script>
    $(document).ready(function() {
        const daysOfWeek = ["Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday"];

        const users_chart_options = {
            series: [{
                name: "This Week",
                data: []
            }, {
                name: "Last Week",
                data: []
            }],
            chart: {
                height: 200,
                type: "line",
                toolbar: {
                    show: false
                }
            },
            colors: ["#0d6efd", "#adb5bd"],
            stroke: {
                curve: "smooth"
            },
            grid: {
                borderColor: "#e7e7e7",
                row: {
                    colors: ["#f3f3f3", "transparent"],
                    opacity: 0.5
                }
            },
            markers: {
                size: 1
            },
            xaxis: {
                categories: daysOfWeek
            },
            legend: {
                show: true
            }
        };

        const users_chart_element = document.querySelector("#users-chart");
        if (users_chart_element) {
            const users_chart = new ApexCharts(users_chart_element, users_chart_options);
            users_chart.render();

            $.ajax({
                url: '/user-chart-data',
                type: 'GET',
                dataType: 'json',
                success: function(data) {
                    if (data.thisWeek && data.lastWeek) {
                        const thisWeekData = daysOfWeek.map(day => {
                            const entry = data.thisWeek.find(item => item.day === day);
                            return entry ? entry.count : 0;
                        });

                        const lastWeekData = daysOfWeek.map(day => {
                            const entry = data.lastWeek.find(item => item.day === day);
                            return entry ? entry.count : 0;
                        });

                        users_chart.updateOptions({
                            series: [{
                                name: 'This Week',
                                data: thisWeekData
                            }, {
                                name: 'Last Week',
                                data: lastWeekData
                            }]
                        });

                        $('.total-users').text(data.totalUsersThisWeek);
                        $('.percentage-increase').html(`<i class="bi bi-arrow-up"></i> ${data.percentageIncrease}%`);
                    } else {
                        console.error('Invalid data format:', data);
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error fetching data:', error);
                }
            });
        } else {
            console.error('Chart element not found.');
        }
    });
</script>
@endsection