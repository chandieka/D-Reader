@extends('layouts.app')

@section('title',  config('app.name').' - Register')

@section('content')
<div class="content-auth">
    @include('auth.header')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name" class="label">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-control large" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus placeholder="Username...">
        </div>
        <div class="form-group">
            <label for="email" class="label">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-control large" name="email" value="{{ old('email') }}" required autocomplete="email"  placeholder="Pattern: /.*@.*">
        </div>
        <div class="form-group">
            <label for="password" class="label">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-control large" name="password" required autocomplete="new-password" placeholder="Password...">
        </div>
        <div class="form-group">
            <label for="password-confirm" class="label">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" name="password_confirmation" class="form-control large" required autocomplete="new-password" placeholder="Re-password...">
        </div>
        <div class="form-group">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}" class="pill font-sm">Click Here!</a>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-wide standard">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
@endsection
