@extends('layouts.app')

@isset($gallery)
@section('title',  config('app.name').' - '.$gallery->title)
@endisset

@section('content')
@isset($gallery)
<div class="container standard gallery mt-med">
    <div class="gallery-thumb">
        {{-- if page var is set then give the link for first page else none --}}
        <a href="{{ isset($pages) ? route('galleries.reader', [$gallery->id, 1]) : "/" }}">
            @if (isset($pages[0]))
            {{-- retrive 1st Page to be Thumbnail  --}}
                {{-- <img src="{{asset('/assets/galleries/'.$gallery->dir_path.'/'.$pages[0]->filename)}}" alt="{{ $pages[0]->filename }}"> --}}
                <img src="{{ asset('/assets/thumbnails/' . $gallery->dir_path . '/' . $gallery->thumbnail) }}" alt="gallery-thumbnail">
                {{-- @else
                @if ($gallery->thumbnail == null)
                    <img src="{{ asset('img/default/NotFound-720p.png') }}" alt="gallery-thumbnail">
                @else
                    <img src="{{ asset($gallery->thumbnail) }}" alt="gallery-thumbnail">
                @endif --}}
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
                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                        Eaque praesentium ex enim dolore temporibus veritatis recusandae nisi qui,
                        asperiores natus ullam, minima totam consequatur quibusdam ab officiis veniam
                        ipsum debitis.
                    </p>
                </div>
                <div class="gallery-meta-tags">
                    <p>
                        Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                        Eaque praesentium ex enim dolore temporibus veritatis recusandae nisi qui,
                        asperiores natus ullam, minima totam consequatur quibusdam ab officiis veniam
                        ipsum debitis.
                    </p>
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

