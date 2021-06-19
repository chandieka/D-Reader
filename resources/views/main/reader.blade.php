@extends('layouts.app')

@section('title',  config('app.name')." - ".$gallery->title." - Page ".$paginator['currentPage'])

@section('content')
<div class="reader">
    @include('layouts.subviews.reader-pagination')
    <div class="reader-img">
        <img src="{{ asset('img/default/NotFound-720p.png') }}" alt="page-1" id="reader-page">
    </div>
    @include('layouts.subviews.reader-pagination')
</div>
@endsection

@section('scripts')
<script>
    var gallery = @json($gallery);
    var pages = @json($pages);
    var paginator = @json($paginator);
</script>
<script src="{{ asset('js/reader/eventHandler.js') }}"></script>
@endsection
