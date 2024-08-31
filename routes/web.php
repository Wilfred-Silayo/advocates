<?php

use App\Http\Controllers\ArticleController;
use App\Http\Controllers\ChartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\EventController;
use App\Http\Controllers\GuidelineController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SystemController;
use Illuminate\Support\Facades\Route;


Route::middleware('guest')->group(function () {
    Route::get('/', [HomeController::class, 'index'])->middleware('visitor')->name('home');
    Route::get('/chat', [ChatController::class, 'login'])->name('chat');
    Route::get('/privacy', [SystemController::class, 'privacy'])->name('privacy');
    Route::get('/terms and conditions', [SystemController::class, 'terms'])->name('terms');
    Route::get('/disclaimer', [SystemController::class, 'disclaimer'])->name('disclaimer');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/u/chat', [ChatController::class, 'list'])->name('chat.auth');

    Route::get('/search-users', [ChatController::class, 'searchUsers']);
    Route::get('/recent-chats', [ChatController::class, 'recentChats']);
    Route::get('/fetch-new-messages', [ChatController::class, 'fetchNewMessages']);
    Route::get('/load-conversation/{userId}', [ChatController::class, 'loadConversation']);
    Route::post('/send-message', [ChatController::class, 'sendMessage'])->name('send.message');
    Route::post('/delete-conversation', [ChatController::class, 'deleteConversation'])->name('delete.conversation');

    //ARTICLES

    Route::resource('articles', ArticleController::class);
    Route::resource('events', EventController::class);

    Route::resource('reports', ReportController::class);
    Route::get('reports/{report}/download', [ReportController::class, 'download'])->name('reports.download');

    Route::resource('guidelines', GuidelineController::class);
    Route::get('guidelines/{guideline}/download', [GuidelineController::class, 'download'])->name('guidelines.download');


    //profiles
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user-chart-data', [ChartController::class, 'userData'])->name('users.data');

    Route::get('/chart-data', [ChartController::class, 'getChartData'])->name('visitors');
});
require __DIR__ . '/auth.php';
