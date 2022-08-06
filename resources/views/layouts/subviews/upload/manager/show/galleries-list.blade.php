<table class="table">
    <thead>
        <tr>
            <th></th>
            <th class="bold">Thumbnail</th>
            <th class="bold">Title</th>
            <th class="bold">Parent archive</th>
            <th class="bold">Date added</th>
            <th class="bold">Date updated</th>
            <th class="bold">Actions</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($galleries as $gallery)
        <tr>
            <td>
                <label class="checkbox">
                    <input type="checkbox" name="checkbox[]">
                    <span class="checkmark"></span>
                </label>
            </td>
            <td class="manager-items-thumbnail">
                @if (isset($gallery->thumbnail))
                <a href="{{ route('galleries.show', $gallery->id) }}">
                    <img src="{{ asset('/assets/thumbnails/' . $gallery->dir_path . '/' . $gallery->thumbnail) }}" alt="thumbnail">
                </a>
                @else
                <img src="{{ asset('/img/default/NotFound-720p.png') }}" alt="default-thumbnail">
                @endif
            </td>
            <td>{{App\Customs\Utils::stringShortener($gallery->title, 60)}}</td>
            <td>
                <a href="">
                    <span style="color: red; font-size: large;">#</span>{{ $gallery->archive->id }}
                </a>
            </td>
            <td>{{$gallery->created_at->format('d-m-Y')}}</td>
            <td>{{$gallery->updated_at->format('d-m-Y')}}</td>
            <td>
                <form action="{{ route('galleries.delete', $gallery->id) }}" method="POST" class="icon-form" id="form-delete">
                    @csrf
                    @method('DELETE')
                    <button class="form-delete-button icon icon-sm danger mr-med">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                @if ($gallery->isHidden)
                <a href="{{ route('galleries.change.status', [$gallery->id, 0]) }}" class="icon icon-sm default mr-med">
                    <i class="fas fa-eye-slash"></i>
                </a>
                @else
                <a href="{{ route('galleries.change.status', [$gallery->id, 1]) }}" class="icon icon-sm default mr-med">
                    <i class="fas fa-eye"></i>
                </a>
                @endif
                <a href="{{ route('galleries.edit', $gallery->id) }}" class="icon warning icon-sm default mr-med">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="{{ route('archives.download', $gallery->archive->id) }}" class="icon icon-sm default mr-med">
                    <i class="fas fa-file-download"></i>
                </a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

