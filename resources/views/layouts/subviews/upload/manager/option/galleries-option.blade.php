<div class="options">
    <span class="option ml-med bold">Filter: </span>
    <form action="" method="GET" class="form-search option left ml-med">
        <input type="text" name="filter" class="form-search-text" placeholder="Search..." value="{{ old('filter') }}">
        <button class="form-search-btn btn-red">
            <i class="fas fa-search fa-lg"></i>
        </button>
    </form>
    <div class="option right">
        <a href="{{ route('galleries.create') }}" class="btn btn-red pt-sm pb-sm mr-med ml-sm">
            <i class="fas fa-plus"></i>
        </a>
    </div>
</div>
