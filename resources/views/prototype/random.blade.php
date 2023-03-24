@extends('layouts.app')

@section('title',  config('app.name').' - Home')

@section('content')
<style>
    .tag-groups {
        border-radius: 4px;
        padding: 2px;
        display: flex;
        flex-wrap: wrap;
        /* border: 1px solid rgb(60, 108, 136); */
    }

    .tag-input, .tag-groups {
        background-color: white;
    }


    .tag-input {
        padding: 4px;
        color: black;
        border: none;
        outline: none;
        flex-grow: 1;
        line-height: normal;
        margin: 4px;
    }

    .tag-group {
        /* bacskground-color: rgb(97, 132, 153); */
        background-color: rgb(26, 93, 133);
        margin: 2px;
        border-radius: 4px;
        display: flex;
    }

    .tag-description {
        padding: 4px 0 4px 4px;
        display: inline-block;
        font-size: 0.9em;
        line-height: normal;
    }

    .tag-value {
        display: none;
    }

    .tag-delete {
        display: inline-block;
        padding: 4px;
        line-height: 0;
        margin: auto 0;
        cursor: pointer;
        font-size: 0.8em;
    }

    .t-flex {
        display: flex;
        align-items: center;
    }

    .t-flex .t-seperator {
        display: block;
        flex: 1 1 0px;
        max-width: 100%;
        height: 0;
        max-height: 0;
        border: solid;
        border-width: thin 0 0;
    }
</style>
 <div class="container standard medium mt-med">
     <form action="{{ route('test.tag') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <label class="label"> Gallery Tags </label>
        <div class="tag-groups mb-med">
            <input type="text" class="tag-input" placeholder="Something..." id="test-tag">
        </div>
        <button class="btn standard"> Submit </button>
    </form>
    {{-- <div class="carousel">
        <div class="inner-carousel">
            @for ($i = 0; $i < 10; $i++)
            <div class="carousel-item">

            </div>
            @endfor
        </div>
    </div> --}}
</div>
@endsection

@section('scripts')
{{-- <script src="{{ asset('js/lib/Carousel.js') }}"></script> --}}
@endsection
