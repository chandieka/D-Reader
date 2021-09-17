@extends('layouts.app')

@section('title',  config('app.name').' - Home')

@section('content')
<div class="content">
    <form action="/test" enctype="multipart/form-data" class="form-group" method="POST">
        @csrf
        <input type="file" name="file" id="file" class="form-items">
        <input type="submit" class="btn">
    </form>
    <input type="button" name="test" id="test" class="btn" value="Click me">
    <script>
        window.addEventListener('load', (e) => {
            console.log(document.querySelector('#file'));
        })
    </script>
    <div class="box-collection">
        <div class="box"><div class="black">Hello worldHello worldHello worldHello worldHello worldHello worldHello world Hello worldHello worldHello worldHello worldHello worldHello worldHello worlds</div></div>
        <div class="box"><div class="black">Hello world</div></div>
        <div class="box"><div class="black">Hello world</div></div>
        <div class="box"><div class="black">Hello world</div></div>
        <div class="box"><div class="black">Hello world</div></div>
        <div class="box"><div class="black">Hello world</div></div>
        <div class="box"><div class="black">Hello world</div></div>
        <div class="box"><div class="black">Hello world</div></div>
        <div class="box"><div class="black">Hello world</div></div>
    </div>
    <style>
        .box-collection {
            display: grid;
            grid-template-columns: repeat(6, 1fr)
        }

        .box {
            padding: 8px;
            margin-bottom: 16px;
            background-color: orange
        }

        .black {
            background-color: black;
        }
    </style>
</div>
@endsection
