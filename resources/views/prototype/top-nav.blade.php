<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Icon Styles --}}
    <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">
    <title>Test Page</title>
</head>
<style>
    * {
        margin: 0;
        padding: 0;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        box-sizing: border-box;
        color: white;
        text-decoration: none;
    }
    
    body {
        background-color: rgba(119, 133, 172,1);
        display:grid;
        grid-template-rows: auto 1fr auto;
        min-height:100vh;
    }
    
    .logo {
        display: block;
        margin-right: 20px;
        margin-left: 20px;
        width: 50px;
    }
    
    .nav-container {
        width: 100%;
        background-color: rgba(54, 5, 104,1);
    }
    
    .nav-grid {
        display: grid;
        grid-template-columns: 0.5fr 1fr;
    }
    
    .nav-search {
        padding: 14px;
        border: none;
        outline: none;
        border-radius: 14px 0 0 14px;
        width: 100%;
        color: black;
    }
    
    .active {
        background-color: red;
    }
    
    .nav-items{
        padding: 16px;
        display: inline-block;
        list-style: none;
        text-decoration: none;
    }
    
    .nav-items:hover{
        background: rgb(91, 42, 134);
        transition: 0.2s
    }
    
    .nav-group {
        display: flex;
        flex-direction: row;
        align-items: center;
        width: 100%;
    }
    
    .nav-form-group{
        display: flex;
        flex-direction: row;
        width: 100%;
        margin-right: 16px; 
    }
    
    button.nav-btn {
        padding-left: 13px;
        padding-right: 13px;
        border-radius: 0 16px 16px 0
    }
    
    .btn {
        padding: 9px;
        border: none;
        outline: none;
    }
    
    .dropbtn {
        display: none;
        margin: 5px;
        border-radius: 8px;
    }
    
    .btn-red {
        background: red;
        color: white;
    }
    
    .btn-red:hover {
        background-color: rgba(255, 0, 0, 0.5);
    }
    
    .menu {
        display: inline-block;
    }
    
    .right {
        float: right;
    }
    
    .left {
        float: left;
    }
    
    
    
    @media only screen and (max-width: 992px) {
        .logo {
            margin-right: 10px;
            margin-left: 10px;
        }
        
        .nav-grid {
            grid-template-columns: auto;
        }
        
        .nav-container .menu, .nav-items, .dropbtn, .nav-items {
            display: block;
        }
        
        .nav-container {
            grid-template-columns: auto;
        }
        
        .right, .left {
            float: none;
        }
        
        .nav-items{
            text-align: center;
        }
        
        .hidden {
            display: none;
        }
        
        .nav-form-group {
            margin-right: 0; 
        }
    }
    
</style>
<body>
    <div class="nav-container" role="navigation">
        <div class="nav-grid">
            <div class="nav-group">
                <a href="/">
                    <img src="{{ asset('Logo.png') }}" alt="App logo" class="logo">
                </a>
                <form action="{{ route('search') }}" method="get" class="nav-form-group">
                    <input type="text" name="Query" class="nav-search" placeholder="Search..." required class="nav-form-inputs">
                    <button type="submit" class="btn btn-red nav-btn">
                        <i class="fas fa-search fa-lg"></i>
                    </button>
                </form>
                <button onclick="showMenu();" class="dropbtn btn-red btn">
                    <i class="fas fa-bars fa-2x"></i>
                </button>
            </div>
            <div id="dropDown">
                <ul class="menu left">
                    <li class="nav-items"><a href="/">Tags</a></li>
                    <li class="nav-items"><a href="/">Genres</a></li>
                    <li class="nav-items"><a href="/">Artists</a></li>
                    <li class="nav-items"><a href="{{ route('help') }}">Help</a></li>
                </ul>
                <ul class="menu right">
                    @auth
                    {{-- TODO: Replace My Account to a profile pic --}}
                    <li class="nav-items"><a href="/">My Account</a></li>
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
        <script>
            function showMenu() {
                let dropElement = document.getElementById('dropDown');
                if (dropElement.className == 'hidden') {
                    dropElement.className = '';
                }
                else{
                    dropElement.className += 'hidden';
                }
            }
        </script>
    </div>
</body>
</html>
