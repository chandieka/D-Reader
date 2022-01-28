@extends('layouts.app')
@section('title', 'Gallery Edit #'. $gallery->id)

@section('content')
<div class="title-container center mt-sm">
    <h1 class="title-container-item p-sm pl-med pr-med">
        Gallery Edit - <span style="color: red;">#</span>{{ $gallery->id }}
    </h1>
</div>
<div class="container standard medium mt-med mb-med p-med">
    <h2 class="center mb-med">Warning: Any change that will be make is permanent!</h2>
    <form action="{{ route('galleries.update', $gallery->id) }}" method="POST">
        @method('PUT')
        @csrf
        <div class="form-group">
            <label for="title" class="label bold">Gallery Title</label>
            <p class="title fade mb-med font-sm">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio odio dicta consectetur, dolorum voluptate dignissimos recusandae
                voluptas id aliquid rerum consequuntur placeat libero ratione architecto perspiciatis quidem commodi nostrum? Quibusdam.
            </p>
            <input type="text" name="title" id="title" class="form-control" placeholder="Title..." value="{{ $gallery->title }}"></input>
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
            <input type="text" name="titleOriginal" id="titleOriginal" class="form-control" placeholder="Original Title..." value="{{ $gallery->title_original }}"></input>
            @error('titleOriginal')
            <div class="form-error">
                <span class="error">{{ $message }}</span>
            </div>
            @enderror
        </div>
        <div class="form-group">
            <input type="submit" value="Save Gallery" class="btn standard">
            {{-- <button class="btn info">Reset</button> --}}
        </div>
        {{-- other stuff --}}
    </form>
</div>
@endsection
