{{-- layout --}}
@extends('layouts-artist.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Courses')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('plugins/fileuploader/dist/font/font-fileuploader.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fileuploader/dist/jquery.fileuploader.min.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fileuploader/dist/font/font-fileuploader.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fileuploader/dist/jquery.fileuploader.min.css') }}">
@endsection

@section('content')
<div class="section">
    <div class="row">
        <div class="col s12">
            <div id="html-validations" class="card card-tabs">
                <div class="card-content">
                    <div class="card-title">
                        <div class="row">
                            <div class="col s12 m6 l10">
                                <h4 class="card-title">Add New</h4>
                            </div>
                            <div class="col s12 m6 l2">
                            </div>
                        </div>
                    </div>
                    <div id="html-view-validations">
                        <form class="formValidate0" id="formValidate0" method="POST"
                            action="{{ route('artist.course.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                @foreach ($langs as $key => $lang)
                                <div class="input-field col s12 m6 l6">
                                    <input type="text" name="title_{{ $lang['code'] }}" id="title_{{ $lang['code'] }}" value="{{ old('title_'.$lang['code']) }}"
                                        class="validate" required />
                                    <label for="title_{{ $lang['code'] }}">{{ __('admin-content.name') }} ({{
                                        $lang['name'] }})*</label>
                                </div>
                                @endforeach
                                @foreach ($langs as $key => $lang)
                                <div class="input-field col s12 m6 l6">
                                    <textarea name="description_{{$lang['code']}}" id="description_{{$lang['code']}}"
                                        class="materialize-textarea" required>{{ old('description_'.$lang['code']) }}</textarea>
                                    <label for="description_{{$lang['code']}}">{{ __('admin-content.description')}}
                                        ({{$lang['name']}})*</label>
                                </div>
                                @endforeach

                                <div class="input-field col s12 m6 l6">
                                    {!! Form::select('videoType', $videoTypes, old('videoType')) !!}
                                    <label>{{ __('Video type') }}</label>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    {!! Form::select('courseLevel', $courseLevels, old('courseLevel')) !!}
                                    <label>{{ __('Course level') }}</label>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <label for="promo_video">Promo video link</label>
                                    <input type="text" id="promo_video" class="validate" value="{{ old('promo_video') }}"
                                        name="promo_video">
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <label for="video">Video Link*</label>
                                    <input type="text" id="video" class="validate" value="{{ old('video') }}"
                                        name="video">
                                </div>
{{-- 
                                <div class="input-field col s12 m6 l6">
                                    <label for="price">Course price*</label>
                                    <input type="number" class="validate" value="{{ old('price') }}"
                                        name="price">
                                </div> --}}

                                <div class="input-field col s12 m6 l6">
                                    <label for="duration">Duration (min)*</label>
                                    <input type="number" class="validate" value="{{ old('duration') }}"
                                        name="duration">
                                </div>

                                {{-- <div class="col s12 m6 l6">
                                    <label for="">Start at*</label>
                                    <input type="datetime-local" name="start_at" class="validate"
                                        value="{{ old('start_at') }}" id="start_id">
                                </div>

                                <div class="col s12 m6 l6">
                                    <label for="expire_at">End at*</label>
                                    <input type="datetime-local" name="expire_at" class="validate"
                                        value="{{ old('expire_at') }}" id="expire_at">
                                </div> --}}

                                <div class="col s12">
                                    <label for="image">Single Image*</label>
                                    <div class="jFiler-input-dragDrop pos-relative">
                                        <div class="jFiler-input-inner">
                                            <div class="jFiler-input-icon">
                                                <i class="icon-jfi-cloud-up-o"></i>
                                            </div>
                                            <div class="filediv">
                                                <input type="file" name="image" class="file" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <label for="gallery">Gallery</label>
                                    <div class="jFiler-input-dragDrop pos-relative">
                                        <div class="jFiler-input-inner">
                                            <div class="jFiler-input-icon">
                                                <i class="icon-jfi-cloud-up-o"></i>
                                            </div>
                                            <div class="filediv">
                                                <input type="file" name="gallery[]" class="file" multiple="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="input-field col s12">
                                    <button class="btn cyan waves-effect waves-light right" type="submit"
                                        name="action">{{ __('admin-content.submit') }}
                                        <i class="material-icons right">send</i>
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

{{-- vendor script --}}
@section('vendor-script')
<script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
<script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
<script src="{{ asset('js/scripts/form-validation.js') }}"></script>
<script src="{{ asset('plugins/fileuploader/dist/jquery.fileuploader.min.js') }}"></script>
<script>
    $(document).ready(function () {
        $('input[name="image"]').fileuploader({
            limit: 1,
            maxSize: 15,
        });

        $('input[name="gallery[]"]').fileuploader({
            limit: 10,
            maxSize: 15,
            addMore: true,
        });
    });
</script>
@endsection
