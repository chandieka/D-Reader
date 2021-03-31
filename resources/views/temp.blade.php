<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>D-Reader</title>
    <!-- Main Styling -->
    <link rel="stylesheet" href="{{ asset('/css/main.css') }}">
    <!-- Icon -->
    <link rel="stylesheet" href="{{asset('/css/fontawesome/css/all.css')}}">
</head>
<body>
    <nav class="nav-container">
        <a href="/">
            <img src="/assets/img/Logo.png" alt="App logo" class="logo">
        </a>
        <form action="/" method="get" class="nav-form">
            <input type="text" name="Query" class="nav-search">
            <button type="submit" class="btn btn-nav">
                <i class="fas fa-search"></i>
            </button>
        </form>
        <ul class="nav-extra nav-list">
            <li class="list-items">
                <a href="/">Tags</a>
            </li>
            <li class="list-items">
                <a href="/">Genres</a>
            </li>
            <li class="list-items">
                <a href="/">Artist</a>
            </li>
        </ul>
        <ul class="nav-account nav-list">
            <li class="list-items">
                <a href="/">Login</a>
            </li>
            <li class="list-items">
                <a href="/">Register</a>
            </li>
        </ul>
    </nav>
    <div class="message">
        <!-- Auto Insert -->
    </div>
    <div class="type-nav">
        <!-- Article Types e.g Doujins, Manga, CG-Artist and etc -->
    </div>
    <div class="content">
        <!-- TOP KEK CONTENT SOON TM -->
    </div>
    <footer class="footer-nav">
        <p>&copy 2021-2069 D-Reader.com</p>
    </footer>
</body>

</html>
