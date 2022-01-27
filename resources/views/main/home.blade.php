@extends('layouts.app')

@section('title', 'Home')

@section('content')
    {{-- @include('layouts.subviews.categories') --}}
    @include('layouts.subviews.pagination')
    @include('layouts.subviews.dashboard')
    @include('layouts.subviews.pagination')
@endsection
