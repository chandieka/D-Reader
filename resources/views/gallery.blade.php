@extends('layouts.app')

@section('title',  config('app.name').' - title')

@section('content')
@isset($gallery)
<div class="container gallery">
    <div class="gallery-thumb">
        <a href="{{ isset($pages) ? route('galleries.reader', [$gallery->id, 1]) : "/" }}">
            <img src="{{ $gallery->thumbnail }}" alt="gallery-thumbnail">
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
        </div>
        <div class="gallery-meta">
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
    <div class="page-collections">
        @foreach ($pages as $page)
        <div class="page">
            <a href="{{ route('galleries.reader', [$gallery->id, $page->page_number]) }}" class="page-link">
                <img src="{{ $page->filename }}" alt="page-number" class="page-thumbnail">
            </a>
        </div>
        @endforeach
    </div>
</div>
@endisset
@endsection

