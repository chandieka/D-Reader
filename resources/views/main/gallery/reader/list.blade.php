@extends('layouts.app')

@section('title',  $gallery->title." - list")

@section('content')
<div class="reader" id="reader">
    <div class="reader-bar">
        <div class="reader-menu-left">
            <a href="{{ isset($gallery) ? route('galleries.show', $gallery->id) : "/" }}" class="items mt-sm mb-sm pl-med pr-med p-sm">
                <i class="fas fa-reply"></i>
            </a>
        </div>
        <div class="reader-menu-right">
            <a href="{{ isset($gallery) ? route('galleries.show', $gallery->id) : "/" }}" class="items mt-sm mb-sm pl-med pr-med p-sm">
                <i class="fas fa-reply"></i>
            </a>
        </div>
    </div>
    <div class="reader-img">
        @foreach ($pages as $page)
        <img src="{{ asset('/assets/galleries/'.$gallery->dir_path.'/'.$page['filename']) }}" class="small" id="page-{{ $page->page_number }}"
            alt="page-{{ $page->page_number }}">
        @endforeach
    </div>
    <script>
        let imgs = document.querySelector('.reader-img').children;
        Array.from(imgs).forEach(e => {
            console.log(e.offsetTop);
        });
    </script>
    <div class="reader-bar">
        <div class="reader-menu-left">
            <a href="{{ isset($gallery) ? route('galleries.show', $gallery->id) : "/" }}" class="items mt-sm mb-sm pl-med pr-med p-sm">
                <i class="fas fa-reply"></i>
            </a>
        </div>
        <div class="reader-menu-right">
            <a href="{{ isset($gallery) ? route('galleries.show', $gallery->id) : "/" }}" class="items mt-sm mb-sm pl-med pr-med p-sm">
                <i class="fas fa-reply"></i>
            </a>
        </div>
    </div>
</div>
@endsection
@section('scripts')
<script>
    const gallery = @json($gallery);
    const pages = @json($pages);
</script>
{{-- <script src="{{ asset('js/gallery/reader/eventHandler.js') }}"></script> --}}
@endsection
