@extends('layouts.app')

@section('title',  'Create New Gallery - ' . config('app.name'))

@section('content')
<div class="container standard mt-med mb-med p-med">

    <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data" class="form">
        @csrf
        <div class="form-group">
            <label for="title" class="label">Gallery Title</label>
            <input type="text" name="title" id="title" class="form-control" placeholder="Title..."></input>
            @error('title')
            <div class="form-error">
                <span class="error">{{ $message }}</span>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="titleOriginal" class="label">Original Title</label>
            <input type="text" name="titleOriginal" id="titleOriginal" class="form-control" placeholder="Original Title..."></input>
            @error('titleOriginal')
            <div class="form-error">
                <span class="error">{{ $message }}</span>
            </div>
            @enderror
        </div>
        {{-- <div class="form-group">
            <label for="category" class="label">Category</label>
            <select name="category" id="category" class="form-select">
                <option value="1"  class="form-options" selected>Doujinshi</option>
                <option value="2" class="form-options">Manga</option>
                <option value="3" class="form-options">3D Artist</option>
                <option value="4" class="form-options">Western</option>
            </select>
        </div> --}}
        <div class="form-group">
            <label for="file">Gallery Archived</label>
            <div class="form-control">
                <input type="file" name="file" id="file">
            </div>
            @error('file')
            <div class="form-error">
                <span class="error">{{ $message }}</span>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="submit" value="Save Gallery" class="btn">
            <button class="btn info">Reset</button>
        </div>
    </form>
    {{-- @php
        foreach ($errors as $error) {
            dd($error);
            echo "hello";
        }
    @endphp --}}
</div>
@endsection
