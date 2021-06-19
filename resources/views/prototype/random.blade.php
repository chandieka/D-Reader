@extends('layouts.app')

@section('title',  config('app.name').' - Home')

@section('content')
<div class="content">
    <button class="btn" id="testButton" style="display: block; width: 100%;"> Press me!</button>
    <span class="icon" id="textOutput" style="display: block; width: 100%; text-align: center;""> Is it wednesday my dude? </span>
    <div>
        <img src="" alt=""  id="imageOutput" style="width: 50%; margin: 0 auto;">
    </div>
</div>
<script>
    var secure_token = '{{ csrf_token() }}'; // A must token in every POST request
    var textOutput = document.querySelector('#testButton');
    var imgOutput = document.querySelector('#imageOutput');
    var imgURL = [
        '{{ asset('img/default/NotFound-720p.png') }}',
        '{{ asset('img/default/NotFound-720p-2.png') }}',
        '{{ asset('img/default/NotFound-720p-3.png') }}',
    ]
    let imgIndex = 0;
    let image1 = new Image();
    image1.src = imgURL[0];
    let image2 = new Image();
    image2.src = imgURL[1];
    let image3 = new Image();
    image3.src = imgURL[2];
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
        // console.log(textOutput.offsetWidth);
        // console.log(textOutput.offsetWidth / 2);

        // e = Mouse click event.
        var rect = e.target.getBoundingClientRect();
        var x = e.clientX - rect.left; //x position within the element.
        var y = e.clientY - rect.top;  //y position within the element.
        // console.log("Left? : " + x + " ; Top? : " + y + ".")
        if (x > textOutput.offsetWidth / 2 ){
            if (imgIndex + 1 < imgURL.length){
                imgIndex += 1;
                imgOutput.src = imgURL[imgIndex];
                console.log(imgIndex)
            }
        }
        else {
            if (imgIndex - 1 >= 0){
                imgIndex -= 1;
                imgOutput.src = imgURL[imgIndex];
                console.log(imgIndex)
            }
        }
    });
</script>
@endsection
