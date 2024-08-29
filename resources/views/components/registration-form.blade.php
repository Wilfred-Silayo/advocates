<!-- Offcanvas Registration Form -->
<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="registerOffcanvas"
    aria-labelledby="registerOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 id="registerOffcanvasLabel">Registration</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <x-auth-session-status :status="session('status')" :type="session('type')" />
        <form method="POST" action="{{route('register')}}">
            @csrf
            <div class="row">

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" type="text" name="name" :value="old('name')" required autofocus
                        autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

            </div>

            <div class="row">
                <!-- Email Address -->
                <div class="mt-4">
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="reg-email" type="email" name="email" :value="old('email')" required
                        autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>
            </div>
            <div class="row">
                <!-- Phone -->
                <div class="mt-4">
                    <x-input-label for="phone" :value="__('Phone (Optional)')" />
                    <x-text-input id="phone" type="phone" name="phone" :value="old('phone')" required autofocus
                        autocomplete="phone" />
                    <x-input-error :messages="$errors->get('phone')" class="mt-2" />
                </div>
            </div>

            <div class="row">
                <!-- Address -->
                <div class="mt-4">
                    <x-input-label for="address" :value="__('Address (Optional)')" />
                    <x-text-input id="address" type="address" name="address" :value="old('address')" required autofocus
                        autocomplete="address" />
                    <x-input-error :messages="$errors->get('address')" class="mt-2" />
                </div>
            </div>

            <div class="row">
                <!-- Password -->
                <div class="mt-4">
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="reg-password" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>
            </div>

            <div class="row mx-2 mt-4">
                <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#loginOffcanvas"
                    aria-controls="loginOffcanvas">
                    {{ __('Already have an account?') }} <span
                        class="text-primary fw-bold">{{ __('Login here') }}</span>
                </a>
            </div>

            <div class="d-flex align-items-center bg-white justify-content-end my-4">
                <button type="submit" class="btn btn-teal ms-3">
                    {{ __('Register') }}
                </button>
            </div>
        </form>
    </div>
</div>