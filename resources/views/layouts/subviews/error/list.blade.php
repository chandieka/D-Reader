@isset($errors)
<ul class="error-list">
    @foreach ($errors->all() as $error)
    <li class="error">
        <span class="error-message">
            {{ $error }}
        </span>
        <span class="error-close"><i class="fas fa-times"></i></span>
    </li>
    @endforeach
</ul>
@endisset
