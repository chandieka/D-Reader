@extends('layouts.app')

@section('title', 'Add new Archive')

@section('content')
<div class="container center mt-sm">
    <h1 class="container-title shadow p-sm pl-med pr-med">
        Add New Archive
    </h1>
</div>
<div class="container standard medium shadow mt-med mb-med p-big">
    <form action="{{ route('archives.stores') }}" method="POST" enctype="multipart/form-data"  id="form-upload">
        @csrf
        <div class="options">
            <div class="option left ml-med">
                <label class="label v-center mr-sm bold" for="process">
                    Process to gallery:
                </label>
                <label class="switch">
                    <input type="checkbox" name="process" id="process" checked>
                    <span class="slider round"></span>
                </label>
            </div>
            <div class="option right">
                <button class="form-file-add btn btn-red pt-sm pb-sm mr-med ml-sm">
                    <i class="fas fa-plus"></i>
                </button>
            </div>
        </div>
        <div class="form-group">
            <div class="font-sm pill bold">Total files: <span id="total-files">0</span></div>
            <div class="font-sm pill bold">Total filesize: <span id="total-filesize">0</span></div>
        </div>
        <div class="form-group">
            <input type="file" name="files[]" class="archive-files" multiple hidden>
            <div class="form-files">
                <div class="form-file-collection m-med">
                    @for ($i = 0; $i < 0; $i++)
                    <div class="form-file-item center mr-sm ml-sm" data-file-id="1">
                        <div class="form-file-item-icon">
                            <i class="fas fa-file fa-6x"></i>
                        </div>
                        <div class="font-sm mb-sm bold">
                            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                        </div>
                        <div class="p-sm form-file-item-info">
                            <span>
                                <span class="font-sm bold">Filesize: </span><span class="font-sm">100 GB</span>
                            </span>
                            <span>
                                <span class="font-sm bold">Type: </span><span class="font-sm">RAR</span>
                            </span>
                        </div>
                        <button class="form-file-item-remove">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                    @endfor
                </div>
                <div class="form-file-button">
                    <i class="fas fa-upload fa-3x"></i>
                </div>
            </div>
        </div>
        <input type="submit" value="Upload" class="btn btn-wide standard" id="btn-upload">
    </form>
</div>
@endsection

@section('scripts')
<script src="{{ asset('js/upload/eventHandler.js') }}" type="module"></script>
@endsection
