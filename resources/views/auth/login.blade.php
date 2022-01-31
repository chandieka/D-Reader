@extends('layouts.app')

@section('title',  config('app.name').' - Login')

@section('content')
{{-- standard scaffold --}}
<div class="content-auth">
    @include('auth.header')
    <form method="POST" action="{{ route('login') }}">
        @csrf
        {{-- Email address --}}
        <div class="form-group">
            <label for="email" class="label">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control large" name="email" required autocomplete="email" autofocus placeholder="Pattern: /.*@.*/" value="{{ old('email') }}">
        </div>
        {{-- Password --}}
        <div class="form-group">
            <label for="password" class="label">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control large" name="password" required autocomplete="current-password" placeholder="Password...">
        </div>
        {{-- Remembered me --}}
        <div class="form-group">
            <label class="switch">
                <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                <span class="slider round"></span>
            </label>
            <label class="label v-center" for="remember">
                {{ __('Remember Me') }}
            </label>
        </div>
        {{-- Submit button --}}
        <div class="form-group">
            <button type="submit" class="btn btn-auth standard">
                {{ __('Login') }}
            </button>
        </div>
        <div class="form-group">
            @if (Route::has('password.request'))
            <a class="form-control-info" href="{{ route('password.request') }}">
                {{ __('Forgot Your Password?') }}
            </a>
            @endif
        </div>
    </form>
</div>
@endsection

