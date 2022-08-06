@isset($paginator)
<div class="center">
    <div class="pagination mb-med mt-med">
        @php
        $currentPage = $paginator['currentPage'];
        $totalPages = $paginator['totalPages'];
        $uri = $paginator['uri'];
        @endphp
        {{-- first Page --}}
        @if ($currentPage != 1)
        <a href="{{ $uri."1" }}" class="pagination-items">
            <i class="fa fa-chevron-left"></i>
            <i class="fa fa-chevron-left"></i>
        </a>
        <a href="{{ $uri.$currentPage - 1 }}" class="pagination-items">
            <i class="fa fa-chevron-left"></i>
        </a>
        @else
        <a class="pagination-items disabled">
            <i class="fa fa-chevron-left"></i>
            <i class="fa fa-chevron-left"></i>
        </a>
        <a class="pagination-items disabled">
            <i class="fa fa-chevron-left"></i>
        </a>
        @endif
        {{-- previous page --}}
        @php
        $i = $currentPage - 3; // previous pages
        $j = 0; // loop counter
        while ($i < $currentPage && $j <= 3) {
            if ($i > 0){
                echo "<a href=\"$uri$i\" class=\"pagination-items\">$i</a>";
            }
            $i++;
            $j++;
        }
        @endphp
        {{-- Current page --}}
        <a href="{{ $uri.$currentPage }}" class="pagination-items pagination-active">{{ $currentPage }}</a>
        {{-- next page --}}
        @php
        for ($i = 1; $i + $currentPage <= $totalPages && $i <= 3; $i++) {
            $page = $currentPage + $i;
            echo "<a href=\"$uri$page\" class=\"pagination-items\">$page</a>";
        }
        @endphp
        {{-- Last Page --}}
        @if ($currentPage < $totalPages)
        <a class="pagination-items page-jump">...</a>
        <a href="{{ $uri.$currentPage + 1 }}" class="pagination-items">
            <i class="fa fa-chevron-right"></i>
        </a>
        <a href="{{ $uri.$paginator['lastPage'] }}" class="pagination-items">
            <i class="fa fa-chevron-right"></i>
            <i class="fa fa-chevron-right"></i>
        </a>
        @else
        <a class="pagination-items disabled">
            <i class="fa fa-chevron-right"></i>
        </a>
        <a class="pagination-items disabled">
            <i class="fa fa-chevron-right"></i>
            <i class="fa fa-chevron-right"></i>
        </a>
        @endif
    </div>
</div>
@endisset


