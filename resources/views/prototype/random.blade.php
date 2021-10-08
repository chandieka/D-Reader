@extends('layouts.app')

@section('title',  config('app.name').' - Home')

@section('content')
<style>
.t-nav {
    display: grid;
    grid-template-rows: repeat(auto, 5);
    text-align: center;
    background-color: white;
    max-height: 0;
    overflow: hidden;
    transition: 0.5s
}
.t-nav a.t-nav-item {
    display: block;
    background-color: red;
    border-radius: 4px;
}
</style>
<div class="content mt-med">
    <div class="t-nav">
        <a href="" class="t-nav-item p-sm m-sm">1</a>
        <a href="" class="t-nav-item p-sm m-sm">2</a>
        <a href="" class="t-nav-item p-sm m-sm">3</a>
        <a href="" class="t-nav-item p-sm m-sm">4</a>
        <a href="" class="t-nav-item p-sm m-sm">5</a>
    </div>
    <p id="test-e">
        Lorem ipsum, dolor sit amet consectetur adipisicing elit.
        Autem in ut, possimus perferendis voluptatum accusamus optio a repellat eaque
        inventore eum at cumque porro saepe ipsum numquam doloribus et eligendi?
    </p>
</div>
<script>
    window.addEventListener('load', (e) => {
        // console.log('test');
        let element = document.querySelector('#test-e');
        element.addEventListener('click', (j) => {
            document.querySelector('.t-nav').style
        })
    });
</script>
@endsection
