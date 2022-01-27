@extends('layouts.app')

@section('title','Users Edit')

@section('content')
<div class="container center mt-sm">
    <h1 class="container-title p-sm pl-med pr-med">
        User Edit - {{ $user->name }}<span style="color: red">#</span>{{ $user->id }}
    </h1>
</div>
<div class="container standard small mt-sm mb-sm">
    <form method="POST" action="{{ route('register') }}">
        @csrf
        <div class="form-group">
            <label for="name" class="label">Name</label>
            <input id="name" type="text" class="form-control large" name="name" value="{{ $user->name }}"
            required autocomplete="name" autofocus placeholder="Username...">
        </div>
        <div class="form-group">
            <label for="email" class="label">E-Mail Address</label>
            <input id="email" type="email" class="form-control large" name="email" value="{{ $user->email }}"
            required autocomplete="email"  placeholder="Pattern: /.*@.*">
        </div>
        <div class="form-group">
            <label for="password" class="label">Old Password</label>
            <input id="password" type="password" class="form-control large" name="old_password"
            required autocomplete="old_password"" placeholder="Old Password...">
        </div>
        <div class="form-group">
            <label for="password" class="label">New Password</label>
            <input id="password" type="password" class="form-control large" name="new_password"
            required autocomplete="new_password"" placeholder="New Password...">
        </div>
        <div class="form-group mt-big">
            <button type="submit" class="btn btn-auth standard">
                    Update
            </button>
        </div>
    </form>
</div>
@endsection
