@extends('layouts.app')

@section('title',  config('app.name').' - Create New Gallery')


@section('content')
<div class="container mt-med mb-med p-med">
    <form action="" method="POST" enctype="multipart/form-data" class="form">
        <div class="form-group">
            <label for="title" class="label">Gallery Title</label>
            <input type="text" name="title" id="title"></input>
        </div>
        <div class="form-group">
            <label for="titleOriginal" class="label">Original Title</label>
            <input type="text" name="titleOriginal" id="titleOriginal"></input>
        </div>
        <div class="form-group">
            <label for="category" class="label">Category</label>
            <select name="category" id="category">
                <option value="1" selected>Doujinshi</option>
                <option value="2">Manga</option>
                <option value="3">3D Artist</option>
                <option value="4">Western</option>
                {{-- <option value="5"></option> --}}
            </select>
        </div>
        <div>
            <label for="file"></label>
            <input type="file" name="file" id="file">
        </div>
    </form>
</div>
@endsection
