<div class="container standard shadow">
    <div class="options">

    </div>
    @isset($galleries)
    <div class="card-collections">
        @foreach ($galleries as $gallery )
        <a href="{{ route('galleries.show', $gallery->id) }}" class="card standard card-black @if($gallery->isHidden) card-hidden @endif">
            <div class="card-container">
                <div class="card-thumb">
                    @if (isset($gallery->thumbnail))
                        <img src="{{ asset('/assets/thumbnails/' . $gallery->dir_path . '/' . $gallery->thumbnail) }}" alt="thumbnail">
                    @else
                        <img src="{{ asset('/img/default/NotFound-720p.png') }}" alt="default-thumbnail">
                    @endif
                </div>
                <div class="card-info">
                    <p class="card-info-title font-sm">
                        {{ App\Customs\Utils::stringShortener($gallery->title, 50) }}
                    </p>
                </div>
            </div>
            @if($gallery->isHidden)
            <div class="card-hidden-icon">
                <i class="far fa-eye-slash fa-6x"></i>
            </div>
            @endif
        </a>
        @endforeach
    </div>
    @endisset
</div>
