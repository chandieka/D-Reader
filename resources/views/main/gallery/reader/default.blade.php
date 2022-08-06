@extends('layouts.app')

@section('title',  $gallery->title." - Page " . $paginator['currentPage'])

@section('content')
<div class="reader" id="reader">
    @include('layouts.subviews.gallery.reader.pagination')
    <div class="reader-img">
        <img src="{{ asset('/assets/galleries/'.$gallery->dir_path.'/'.$pages[$paginator['currentPage'] - 1]['filename']) }}"
        alt="page-1" id="reader-page" class="point">
    </div>
    @include('layouts.subviews.gallery.reader.pagination')
</div>
@endsection
@section('scripts')
<script>
    const gallery = @json($gallery);
    const pages = @json($pages);
    const paginator = @json($paginator);
</script>
<script src="{{ asset('js/gallery/reader/eventHandler.js') }}"></script>
@endsection
