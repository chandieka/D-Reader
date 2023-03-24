@extends('layouts.app')

@section('title','Favorites')

@section('content')
<div class="container center mt-sm mb-sm">
    <div class="container-title shadow">
        <h1 class="inline-block p-sm pl-med font-big">
            Favorites - {{ $user->name }}<span style="color: red;">#</span>{{ $user->id }}
        </h1>
        <h1 class="details inline-block p-sm pr-med pl-med font-big">
            {{ $user->favorites->count() }}
        </h1>
    </div>
</div>
<div class="container standard shadow mt-sm">
    <div class="options">

    </div>
    @include('layouts.subviews.pagination')
    <div class="card-collections">
        @foreach ($galleries as $gallery )
        <a href="{{ route('galleries.show', $gallery->id) }}" class="card standard card-black">
            <div class="card-container">
                <div class="card-thumb">
                    {{-- <img src="{{ ($gallery->thumbnail == null) ? asset('img/default/NotFound-720p.png')) }}" alt="Not Found"> --}}
                    {{-- WARNING: it will broke if gallery dont have pages --}}
                    {{-- <img src="{{ asset('/assets/galleries/' . $gallery->dir_path . '/' . $gallery->pages[0]->filename) }}" alt="Not Found"> --}}
                    @if (isset($gallery->thumbnail))
                        <img src="{{ asset('/assets/thumbnails/' . $gallery->dir_path . '/' . $gallery->thumbnail) }}" alt="thumbnail">
                    @else
                        <img src="{{ asset('/img/default/NotFound-720p.png') }}" alt="default-thumbnail">
                    @endif
                </div>
                <div class="card-info">
                    <p class="card-info-title font-sm">
                        {{ App\Libraries\Utils::stringShortener($gallery->title, 50) }}
                    </p>
                </div>
            </div>
        </a>
        @endforeach
    </div>
    @include('layouts.subviews.pagination')
</div>
@endsection
