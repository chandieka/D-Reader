@isset($paginator)
<div class="reader-bar">
    <div class="reader-menu-left">
        <a href="{{ isset($gallery) ? route('galleries.show', $gallery->id) : "/" }}" class="items mt-sm mb-sm pl-med pr-med p-sm">
            <i class="fas fa-reply"></i>
        </a>
    </div>
    <div class="pagination">
        <button class="pagination-items mt-sm mb-sm reader-first">
            <i class="fa fa-chevron-left"></i>
            <i class="fa fa-chevron-left"></i>
        <button>
        <button class="pagination-items mt-sm mb-sm reader-previous">
            <i class="fa fa-chevron-left"></i>
        </button>
        <button class="pagination-items mt-sm mb-sm reader-position">
            <span class="bold reader-counter">{{ $paginator['currentPage'] }}</span>
            <span class="bold">{{ " / ".$paginator['totalPages'] }}</span>
        </button>
        <button href="/" class="pagination-items mt-sm mb-sm reader-next">
            <i class="fa fa-chevron-right"></i>
        </button>
        <button href="/" class="pagination-items mt-sm mb-sm reader-last">
            <i class="fa fa-chevron-right"></i>
            <i class="fa fa-chevron-right"></i>
        </button>
    </div>
    <div class="reader-menu-right">

    </div>
</div>
@endisset

