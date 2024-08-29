<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.index', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        // Validate the request
        $request->validate([
            'profile_pic' => 'nullable|mimes:jpg,jpeg,bmp,png|max:2048',
            'address' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15|unique:users,phone,' . $user->id,
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        // Retrieve the original email
        $originalEmail = $user->getOriginal('email');

        // Update the user's email
        $user->email = $request->input('email');

        // Compare the original email with the new email
        if ($originalEmail !== $user->email) {
            $user->email_verified_at = null;
        }

        // Handle profile image upload
        if ($request->hasFile('profile_pic')) {
            $profileImage = $request->file('profile_pic');
            $profileImageName = time() . '_' . $profileImage->getClientOriginalName();
            $profileImage->storeAs('public/profile_images', $profileImageName);

            // Delete the old profile image if it's not the default one
            $profile = $user->profile_pic;
            $path = 'public/profile_images/' . $profile;
            if ($profile !== 'user.png' && Storage::exists($path)) {
                Storage::delete($path);
            }

            // Update the user's profile_pic with the new image name
            $user->profile_pic = $profileImageName;
        }

        // Update user fields individually
        $user->address = $request->input('address');
        $user->name = $request->input('name');
        $user->phone = $request->input('phone');
        $user->email = $request->input('email');

        // Save the updated user information
        $user->save();

        return back()->with(['status'=> 'profile updated successfully.','type'=>'success']);
    }



    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
