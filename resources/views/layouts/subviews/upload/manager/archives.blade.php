@foreach ($archives as $archive)
<div class="manager-items">
    <div class="manager-items-infos p-sm">
        <div class="manager-items-info bold mb-sm">Uploader: <span class="pill">{{$archive->user->name}}<span style="color: red; font-size: large;">#</span>{{$archive->user->id}}</span></div>
        <div class="manager-items-info bold mb-sm">Filename: <span class="pill">{{$archive->filename}}</span></div>
        <div class="manager-items-info bold mb-sm">Original Filename: <span class="pill">{{$archive->original_filename}}</span></div>
        <div class="manager-items-info bold mb-sm">
            Process into Gallery:
            <a href="{{ $archive->isProcess ? route('galleries.show', $archive->gallery->id) : 'no'  }}" class="pill">
                {{ $archive->isProcess ? 'yes' : 'no' }}
            </a>
        </div>
        <div class="manager-items-info bold mb-sm">Mime Type: <span class="pill">{{$archive->mime_type}}</span></div>
        <div class="manager-items-info bold mb-sm">Archive Type: <span class="pill">{{$archive->archive_type}}</span></div>
        <div class="manager-items-info bold mb-sm">File Size: <span class="pill">{{$archive->size}}</span></div>
        <div class="manager-items-info bold mb-sm">Date added: <span class="pill">{{$archive->created_at}}</span></div>
        <div class="manager-items-info bold mb-sm">Date updated: <span class="pill">{{$archive->updated_at}}</span></div>

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
@endforeach

