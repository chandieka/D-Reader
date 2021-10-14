@extends('layouts.app')

@isset($gallery)
@section('title', $gallery->title . ' - ' . config('app.name'))
@endisset

@section('content')
@isset($gallery)
<div class="container standard gallery mt-med">
    <div class="gallery-thumb">
        {{-- if page var is set then give the link for first page else none --}}
        <a href="{{ isset($pages) ? route('galleries.reader', [$gallery->id, 1]) : "/" }}">
            @if (isset($pages[0]) && isset($gallery->thumbnail))
                <img src="{{ asset('/assets/thumbnails/' . $gallery->dir_path . '/' . $gallery->thumbnail) }}" alt="gallery-thumbnail">
            @endif
        </a>
    </div>
    <div class="gallery-info">
        {{-- Gallery info --}}
        <div class="gallery-title">
            <h1 class="title">
               {{ $gallery->title }}
            </h1>
            <h2 class="title fade">
                {{ $gallery->title_original }}
            </h2>
            <h2 class="title fade">
                #{{ $gallery->id }}
            </h2>
        </div>
        <div class="gallery-meta">
            <div class="gallery-meta-collections">
                <div class="gallery-meta-info">
                    <div class="tags">
                        <span class="bold font-sm">Type: </span>
                        {{-- <span class="pill bold m-xsm font-sm"></span> --}}
                    </div>
                    <div class="tags">
                        <span class="bold font-sm">Uploader: </span>
                        <span class="pill bold m-xsm font-sm">{{ $gallery->user->name }}<span class="font-sm" style="color: rgba(255, 0, 0, 0.5)">#</span>{{$gallery->user->id}}</span>
                    </div>
                    <div class="tags">
                        <span class="bold font-sm">Date added: </span>
                        <span class="pill bold m-xsm font-sm">{{$gallery->created_at}}</span>
                    </div>
                    <div class="tags">
                        <span class="bold font-sm">Date updated: </span>
                        <span class="pill bold m-xsm font-sm">{{$gallery->updated_at}}</span>
                    </div>
                    <div class="tags">
                        <span class="bold font-sm">Total pages: </span>
                        <span class="pill bold m-xsm font-sm">
                            @if (isset($pages))
                                {{ $pages->count() }}
                            @else
                                0 pages
                            @endif
                        </span>
                    </div>
                    <div class="tags">
                        <span class="bold font-sm">Favorites: </span>
                        <span class="pill bold m-xsm font-sm">
                            0
                        </span>
                    </div>
                    <div class="tags">
                        <span class="bold font-sm">Favorites: </span>
                        <span class="pill bold m-xsm font-sm">
                            0
                        </span>
                    </div>
                </div>
                <div class="gallery-meta-tags">

                </div>
            </div>
            <div class="gallery-action gallery-meta-items">
                <button class="btn btn-red bold font-large pl-med pr-med mr mr-sm">Favorites</button>
                <button class="btn btn-default bold font-large pl-med pr-med mr-sm">Favorites</button>
            </div>
        </div>
    </div>
</div>
@endisset
@isset($pages)
<div class="container standard">
    <div class="options">
    </div>
    @include('layouts.subviews.gallery.page.pagination')
    <div class="page-collections">
        @foreach ($pages as $page)
        <div class="page">
            <a href="{{ route('galleries.reader', [$gallery->id, $page->page_number]) }}" class="page-link">
                <img src="{{ asset('/assets/thumbnails/'.$gallery->dir_path.'/'.$page->thumbnail) }}" alt="{{ $page->filename }}" class="page-thumbnail">
            </a>
        </div>
        @endforeach
    </div>
    @include('layouts.subviews.gallery.page.pagination')
</div>
@endisset
@endsection

@section('scripts')
<script src="{{ asset('js/gallery/eventHandler.js') }}"></script>
@endsection

