@extends('layouts.app')

@section('title', 'Search: ' . ' - ' . config('app.name'))

@section('content')
    @include('layouts.subviews.search-navigation')
    @include('layouts.subviews.dashboard')
@endsection
