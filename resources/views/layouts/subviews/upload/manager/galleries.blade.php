@foreach ($galleries as $gallery)
<div class="manager-items manager-items-wrapper p-sm">
    <div class="manager-items-thumbnail mr-sm">
        @if (isset($gallery->thumbnail))
        <img src="{{ asset('/assets/thumbnails/' . $gallery->dir_path . '/' . $gallery->thumbnail) }}" alt="thumbnail">
        @else
        <img src="{{ asset('/img/default/NotFound-720p.png') }}" alt="default-thumbnail">
        @endif
    </div>
    <div class="manager-items-detail">
        <div class="manager-items-infos p-sm">
            <div class="manager-items-info bold">Uploader: <span class="pill m-xsm">{{$gallery->user->name}}<span style="color: red; font-size: large;">#</span>{{$gallery->user->id}}</span></div>
            <div class="manager-items-info bold">Title: <span class="pill m-xsm">{{$gallery->title}}</span></div>
            <div class="manager-items-info bold">Original title: <span class="pill m-xsm">{{$gallery->title_original}}</span></div>
            <div class="manager-items-info bold">
                Tags:
                @for ($i = 0; $i < 40; $i++)
                <span class="pill mt-xsm mb-xsm ml-xxsm mr-xxsm"> Hello1 </span>
                @endfor
            </div>
            <div class="manager-items-info bold">Date added: <span class="pill m-xsm">{{$gallery->created_at}}</span></div>
            <div class="manager-items-info bold">Date updated: <span class="pill m-xsm">{{$gallery->updated_at}}</span></div>
        </div>
        <div class="manager-items-options p-sm">
            <a class=" manager-items-option option-delete mr-sm  p-sm">
                <i class="fas fa-trash"></i>
            </a>
            <a class="manager-items-option option-edit mr-sm p-sm">
                <i class="fas fa-edit"></i>
            </a>
            <a class="manager-items-option option-download mr-sm p-sm">
                <i class="fas fa-file-download"></i>
            </a>
        </div>
    </div>
</div>
@endforeach
