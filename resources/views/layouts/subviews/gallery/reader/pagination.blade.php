@isset($paginator)
<div class="reader-bar">
    <div class="reader-menu-left">
        <a href="{{ isset($gallery) ? route('galleries.show', $gallery->id) : "/" }}" class="items mt-sm mb-sm pl-med pr-med p-sm">
            <i class="fas fa-reply"></i>
        </a>
    </div>
    <div class="pagination">
        <a href="{{ route('reader.index', [$gallery->id, 1]) }}" class="pagination-items mt-sm mb-sm reader-first size-s">
            <i class="fa fa-chevron-left"></i>
            <i class="fa fa-chevron-left"></i>
        <a>
        <a href="{{ route('reader.index', [$gallery->id, $paginator['previous']]) }}" class="pagination-items mt-sm mb-sm reader-previous size-s">
            <i class="fa fa-chevron-left"></i>
        </a>
        <button class="pagination-items mt-sm mb-sm reader-position size-s">
            <span class="bold reader-counter">{{ $paginator['currentPage'] }}</span>
            <span class="bold">{{ " / ".$paginator['totalPages'] }}</span>
        </button>
        <a href="{{ route('reader.index', [$gallery->id, $paginator['next']]) }}" class="pagination-items mt-sm mb-sm reader-next size-s">
            <i class="fa fa-chevron-right"></i>
        </a>
        <a href="{{ route('reader.index', [$gallery->id, $paginator['totalPages']]) }}" class="pagination-items mt-sm mb-sm reader-last size-s">
            <i class="fa fa-chevron-right"></i>
            <i class="fa fa-chevron-right"></i>
        </a>
    </div>
    <div class="reader-menu-right">
        <a href="{{ isset($gallery) ? route('galleries.show', $gallery->id) : "/" }}" class="items mt-sm mb-sm pl-med pr-med p-sm">
            <i class="fas fa-reply"></i>
        </a>
    </div>
</div>
@endisset

