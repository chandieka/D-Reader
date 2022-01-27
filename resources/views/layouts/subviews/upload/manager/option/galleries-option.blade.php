<div class="options">
    <span class="option ml-med bold">Filter: </span>
    <form action="" method="GET" class="form-search option left ml-med">
        <div class="form-search-text">
            <input type="text" name="filter" placeholder="Search..." id="filter-search" value="{{ old('filter') }}">
            <span class="delete font-large" onclick="reset('#filter-search')">
                x
            </span>
        </div>
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
