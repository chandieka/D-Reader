@extends('layouts.app')

@section('title',  config('app.name').' - Home')

@section('content')
<div class="content">
    <button class="btn" id="testButton" style="display: block; width: 100%;"> Press me!</button>
    <span class="icon" id="textOutput" style="display: block; width: 100%; text-align: center;""> Is it wednesday my dude? </span>
</div>
<script>
    var secure_token = '{{ csrf_token() }}'; // A must token in every POST request
    let textOutput = document.querySelector('#testButton');
    document.querySelector('#testButton').addEventListener("click" , (e) => {
        // let body = {
        //     _token: secure_token,
        //     user: 1,
        //     gallery: 1,
        // };
        // // console.log(JSON.stringify(body));
        // let response = await fetch("http://localhost:8000/test", {
        //     method: 'POST',
        //     headers: {
        //         'Content-Type': 'application/json'
        //     },
        //     body: JSON.stringify(body)
        // });
        // let json = await response.json();
        // console.log(json);
        console.log(textOutput.offsetWidth);
        console.log(e.clientX + " " + e.clientY);
    });
</script>
@endsection
