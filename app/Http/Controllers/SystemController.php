<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SystemController extends Controller
{
    public function privacy()
    {
        return view('system.privacy');
    }

    public function terms()
    {
        return view('system.terms');
    }
    public function disclaimer()
    {
        return view('system.disclaimer');
    }
}
