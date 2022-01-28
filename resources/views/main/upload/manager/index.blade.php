@extends('layouts.app')

@section('title', 'Uploads Manager')

@section('content')
<div class="container center mt-sm mb-sm">
    <h1 class="container-title p-sm pr-med pl-med r-font-big">
        Upload Manager - {{Auth::user()->name}}<span style="color: red;">#</span>{{Auth::user()->id}}
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
<div class="container standard mt-med">
    @if (isset($galleries))
    @include('layouts.subviews.upload.manager.option.galleries-option')
    @elseif (isset($archives))
    @include('layouts.subviews.upload.manager.option.archive-option')
    @endif
    @include('layouts.subviews.pagination')
    <div class="scroll">
        @if (isset($galleries))
        @include('layouts.subviews.upload.manager.show.galleries-list')
        @elseif (isset($archives))
        @include('layouts.subviews.upload.manager.show.archives-list')
        @endif
    </div>
    @include('layouts.subviews.pagination')
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/manager/eventHandler.js') }}"></script>
@endsection
