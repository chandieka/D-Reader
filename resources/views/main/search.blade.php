@extends('layouts.app')

@section('title', "Search: $query")

@section('content')
<div class="container center mt-sm mb-sm">
    <div class="container-title">
        <h1 class="inline-block p-sm pl-med r-font-big">
            Search:
            <span style="color: rgb(204, 51, 51)">
                {{ \App\Customs\Utils::stringShortener($query, 100) }}
            </span>
        </h1>
        <h1 class="details inline-block p-sm pr-med pl-med r-font-big">
            {{ $galleries->count() }}
        </h1>
    </div>
</div>
@include('layouts.subviews.pagination')
@include('layouts.subviews.dashboard')
@include('layouts.subviews.pagination')
@endsection
