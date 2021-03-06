<nav class="nav-container" role="navigation">
    <div class="nav-grid">
        <div class="nav-group">
            <a href="{{ route('home') }}">
                <img src="{{ asset('Logo.png') }}" alt="App logo" class="logo">
            </a>
            <form action="{{ route('search.index') }}" method="get" class="nav-form-group">
                <div class="nav-search">
                    <input type="text" name="query" class="nav-search" placeholder="Search..." id="filter-search" value="{{ old('query') }}">
                    <span class="delete font-large" onclick="reset('#filter-search')">
                        x
                    </span>
                </div>
                <button type="submit" class="btn btn-red nav-btn">
                    <i class="fas fa-search fa-lg"></i>
                </button>
            </form>
            <button id="nav-dropdown-btn" class="nav-dropbtn">
                <i class="fas fa-bars fa-2x"></i>
            </button>
        </div>
        <div class="collapse" id="nav-dropDown">
            <ul class="menu left">
                <li class="nav-items info"><a href="/">Tags</a></li>
                <li class="nav-items info"><a href="/">Genres</a></li>
                <li class="nav-items info"><a href="/">Artists</a></li>
                <li class="nav-items info"><a href="/">Groups</a></li>
                <li class="nav-items info"><a href="{{ route('help') }}">Help</a></li>
                {{-- <li class="nav-items info"><a href="{{ route('test.index') }}">Test Page</a></li> --}}
            </ul>
            <ul class="menu right">
                @auth
                {{-- TODO: Fixed responsive stylying for smaller devices --}}
                <li class="shortcuts">
                    <a href="{{ route('galleries.create') }}" class="shortcut"><i class="fas fa-upload"></i></a>
                </li>
                <li class="acc-dropdown">
                    <div class="nav-items info acc-dropbtn">
                        {{-- TODO: Add Profile pic --}}
                        <a>
                            <span>{{ Auth::user()->name }}</span>
                            <i class="fas fa-angle-down fa-lg"></i>
                        </a>
                    </div>
                    <ul class="acc-dropdown-content">
                        <li class="nav-items info"><a href="{{ route('users.show', Auth::user()->id) }}">My Profile</a></li>
                        <li class="nav-items info"><a href="/">My Favorites</a></li>
                        <li class="nav-items info"><a href="{{ route('uploads.index') }}">My Uploads</a></li>
                        <li class="nav-items info"><a href="/">Settings</a></li>
                        <li class="nav-items info">
                            <form action="{{ route('logout') }}" method="POST" id="form-logout">
                                @csrf
                                <a onclick="document.getElementById('form-logout').submit()">Logout</a>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
                @guest
                <li class="nav-items info"><a href="{{ route('login') }}">Login</a></li>
                <li class="nav-items info"><a href="{{ route('register') }}">Register</a></li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
