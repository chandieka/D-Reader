@extends('layouts.app')

@section('title',  $gallery->title." - list")

@section('content')
<div class="reader" id="reader">
    <div class="reader-bar pt-sm pb-sm">
        <div class="reader-menu-left">
            <a href="{{ isset($gallery) ? route('galleries.show', $gallery->id) : "/" }}" class="items icon default ml-sm p-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div class="reader-menu-right">
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
        <div class="reader-menu-left pt-sm pb-sm">
            <a href="{{ isset($gallery) ? route('galleries.show', $gallery->id) : "/" }}" class="items icon default ml-sm p-sm">
                <i class="fas fa-arrow-left"></i>
            </a>
        </div>
        <div class="reader-menu-right">
            <svg data-v-20f285ec="" data-v-6b3fd699="" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <path data-v-20f285ec="" d="M20 2v6a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V2m0 20v-6a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"></path>
            </svg>
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
