<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function index(){
        return redirect('/login')->with(['status'=>'Please login to start charting with us.', 'type'=>'success']);
    }

    public function list(){
        return view('chat.index');
    }
}
