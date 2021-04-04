@extends('layouts.app')

@section('title', 'D-Reader Home')

@section('content')
    @include('layouts.subviews.type')
    @include('layouts.subviews.dashboard')
    @include('layouts.subviews.pagination')
@endsection

