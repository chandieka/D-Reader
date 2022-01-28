@extends('layouts.app')

@section('title',  'Create New Gallery')

@section('content')
<div class="container center mt-sm">
    <h1 class="container-title p-sm pl-med pr-med">
        Create New Gallery
    </h1>
</div>
<div class="container standard medium mt-med mb-med p-med">
    <form action="{{ route('galleries.store') }}" method="POST" enctype="multipart/form-data" class="form">
        @csrf
        <div class="form-group">
            <label for="title" class="label bold">Gallery Title</label>
            <p class="title fade mb-med font-sm">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio odio dicta consectetur, dolorum voluptate dignissimos recusandae
                voluptas id aliquid rerum consequuntur placeat libero ratione architecto perspiciatis quidem commodi nostrum? Quibusdam.
            </p>
            <input type="text" name="title" id="title" class="form-control" placeholder="Title..."></input>
            @error('title')
            <div class="form-error">
                <span class="error">{{ $message }}</span>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <label for="titleOriginal" class="label bold">Original Title</label>
            <p class="title fade mb-med font-sm">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio odio dicta consectetur, dolorum voluptate dignissimos recusandae
                voluptas id aliquid rerum consequuntur placeat libero ratione architecto perspiciatis quidem commodi nostrum? Quibusdam.
            </p>
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
            <label for="file" class="label bold">Gallery Archived</label>
            <p class="title fade mb-med font-sm">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio odio dicta consectetur, dolorum voluptate dignissimos recusandae
                voluptas id aliquid rerum consequuntur placeat libero ratione architecto perspiciatis quidem commodi nostrum? Quibusdam.
            </p>
            <div class="form-control mb-big">
                <input type="file" name="file" id="file">
            </div>
            @error('file')
            <div class="form-error">
                <span class="error">{{ $message }}</span>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="submit" value="Save Gallery" class="btn standard">
            <button class="btn info">Reset</button>
        </div>
    </form>
</div>
@endsection
