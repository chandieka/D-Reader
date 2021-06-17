<div class="header">
    <img src="{{ asset('Logo.png') }}" alt="Logo" class="logo-size-2">
    <div class="header-quote">
        {{-- Random Quotes about random things --}}
        @if (Route::is('login'))
        <p> Welcome back King!!</p>
        @elseif (Route::is('register'))
        <p> join the Mustache Gang!!</p>
        @endif
    </div>
    <ul class="auth-errors">
        @foreach ($errors->all() as $error)
        <li class="error">{{ $error }}</li>
        @endforeach
    </ul>
</div>

