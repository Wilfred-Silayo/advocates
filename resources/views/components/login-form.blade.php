<!-- Offcanvas Login Form -->
<div class="offcanvas offcanvas-end" data-bs-backdrop="static" tabindex="-1" id="loginOffcanvas" aria-labelledby="loginOffcanvasLabel">
    <div class="offcanvas-header">
        <h5 id="loginOffcanvasLabel">Login</h5>
        <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body">
        <x-auth-session-status :status="session('status')" :type="session('type')" />
        <form method="POST" action="{{route('login')}}">
            @csrf

            <!-- Email Address -->
            <div class="form-group mb-4">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" type="email" name="email" :value="old('email')" autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Password -->
            <div class="form-group mb-4">
                <x-input-label for="password" :value="__('Password')" />
                <x-text-input id="password" type="password" name="password" autocomplete="current-password" />
                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Remember Me -->
            <div class="d-block mb-4">
                <label for="remember_me" class="d-inline-flex align-items-center">
                    <input id="remember_me" type="checkbox" class="form-check-control" name="remember">
                    <span class="ms-2 text-sm text-gray-600 dark:text-gray-400">{{ __('Remember me') }}</span>
                </label>
            </div>

            <div class="d-block mb-4">
                <a class="nav-link" href="#" data-bs-toggle="offcanvas" data-bs-target="#registerOffcanvas" aria-controls="registerOffcanvas">
                    {{ __('Forgot your password?') }} <span class="text-primary fw-bold">{{ __('Register here') }}</span>
                </a>
            </div>

            <div class="d-flex align-items-center justify-content-end mb-4">
                @if (Route::has('password.request'))
                <a class="text-decoration-underline" href="{{ route('password.request') }}">
                    {{ __('Forgot your password?') }}
                </a>
                @endif

                <button type="submit" class="btn btn-teal ms-3">
                    {{ __('Log in') }}
                </button>
            </div>
        </form>
    </div>
</div>