@extends('layouts.app')

@section('title', 'D-Reader Home')

@section('content')
    @include('layouts.type')
    @include('layouts.dashboard')
    @include('layouts.pagination')
@endsection

