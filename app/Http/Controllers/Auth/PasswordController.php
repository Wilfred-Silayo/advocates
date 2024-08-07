<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class PasswordController extends Controller
{
    public function index()
    {
        return view('profile.password.index');
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate( [
            'current_password' => ['required', 'string'],
            'password' => ['required', Password::defaults(), 'confirmed'],
        ]);

        $user = Auth::user();
        if (!Hash::check($validated['current_password'], $user->password)) {
            return back()->with(['status'=>'The current password is incorrect.','type'=>'error']);
        }

        $request->user()->update([
            'password' => Hash::make($validated['password']),
        ]);
        
        return back()->with('status', 'Password updated successfully!');
        
        
    }
}
