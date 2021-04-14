<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    {{-- Icon Styles --}}
    <link href="{{ asset('css/fontawesome/css/all.css') }}" rel="stylesheet">
    <title>Test Page</title>
    <link rel="stylesheet" href="{{ asset('css/main.css') }}">
</head>
{{-- <style>
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

</style> --}}
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
            <div class="collapse" id="dropDown">
                <ul class="menu left">
                    <li class="nav-items"><a href="/">Tags</a></li>
                    <li class="nav-items"><a href="/">Genres</a></li>
                    <li class="nav-items"><a href="/">Artists</a></li>
                    <li class="nav-items"><a href="{{ route('help') }}">Help</a></li>
                </ul>
                <ul class="menu right">
                    <li class="nav-items"><a href="/">Login</a></li>
                    <li class="nav-items"><a href="/">Register</a></li>
                </ul>
            </div>
        </div>
        <script>
            function showMenu() {
                let dropElement = document.getElementById('dropDown');
                if (dropElement.className == 'collapse') {
                    dropElement.className += ' open';
                }
                else{
                    dropElement.className = 'collapse';
                }
            }
        </script>
    </div>
    <style>
        .format-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr
        }

        .format-grid-item {
            padding: 8px;
        }

        .btn-extend {
            width: 100%;
        }

        @media only screen and (max-width: 600px) {
            .format-grid {
                grid-template-columns: 1fr 1fr
            }
        }

        @media only screen and (min-width: 600px) and (max-width: 768px) {
            .format-grid {
                grid-template-columns: 1fr 1fr 1fr
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .format-grid {
                grid-template-columns: 1fr 1fr 1fr 1fr
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1200px) {
            .format-grid {
                grid-template-columns: 1fr 1fr 1fr 1fr
            }
        }

        @media only screen and (min-width: 1200px) {
            .format-grid {
                grid-template-columns: 1fr 1fr 1fr 1fr 1fr
            }
        }
    </style>
    <div class="wrapper">
        <div class="content-format">
            <div class="format-grid">
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
                <div class="format-grid-item">
                    <button class="btn btn-red btn-extend"> Test </button>
                </div>
            </div>
        </div>
    </div>
    <style>
        .card-collections {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr 1fr 1fr;
        }

        .card {
            width: 250px;
            height: 425px;
            background-color: rgb(154, 198, 197);
            margin: auto;
            margin-bottom: 16px;
            padding: 10px;
            border-radius: 10px;
        }

        @media only screen and (max-width: 600px) {
            .card-collections {
                grid-template-columns: 1fr;
            }
        }

        @media only screen and (min-width: 600px) and (max-width: 768px) {
            .card-collections {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media only screen and (min-width: 768px) and (max-width: 992px) {
            .card-collections {
                grid-template-columns: 1fr 1fr;
            }
        }

        @media only screen and (min-width: 992px) and (max-width: 1200px) {
            .card-collections {
                grid-template-columns: 1fr 1fr 1fr;
            }
        }

        @media only screen and (min-width: 1200px) and (max-width: 1600px){
            .card-collections {
                grid-template-columns: 1fr 1fr 1fr;
            }
        }

        @media only screen and (min-width: 1600px) and (max-width: 1800px){
            .card-collections {
                grid-template-columns: 1fr 1fr 1fr 1fr;
            }
        }

    </style>
    <div class="content">
        <div class="card-collections">
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
            <div class="card">
                <div class="card-thumb"></div>
                <div class="card-info">
                    <p class="card-info-title"></p>
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .center {
        text-align: center;
    }

    .pagination {
        display: inline-block;
        margin-bottom: 16px;
    }

    .pagination-items {
        text-decoration: none;
        display: inline-block;
        font-size: larger;
        padding: 8px 16px;
        float: left;
        margin-right: 4px;
        border-radius: 16px;
    }

    .pagination-items:hover {
        background-color: rgba(91, 42, 134, .5);
    }

    .pagination-active {
        background-color: rgba(91, 42, 134, 1);
    }
</style>
<div class="center">
    <div class="pagination">
        <a href="/" class="pagination-items">
            <i class="fa fa-chevron-left"></i>
            <i class="fa fa-chevron-left"></i>
        </a>
        <a href="/" class="pagination-items">
            <i class="fa fa-chevron-left"></i>
        </a>
        {{-- TODO: Pagination Logic --}}
        <a href="/" class="pagination-items pagination-active">1</a>
        <a href="/" class="pagination-items">2</a>
        <a href="/" class="pagination-items">3</a>
        <a href="/" class="pagination-items">4</a>
        <a href="/" class="pagination-items">5</a>
        <a href="/" class="pagination-items">6</a>
        <a href="/" class="pagination-items">7</a>
        {{-- TODO: Pagination Logic --}}
        <a href="/" class="pagination-items">...</a>
        <a href="/" class="pagination-items">
            <i class="fa fa-chevron-right"></i>
        </a>
        <a href="/" class="pagination-items">
            <i class="fa fa-chevron-right"></i>
            <i class="fa fa-chevron-right"></i>
        </a>
    </div>
</div>
<div class="content center">
    <h1>Hello World</h1>
    <form action="/">
        <input type="file">
    </form>
</div>
<div class="footer-nav">

</div>
</body>
</html>
