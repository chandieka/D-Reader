@extends('layouts.app')

@section('title', 'Archive #' . $archive->id . ' Edit')

@section('content')
<div class="container center mt-sm">
    <h1 class="container-title p-sm pl-med pr-med">
        Edit Archive - #{{ $archive->id }}
    </h1>
</div>
<div class="container standard medium mt-med mb-med p-med">
    @csrf
    @method("PUT")
    <form action="{{ route('archives.edit') }}" method="POST" >
    </form>
</div>
@endsection
