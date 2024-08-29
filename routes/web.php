<?php

use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;
use SebastianBergmann\CodeCoverage\Report\Html\Dashboard;

Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->middleware('visitor')->name('home');
    Route::get('/chat', [ChatController::class, 'index'])->name('chat');
    Route::get('/privacy', [SystemController::class, 'privacy'])->name('privacy');
    Route::get('/terms and conditions', [SystemController::class, 'terms'])->name('terms');
    Route::get('/disclaimer', [SystemController::class, 'disclaimer'])->name('disclaimer');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/u/chat', [ChatController::class, 'list'])->name('chat.auth');

    //profiles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route to fetch weekly visitors data
    Route::get('/visitors-chart-data', [ChartController::class, 'getVisitorsChartData'])->name('recent-users');

    // Route to fetch yearly visitors data (this route should return data for the entire year)
    Route::get('/year-visitors-chart-data', [ChartController::class, 'getYearlyVisitorsChartData']);

    Route::get('/users-chart-data', [ChartController::class, 'getUsersChartData'])->name('users.chart.data');
});
require __DIR__ . '/auth.php';