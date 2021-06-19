@isset($paginator)
<div class="center">
    <div class="pagination mb-med mt-med">
        @php
        $currentPage = $paginator['currentPage'];
        $totalPage = $paginator['totalPage'];
        $uri = $paginator['uri'];
        @endphp
        {{-- only shows when its not on left end --}}
        @if ($currentPage != 1)
        <a href="{{ $uri."1" }}" class="pagination-items">
            <i class="fa fa-chevron-left"></i>
            <i class="fa fa-chevron-left"></i>
        </a>
        <a href="{{ $uri.$currentPage - 1 }}" class="pagination-items">
            <i class="fa fa-chevron-left"></i>
        </a>
        @endif
        {{-- Left hand page --}}
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
        {{-- Righ hand page --}}
        @php
        for ($i = 1; $i + $currentPage <= $totalPage && $i <= 3; $i++) {
            $page = $currentPage + $i;
            echo "<a href=\"$uri$page\" class=\"pagination-items\">$page</a>";
        }
        @endphp
        {{-- only shows when its not on right end --}}
        @if ($currentPage < $totalPage)
        <a href="/" class="pagination-items">...</a>
        <a href="{{ $uri.$currentPage + 1 }}" class="pagination-items">
            <i class="fa fa-chevron-right"></i>
        </a>
        <a href="{{ $uri.$paginator['lastPage'] }}" class="pagination-items">
            <i class="fa fa-chevron-right"></i>
            <i class="fa fa-chevron-right"></i>
        </a>
        @endif
    </div>
</div>
@endisset


