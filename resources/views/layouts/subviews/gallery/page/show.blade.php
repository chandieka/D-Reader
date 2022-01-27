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
