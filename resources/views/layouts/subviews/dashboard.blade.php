<div class="content">
    <div class="option">
        <div class="option-sort">
            {{-- Sort --}}
        </div>
        <div class="option-limit">
            {{-- display limit (e.g 50 per page or 100 per page) --}}
            {{-- <button class="btn">25</button>
            <button class="btn">50</button>
            <button class="btn">100</button> --}}
        </div>
        <div class="option-mode">
            {{-- Display mode --}}
        </div>
    </div>
    @isset($galleries)
    <div class="card-collections">
        @foreach ($galleries as $gallery )
        <a href="{{ route('galleries.show', $gallery->id) }}" class="card card-black">
            <div class="card-thumb">
                {{-- <img src="{{ ($gallery->thumbnail == null) ? asset('img/default/NotFound-720p.png')) }}" alt="Not Found"> --}}
                {{-- WARNING: will broke if gallery dont have pages --}}
                {{-- <img src="{{ asset('/assets/galleries/' . $gallery->dir_path . '/' . $gallery->pages[0]->filename) }}" alt="Not Found"> --}}
                <img src="{{ asset('/img/default/NotFound-720p.png') }}" alt="default-thumbnail">
            </div>
            <div class="card-info">
                <p class="card-info-title">
                    {{ $gallery->id.": ".App\Customs\Utils::stringShortener($gallery->title, 52) }}
                </p>
            </div>
        </a>
        @endforeach
    </div>
    @endisset
</div>
