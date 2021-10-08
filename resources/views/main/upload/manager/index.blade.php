@extends('layouts.app')

@section('title',  config('app.name').' - Uploads Manager')

@section('content')
<div class="container mt-med">
    <h1 class="center page-title">
        Upload Manager - USERNAME<span style="color: red;">#</span>123425
    </h1>
</div>
<div class="container">
    <div class="manager-selections">
        @if (isset($archives))
        <a href="{{ route('uploads.archives') }}" class="manager-selection bold mr-med pr-med pl-med pt-sm pb-sm selected">
            Archives (<span style="color: red">{{ $archives_count }}</span>)
        </a>
        <a href="{{ route('uploads.galleries') }}" class="manager-selection bold mr-med pr-med pl-med pt-sm pb-sm">
            Galleries (<span style="color: red">{{ $galleries_count }}</span>)
        </a>
        @elseif (isset($galleries))
        <a href="{{ route('uploads.archives') }}" class="manager-selection bold mr-med pr-med pl-med pt-sm pb-sm">
            Archives (<span style="color: red">{{ $archives_count }}</span>)
        </a>
        <a href="{{ route('uploads.galleries') }}" class="manager-selection bold mr-med pr-med pl-med pt-sm pb-sm selected">
            Galleries (<span style="color: red">{{ $galleries_count }}</span>)
        </a>
        @endif
    </div>
</div>
<div class="manager-wrapper content mt-med mb-med">
    <div class="manager-wrapper-items manager-options">

    </div>
    @include('layouts.subviews.pagination')
    <div class="manager-wrapper-items">
        <div class="manager-collections column">
            @if (isset($galleries))
            @include('layouts.subviews.upload.manager.galleries')
            @elseif (isset($archives))
            @include('layouts.subviews.upload.manager.archives')
            @endif
            <a href="{{ route('galleries.create') }}" class="manager-items manager-new">
                <i class="fas fa-plus fa-3x fa-fw"></i>
            </a>
        </div>
    </div>
    @include('layouts.subviews.pagination')
</div>
@endsection
