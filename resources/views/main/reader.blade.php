@extends('layouts.app')

@section('title',  config('app.name')." - ".$gallery->title." - Page ".$paginator['currentPage'])

@section('content')
<div class="reader">
    @include('layouts.subviews.reader-pagination')
    <div class="reader-img">
        <img src="{{ asset('img/default/NotFound-720p.png') }}" alt="page-1" id="reader-page" class="point">
    </div>
    @include('layouts.subviews.reader-pagination')
</div>
@endsection
@section('scripts')
<script>
    var gallery = @json($gallery);
    var pages = @json($pages);
    var paginator = @json($paginator);
    const max = 5;
    let counter = 0;

    // every filename is different
    let image1 = new Image();
    image1.src = pages[1].filename;
    image1.onload = ()
    let image2 = new Image();
    image1.src = pages[2].filename;
    let image3 = new Image();
    image1.src = pages[3].filename;
    let image4 = new Image();
    image1.src = pages[4].filename;
    let image5 = new Image();
    image1.src = pages[5].filename;
    let image6 = new Image();
    image1.src = pages[6].filename;

    const images = pages.slice(0, 6);

    const loadImage = (src) => {
        if (!src) return;
        const img = new Image();

        img.src = src;
        img.onload = () => loadImage(images.pop());
    }

    loadImage(images.pop());
</script>
<script src="{{ asset('js/reader/eventHandler.js') }}"></script>
@endsection
