{{-- TODO: Responsive Styling --}}
<a href="/">
    <img src="{{ asset('Logo.png') }}" alt="App logo" class="logo-size-1">
</a>
<form action="{{ route('search') }}" method="get" class="nav-form">
    <input type="text" name="Query" class="nav-search" placeholder="Search..." required>
    <button type="submit" class="btn btn-nav">
        <i class="fas fa-search"></i>
    </button>
</form>
{{-- TODO: change to drop down in Medium width and below  --}}
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
        <a href="{{ route('help') }}">Help</a>
    </li>
</ul>
{{-- TODO: change to drop down in certain med-small to small width  below--}}
<ul class="nav-account nav-list">
    @auth
        {{-- TODO: Favorites, Account profile pic and etc --}}
        <li class="list-items">
            {{-- TODO: Replace this to a profile pic --}}
            <a href="/">My Account</a>
        </li>
        <li class="list-items">
            <form action="{{ route('logout') }}" method="POST" id="form-logout">
                @csrf
                <a onclick="document.getElementById('form-logout').submit()">Logout</a>
            </form>
        </li>
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
