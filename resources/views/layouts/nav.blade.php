{{-- TODO: Responsive Styling --}}
<a href="/">
    <img src="{{ asset('Logo.png') }}" alt="App logo" class="logo-size-1">
</a>
<form action="/" method="get" class="nav-form">
    <input type="text" name="Query" class="nav-search">
    <button type="submit" class="btn btn-nav">
        <i class="fas fa-search"></i>
    </button>
</form>
{{-- TODO: change to drop down in certain width --}}
<ul class="nav-extra nav-list">
    <li class="list-items">
        <a href="/">Tags</a>
    </li>
    <li class="list-items">
        <a href="/">Genres</a>
    </li>
    <li class="list-items">
        <a href="/">Artists</a>
    </li>
    <li class="list-items">
        <a href="/">Help</a>
    </li>
</ul>
{{-- TODO: change to drop down in certain width --}}
<ul class="nav-account nav-list">
    @auth
        {{-- TODO: Favorites, Account profile pic and etc --}}
    @endauth
    @guest
    <li class="list-items">
        <a href="{{route('login')}}">Login</a>
    </li>
    <li class="list-items">
        <a href="{{route('register')}}">Register</a>
    </li>
    @endguest
</ul>
