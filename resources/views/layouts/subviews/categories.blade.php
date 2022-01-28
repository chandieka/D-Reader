<div class="content-format">
    <!-- Article Types e.g Doujins, Manga, CG-Artist and etc -->
    <div class="format-grid">
        {{-- will be added through blade loop --}}
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
    <form action="{{ route('search') }}" method="get" class="format-form" id="form-categories">
        <div class="format-form-items format-form-extend">
            <input type="text" name="Query" class="format-form-search" placeholder="Search..." required>
        </div>
        <div class="format-form-items" id="search-filter">
            <button type="submit" class="btn btn-red btn-extend">
                Apply Filter
                <i class="fas fa-search fa-lg"></i>
            </button>
        </div>
        <div class="format-form-items" id="clear-filter">
            <button class="btn btn-extend">
                Clear Filter
                <i class="fas fa-trash-alt fa-lg"></i>
            </button>
        </div>
    </form>
</div>



