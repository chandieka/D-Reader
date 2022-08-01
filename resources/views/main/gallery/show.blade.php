@extends('layouts.app')

@isset($gallery)
@section('title', $gallery->title)
@endisset

@section('content')
@isset($gallery)
<div class="container standard shadow gallery mt-med">
    <div class="gallery-thumb">
        {{-- if page var is set then give the link for first page else none --}}
        <a href="{{ isset($pages) ? route('reader.index', [$gallery->id, 1]) : "/" }}">
            @if (isset($pages[0]) && isset($gallery->thumbnail))
            <img src="{{ asset('/assets/thumbnails/' . $gallery->dir_path . '/' . $gallery->thumbnail) }}" alt="gallery-thumbnail">
            @endif
        </a>
    </div>
    <div class="gallery-info">
        {{-- Gallery info --}}
        <div class="gallery-title p-med mb-med">
            <h1 class="title big mb-med">
                {{ $gallery->title }}
            </h1>
            <h2 class="title med fade mb-med">
                {{ $gallery->title_original }}
            </h2>
            <h2 class="title med fade">
                #{{ $gallery->id }}
            </h2>
        </div>
        <div class="gallery-meta">
            <div class="gallery-meta-options">
                <div class="gallery-meta-option gallery-meta-option-tags bold font-large pr-big pl-big pt-sm pb-sm selected">
                    Tags
                </div>
                <div class="gallery-meta-option gallery-meta-option-details bold font-large pr-big pl-big pt-sm pb-sm">
                    Details
                </div>
            </div>
            <div class="gallery-meta-selections p-med mb-med">
                <div class="gallery-meta-selection gallery-meta-selection-details">
                    <div class="gallery-tags">
                        <span class="description inline-block bold font-sm pt-sm pb-sm">Type: </span>
                        <span class="tags">
                            <span class="pill bold mt-xsm mb-xsm font-sm">Doujin</span>
                        </span>
                    </div>
                    <div class="gallery-tags">
                        <span class="description inline-block bold font-sm pt-sm pb-sm">Uploader: </span>
                        <span class="tag">
                            <span class="pill bold mt-xsm mb-xsm font-sm">
                                {{ $gallery->user->name }}
                                <span class="font-sm" style="color: rgba(255, 0, 0, 0.5)">#</span>
                                {{$gallery->user->id}}
                            </span>
                        </span>
                    </div>
                    <div class="gallery-tags">
                        <span class="description inline-block bold font-sm pt-sm pb-sm">Date added: </span>
                        <span class="tag">
                            <span class="pill bold mt-xsm mb-xsm font-sm">{{ $gallery->created_at->format('d-m-Y') }}</span>
                        </span>
                    </div>
                    <div class="gallery-tags">
                        <span class="description inline-block bold font-sm pt-sm pb-sm">Total pages: </span>
                        <span class="tag">
                            <span class="pill bold mt-xsm mb-xsm font-sm">
                                @if (isset($pages))
                                {{ $pages->count() }}
                                @else
                                0 pages
                                @endif
                            </span>
                        </span>
                    </div>
                    <div class="gallery-tags">
                        <span class="description inline-block bold font-sm pt-sm pb-sm">Favorites: </span>
                        <span class="tag">
                            <span class="pill bold mt-xsm mb-xsm font-sm">
                                0
                            </span>
                        </span>
                    </div>
                    <div class="gallery-tags">
                        <span class="description inline-block bold font-sm pt-sm pb-sm">Views: </span>
                        <span class="tag">
                            <span class="pill bold mt-xsm mb-xsm font-sm">
                                {{ $views }}
                            </span>
                        </span>
                    </div>
                </div>
                <div class="gallery-meta-selection gallery-meta-selection-tags show">
                    <div class="gallery-tags">
                        <span class="description inline-block bold font-sm pt-sm pb-sm">Tags: </span>
                        <span class="tags">
                            @for ($i = 0; $i < 10; $i++)
                            <span class="pill bold mt-xsm mb-xsm font-sm">Test test</span>
                            @endfor
                        </span>
                    </div>
                </div>
            </div>
            <div class="gallery-action p-sm">
                <button class="btn btn-red font-large pl-med pr-med m-sm">
                    <span class="bold">Favorites</span>
                </button>
                <button class="btn btn-red font-large pl-med pr-med m-sm">
                    <span class="bold">Download</span>
                </button>
            </div>
        </div>
    </div>
    @auth
    @if (Auth::user()->id === $gallery->user_id)
    <div class="gallery-options p-sm">
        <div class="gallery-option icon default">
            <i class="fas fa-cog fa-lg"></i>
        </div>
        <div class="gallery-option icon default">
            <i class="fas fa-trash-alt fa-lg"></i>
        </div>
        <div class="gallery-option icon default">
            <i class="far fa-edit fa-lg"></i>
        </div>
    </div>
    @endif
    @endauth
</div>
@endisset
@include('layouts.subviews.gallery.page.show')
@endsection

@section('scripts')
<script type="module" src="{{ asset('js/gallery/show/eventHandler.js') }}"></script>
@endsection

