<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function (){
    Route::get('/',[HomeController::class,'index'])->name('home');
});

require __DIR__ . '/auth.php';