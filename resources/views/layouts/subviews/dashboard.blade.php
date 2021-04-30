<div class="content">
    <div class="gall-opt">
        <div class="opt-sort">
            {{-- Sort --}}
        </div>
        <div class="opt-limit">
            {{-- display limit (e.g 50 per page or 100 per page) --}}
            <button class="btn">25</button>
            <button class="btn">50</button>
            <button class="btn">100</button>
        </div>
        <div class="opt-mode">
            {{-- Display mode --}}
        </div>
    </div>
    <div class="card-collections">
        @for ($i = 0; $i < 50; $i++)
             <div class="card">
                <div class="card-thumb">
                    <img src="{{ asset('img/na.png') }}" alt="Not Found">
                </div>
                <div class="card-info">
                    <p class="card-info-title">
                        Lorem ipsum dolor sit amet consectetur adipisicing elit.
                    </p>
                </div>
            </div>
        @endfor
    </div>
</div>
