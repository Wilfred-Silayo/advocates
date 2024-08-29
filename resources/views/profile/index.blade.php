@extends('layout.app')
@section('title','Profile')

@section('content')
<div class="container rounded card shadow-sm bg-white mt-5 mb-5">
    <div class="row">
        <div class="col-md-3 border-right">
            <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5"
                    width="150px" height="150px" src="{{asset('storage/profile_images/'.$user->profile_pic)}}"><span
                    class="fw-bold">{{$user->name}}</span><span
                    class="">{{$user->email}}</span><span>
                </span>
            </div>
        </div>
        <div class="col-md-9">
            <form action="{{route('profile.update')}}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <div class="p-3 py-5">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h4 class="text-right">Profile Settings</h4>
                    </div>
                    <div class="row">
                        <x-auth-session-status :status="session('status')" :type="session('type')" />
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <!-- Name -->
                            <x-input-label for="name" :value="__('Name')" />
                            <x-text-input id="name" type="text" name="name" :value="old('name',$user->name)" required
                                autofocus autocomplete="name" />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>
                        <div class="col-md-6">
                            <!-- Email -->
                            <x-input-label for="email" :value="__('Email')" />
                            <x-text-input id="email" type="email" name="email" :value="old('email',$user->email)"
                                required autofocus autocomplete="email" />
                            <x-input-error :messages="$errors->get('email')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <!-- Phone -->
                            <x-input-label for="phone" :value="__('Phone')" />
                            <x-text-input id="phone" type="phone" name="phone" :value="old('phone',$user->phone)"
                                required autofocus autocomplete="phone" />
                            <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                        </div>
                        <div class="col-md-6">
                            <!-- Address -->
                            <x-input-label for="address" :value="__('Address')" />
                            <x-text-input id="address" type="address" name="address"
                                :value="old('address',$user->address)" required autofocus autocomplete="address" />
                            <x-input-error :messages="$errors->get('address')" class="mt-2" />
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-md-6">
                            <!-- Profile_pic -->
                            <x-input-label for="profile_pic" :value="__('Profile Picture')" />
                            <x-text-input id="profile_pic" type="file" name="profile_pic"
                                :value="old('profile_pic')" required autofocus
                                autocomplete="profile_pic" />
                            <x-input-error :messages="$errors->get('profile_pic')" class="mt-2" />
                        </div>
                    </div>

                    <div class="mt-3"><button class="btn btn-teal" type="submit">Save
                            Profile</button></div>
                </div>
            </form>
            <div class="p-3">
                <div class="row mb-3">
                    <h4>Change Password</h4>
                </div>
                <form action="{{route('password.update')}}" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="row">
                        <div class="col-md-6">
                            <!-- Password -->
                            <x-input-label for="old_password" :value="__('Old Password')" />
                            <x-text-input id="old_password" type="password" name="old_password" :value="old('old_password')"
                                required autofocus autocomplete="old_password" />
                            <x-input-error :messages="$errors->get('old_password')" class="mt-2" />
                        </div>
                        <div class="col-md-6">
                            <!-- Password -->
                            <x-input-label for="password" :value="__('New Password')" />
                            <x-text-input id="password" type="password" name="password" :value="old('password')"
                                required autofocus autocomplete="password" />
                            <x-input-error :messages="$errors->get('password')" class="mt-2" />
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6">
                                <!-- Password_confirmation -->
                                <x-input-label for="password_confirmation" :value="__('Confirm New Password')" />
                                <x-text-input id="password_confirmation" type="password" name="password_confirmation" :value="old('password_confirmation')"
                                    required autofocus autocomplete="password_confirmation" />
                                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                            </div>
                        </div>
                        <div class="mt-3"><button class="btn btn-teal" type="submit">Save Password
                            </button></div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection