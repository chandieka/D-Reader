@extends('layouts.app')

@section('title',  'Profile: ' . $user->name . '#' .  $user->id)

@section('content')
<div class="container shadow big profile mt-sm mb-sm">
    <div class="profile-header pb-med">
        <div class="profile-header-items">
            <div class="profile-header-item thumbnail ml-med mr-med">
                <img src="{{ asset('Logo.png') }}" alt="user profile">
            </div>
            <div class="profile-header-item info">
                <h1 class="font-big mb-sm">{{ $user->name }}<span style="color: red">#</span>{{ $user->id }}</h1>
                <span class="font-sm mb-sm">Joined: 00-00-000</span>
                <span class="font-sm mb-sm">Last Seen: 00-00-000</span>
                <div class="profile-tools">
                    <a href="" class="btn standard mr-sm">
                        My Collections
                    </a>
                    {{-- {{-- <a href="" class="btn standard mr-sm">
                        Some random Button
                    </a> --}}
                    <a href="" class="btn standard mr-sm">
                        Some random Button
                    </a>
                </div>
            </div>
        </div>
        @auth
        @if (Auth::user()->id == $user->id)
        <a href="{{ route('users.edit', $user->id) }}" class="profile-setting icon default mr-sm mt-sm">
            <i class="fas fa-cog fa-lg"></i>
        </a>
        @endif
        @endauth
    </div>
    <div class="profile-content p-med">
        <p>
            Lorem ipsum dolor sit amet consectetur adipisicing elit. Eveniet, similique nesciunt mollitia nam ullam accusantium temporibus unde cum.
            Earum nihil possimus id asperiores fugit animi expedita soluta recusandae tempore perferendis.
        </p>
    </div>
</div>
@endsection
