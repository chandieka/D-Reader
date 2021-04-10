<nav class="nav-container" role="navigation">
    <div class="nav-grid">
        <div class="nav-group">
            <a href="/">
                <img src="{{ asset('Logo.png') }}" alt="App logo" class="logo">
            </a>
            <form action="{{ route('search') }}" method="get" class="nav-form-group">
                <input type="text" name="Query" class="nav-search" placeholder="Search..." required>
                <button type="submit" class="btn btn-red nav-btn">
                    <i class="fas fa-search fa-lg"></i>
                </button>
            </form>
            <button onclick="showMenu();" class="dropbtn btn-red btn">
                <i class="fas fa-bars fa-2x"></i>
            </button>
        </div>
        <div class="collapse" id="dropDown">
            <ul class="menu left">
                <li class="nav-items"><a href="/">Tags</a></li>
                <li class="nav-items"><a href="/">Genres</a></li>
                <li class="nav-items"><a href="/">Artists</a></li>
                <li class="nav-items"><a href="/">Groups</a></li>
                <li class="nav-items"><a href="{{ route('help') }}">Help</a></li>
            </ul>
            <ul class="menu right">
                @auth
                {{-- TODO: Replace My Account to a profile pic --}}
                <li class="nav-items"><a href="{{ route('users.show', $user->id) }}">My Account</a></li>
                <li class="nav-items">
                    <form action="{{ route('logout') }}" method="POST" id="form-logout">
                        @csrf
                        <a onclick="document.getElementById('form-logout').submit()">Logout</a>
                    </form>
                </li>
                @endauth
                @guest
                <li class="nav-items"><a href="{{ route('login') }}">Login</a></li>
                <li class="nav-items"><a href="{{ route('register') }}">Register</a></li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
