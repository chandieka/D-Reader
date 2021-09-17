@extends('layouts.app')

@isset($gallery)
@section('title',  config('app.name').' - '.$gallery->title)
@endisset

@section('content')
@isset($gallery)
<div class="container gallery mt-med pb-big">
    <div class="gallery-thumb">
        {{-- if page var is set then give the link for first page else none --}}
        <a href="{{ isset($pages) ? route('galleries.reader', [$gallery->id, 1]) : "/" }}">
            @if (isset($pages[0]))
            {{-- retrive 1st Page to be Thumbnail  --}}
                {{-- <img src="{{asset('/assets/galleries/'.$gallery->dir_path.'/'.$pages[0]->filename)}}" alt="{{ $pages[0]->filename }}"> --}}
                <img src="{{ asset('img/default/NotFound-720p.png') }}" alt="gallery-thumbnail">
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
        <div class="gallery-meta mb-med">
            <div class="gallery-meta-info">

            </div>
            <div class="gallery-meta-tags">

            </div>
        </div>
    </div>
</div>
@endisset
@isset($pages)
<div class="container">
    <div class="option">
    </div>
    @include('layouts.subviews.gallery.page.pagination')
    <div class="page-collections">
        @foreach ($pages as $page)
        <div class="page">
            <a href="{{ route('galleries.reader', [$gallery->id, $page->page_number]) }}" class="page-link">
                <img src="{{ asset('/assets/galleries/'.$gallery->dir_path.'/'.$page->filename) }}" alt="{{ $page->filename }}" class="page-thumbnail">
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

