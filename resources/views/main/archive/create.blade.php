@extends('layouts.app')

@section('title', 'Create new Archive')

@section('content')
<div class="container center mt-sm">
    <h1 class="container-title p-sm pl-med pr-med">
        Create New Archive
    </h1>
</div>
<div class="container standard medium mt-med mb-med p-big">
    <form action="{{ route('archives.stores') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {{-- <div class="form-group">
            <label for="form-file" class="label bold font-med">Upload Archives</label>
            <p class="title fade mb-med font-sm">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio odio dicta consectetur, dolorum voluptate dignissimos recusandae
                voluptas id aliquid rerum consequuntur placeat libero ratione architecto perspiciatis quidem commodi nostrum? Quibusdam.
            </p>
            <div class="form-files">
                <label for="form-file" class="form-file p-sm mr-sm mb-sm">Example</label>
                <label for="form-file" class="form-file p-sm mr-sm mb-sm">Example</label>
                <button class="form-file-button font-big mr-sm">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div> --}}
        <div class="form-group">
            <label for="files" class="label bold">Upload Archives</label>
            <p class="title fade mb-med font-sm">
                Lorem ipsum dolor sit amet consectetur, adipisicing elit. Distinctio odio dicta consectetur, dolorum voluptate dignissimos recusandae
                voluptas id aliquid rerum consequuntur placeat libero ratione architecto perspiciatis quidem commodi nostrum? Quibusdam.
            </p>
            <div class="form-control">
                <input type="file" name="files[]" id="files" multiple>
            </div>
        </div>
        <div class="form-group">
            <label class="switch">
                <input type="checkbox" name="process" id="process" checked>
                <span class="slider round"></span>
            </label>
            <label class="label v-center" for="process">
                Automatically Process
            </label>
        </div>
        <div class="form-group">
            <input type="submit" value="Upload Archives" class="btn standard">
        </div>
    </form>
</div>
@endsection

@section('scripts')
<script type="module" src="{{ asset('js/archive/upload/eventHandler.js') }}"></script>
@endsection
