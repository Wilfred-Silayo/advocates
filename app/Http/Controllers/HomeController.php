<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    public function index()
    {
        $latestEvent = Event::latest()->first();

        return view('index', compact('latestEvent'));
    }
}
