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
