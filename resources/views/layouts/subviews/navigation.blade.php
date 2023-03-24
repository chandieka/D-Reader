<nav class="nav-container" role="navigation">
    <div class="nav-grid">
        <div class="nav-group row">
            <a href="{{ route('home') }}">
                <img src="{{ asset('Logo.png') }}" alt="App logo" class="logo">
            </a>
            <form action="{{ route('search.index') }}" method="get" class="nav-form-group">
                <div class="nav-search">
                    <input type="text" name="query" class="nav-search" placeholder="Search..." id="filter-search" value="{{ old('query') }}">
                    <div class="delete mr-sm" onclick="reset('#filter-search')">
                        <i class="fas fa-times"></i>
                    </div>
                </div>
                <button type="submit" class="btn btn-red nav-btn">
                    <i class="fas fa-search fa-lg"></i>
                </button>
            </form>
            <button id="nav-dropdown-btn" class="nav-dropbtn">
                <i class="fas fa-bars fa-2x"></i>
            </button>
        </div>
        <div class="nav-group collapse center" id="nav-dropDown">
            <ul class="menu left">
                <li class="nav-item"><a href="/">Tags</a></li>
                <li class="nav-item"><a href="/">Genres</a></li>
                <li class="nav-item"><a href="/">Artists</a></li>
                <li class="nav-item"><a href="/">Circles</a></li>
                <li class="nav-item"><a href="{{ route('help') }}">Help</a></li>
            </ul>
             @auth
            <ul class="menu">
                <li class="shortcuts m-sm">
                    <a href="{{ route('galleries.create') }}" class="icon default">
                        <i class="fas fa-upload"></i>
                    </a>
                    <a href="{{ route('users.favorite', Auth::user()) }}" class="icon default ml-sm">
                        <i class="fas fa-heart"></i>
                    </a>
                </li>
            </ul>
            @endauth
            <ul class="menu">
                @auth
                <li class="acc-dropdown">
                    <div class="acc-dropbtn point">
                        <img src="{{ asset('Logo.png') }}" alt="" class="nav-profile-thumb mr-med">
                        <span class="inline-block mr-med">{{ Auth::user()->name }}</span>
                        <i class="fas fa-caret-down fa-lg mr-med"></i>
                    </div>
                    <ul class="acc-dropdown-content">
                        <li class="nav-item">
                            <a href="{{ route('users.show', Auth::user()->id) }}" class="dropitem">
                                <span style="display:inline-block;width:60px;">Profile</span>
                                <i class="fas fa-user fa-lg ml-sm"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('users.favorite', Auth::user()->id) }}" class="dropitem">
                                <span style="display:inline-block;width:60px;">Favorites</span>
                                <i class="fas fa-heart fa-lg ml-sm"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('uploads.index') }}" class="dropitem">
                                <span style="display:inline-block;width:60px;">Uploads</span>
                                <i class="fas fa-upload fa-lg ml-sm"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/" class="dropitem">
                                <span style="display:inline-block;width:60px;">Settings</span>
                                <i class="fas fa-cog fa-lg ml-sm"></i>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form action="{{ route('logout') }}" method="POST" id="form-logout">
                                @csrf
                                <a onclick="document.getElementById('form-logout').submit()" class="dropitem">
                                    <span style="display:inline-block;width:60px;">Logout</span>
                                    <i class="fas fa-sign-out-alt fa-lg ml-sm"></i>
                                </a>
                            </form>
                        </li>
                    </ul>
                </li>
                @endauth
                @guest
                <li class="nav-item info"><a href="{{ route('login') }}">Login</a></li>
                <li class="nav-item info"><a href="{{ route('register') }}">Register</a></li>
                @endguest
            </ul>
        </div>
    </div>
</nav>
