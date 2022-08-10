{{-- layout --}}
@extends('layouts.contentLayoutMaster')

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
                                <h4 class="card-title">Update</h4>
                            </div>
                            <div class="col s12 m6 l2">
                            </div>
                        </div>
                    </div>
                    <div id="html-view-validations">
                        <form class="formValidate0" method="POST" action="{{ route('admin.course.update', $course->id) }}"
                            enctype="multipart/form-data">
                            {{-- {{ dd($course) }} --}}
                            @csrf
                            @method('PUT')
                            <div class="row">
                                @foreach ($langs as $key => $lang)
                                <div class="input-field col s12 m6 l6">
                                    <input type="text" name="title_{{ $lang['code'] }}" id="title_{{ $lang['code'] }}" value="{{ $course->title }}"
                                        class="validate" required />
                                    <label for="title_{{ $lang['code'] }}">{{ __('admin-content.name') }} ({{
                                        $lang['name'] }})*</label>
                                </div>
                                @endforeach
                                @foreach ($langs as $key => $lang)
                                <div class="input-field col s12 m6 l6">
                                    <textarea name="description_{{$lang['code']}}" id="description_{{$lang['code']}}"
                                        class="materialize-textarea" required>{{ $course->description }}</textarea>
                                    <label for="description_{{$lang['code']}}">{{ __('admin-content.description')}}
                                        ({{$lang['name']}})*</label>
                                </div>
                                @endforeach

                                <div class="input-field col s12 m6 l6">
                                    {!! Form::select('dance', $dances, $course->dance_id) !!}
                                    <label>{{ __('Dance') }}</label>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    {!! Form::select('artist', $artists, $course->artist_id) !!}
                                    <label>{{ __('Artist') }}</label>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    {!! Form::select('videoType', $videoTypes, $course->video_type) !!}
                                    <label>{{ __('Video type') }}</label>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    {!! Form::select('courseLevel', $courseLevels, $course->course_level) !!}
                                    <label>{{ __('Course level') }}</label>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <label for="promo_video">Promo video link</label>
                                    <input type="text" id="promo_video" class="validate" value="{{ $course->promo_video }}"
                                        name="promo_video">
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <label for="video">Video Link</label>
                                    <input type="text" id="video" class="validate" value="{{ $course->video }}"
                                        name="video">
                                </div>

                                {{-- <div class="input-field col s12 m6 l6">
                                    <label for="price">Course price *</label>
                                    <input type="number" class="validate" value="{{ $course->price }}"
                                        name="price">
                                </div> --}}

                                <div class="input-field col s12 m6 l6">
                                    <label for="duration">Duration (min) *</label>
                                    <input type="number" class="validate" id="duration" value="{{ $course->duration }}"
                                        name="duration">
                                </div>

                                <div class="input-field input-field col s12 ">
                                    <p>
                                        <label>Settings</label>
                                    </p>
                                    <p>
                                        <label>
                                        <input name="is_published" @if ($course->is_published)
                                            checked
                                        @endif type="checkbox">
                                        <span>Publish</span>
                                        </label>
                                    </p>
                                </div>

                                {{-- <div class="col s12 m6 l6">
                                    <label for="">Start at *</label>
                                    <input type="datetime-local" name="start_at" class="validate"
                                        value="{{ $course->start_at->format('Y-m-d\TH:i') }}" id="start_at">
                                </div>

                                <div class="col s12 m6 l6">
                                    <label for="expire_at">Expire at *</label>
                                    <input type="datetime-local" name="expire_at" class="validate"
                                        value="{{ $course->expire_at->format('Y-m-d\TH:i') }}" id="expire_at">
                                </div> --}}

                                <div class="col s12">
                                    <label for="image">Single Image*</label>
                                    <div class="jFiler-input-dragDrop pos-relative">
                                        <div class="jFiler-input-inner">
                                            <div class="jFiler-input-icon">
                                                <i class="icon-jfi-cloud-up-o"></i>
                                            </div>
                                            <div class="filediv">
                                                <input type="file"
                                                data-fileuploader-files="{{ getFileUploaderMedia($course->image) }}"
                                                name="image" class="file" />
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
                                                <input type="file"
                                                data-fileuploader-files="{{ getFileUploaderMedia($course->gallery) }}"
                                                name="gallery[]" class="file" multiple="" />
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
