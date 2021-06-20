@extends('layouts.app')

@section('title',  config('app.name').' - Home')

@section('content')
<div class="content">
    <form action="/test" enctype="multipart/form-data" class="form-group" method="POST">
        @csrf
        <input type="file" name="file" id="file" class="form-items">
        <input type="submit" class="btn">
    </form>
</div>
@endsection
