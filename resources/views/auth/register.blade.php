@extends('layouts.app')

@section('title',  config('app.name').' - Register')

@section('content')
<div class="content-auth">
    @include('auth.header')
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name" class="label">{{ __('Name') }}</label>
            <input id="name" type="text" class="form-input" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
        </div>
        <div class="form-group">
            <label for="email" class="label">{{ __('E-Mail Address') }}</label>
            <input id="email" type="email" class="form-input" name="email" value="{{ old('email') }}" required autocomplete="email">
        </div>
        <div class="form-group">
            <label for="password" class="label">{{ __('Password') }}</label>
            <input id="password" type="password" class="form-input" name="password" required autocomplete="new-password">
        </div>
        <div class="form-group">
            <label for="password-confirm" class="label">{{ __('Confirm Password') }}</label>
            <input id="password-confirm" type="password" name="password_confirmation" class="form-input" required autocomplete="new-password">
        </div>
        <div class="form-group">
            <span>Already have an account?</span>
            <a href="{{ route('login') }}" class="capsule">Click Here!</a>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-auth">
                {{ __('Register') }}
            </button>
        </div>
    </form>
</div>
@endsection
