<table class="table">
    <thead>
        <tr>
            <th></th>
            <th class="bold">ID</th>
            <th class="bold">Filename</th>
            <th class="bold">Original Filename</th>
            <th class="bold">Child Gallery</th>
            <th class="bold">Date added</th>
            <th class="bold">Date updated</th>
            <th class="bold">Action</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($archives as $archive)
        <tr>
            <td>
                <label class="checkbox">
                    <input type="checkbox" name="checkbox[]">
                    <span class="checkmark"></span>
                </label>
            </td>
            <td>
                {{ $archive->id }}
            </td>
            <td>{{$archive->filename}}</td>
            <td>{{App\Customs\Utils::stringShortener($archive->original_filename, 40)}}</td>
            <td>
                @if ($archive->isProcess)
                <a href="{{ route('galleries.show', $archive->gallery->id) }}">
                    <span style="color: red; font-size: large;">#</span>{{ $archive->gallery->id }}
                </a>
                @endif
            </td>
            <td>{{$archive->created_at->format('d-m-Y')}}</td>
            <td>{{$archive->updated_at->format('d-m-Y')}}</td>
            <td>
                <form action="{{ route('archives.delete', $archive->id) }}" method="POST" class="icon-form form-delete">
                    @csrf
                    @method('DELETE')
                    <button class="form-delete-button icon icon-sm danger mr-med">
                        <i class="fas fa-trash"></i>
                    </button>
                </form>
                <a href="{{ route('archives.edit', $archive->id) }}" class="icon icon-sm default mr-med">
                    <i class="fas fa-edit"></i>
                </a>
                <a href="{{ route('archives.download', $archive->id) }}" class="icon icon-sm default mr-med">
                    <i class="fas fa-file-download"></i>
                </a>
                @if ($archive->isProcess)
                <a class="icon icon-sm default mr-med disabled">
                    <i class="fas fa-arrow-right"></i>
                </a>
                @else
                <a href="{{ route('archives.process', $archive->id) }}" class="icon icon-sm default mr-med">
                    <i class="fas fa-arrow-right"></i>
                </a>
                @endif
            </td>
        </tr>
        @endforeach
    </tbody>
</table>
