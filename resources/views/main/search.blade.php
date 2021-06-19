@extends('layouts.app')

@section('title', config('app.name').' - Search: ')

@section('content')
    @include('layouts.subviews.search-navigation')
    @include('layouts.subviews.dashboard')
@endsection
