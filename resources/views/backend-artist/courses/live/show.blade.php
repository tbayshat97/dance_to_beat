{{-- layout --}}
@extends('layouts-artist.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Live course')

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
                        <form class="formValidate0" method="POST" action="{{ route('artist.course.live.update', $liveCourse->id) }}"
                            enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="input-field col s12 m6 l6">
                                    <label for="meeting_id">Meeting id</label>
                                    <input type="text" id="meeting_id"  readonly class="validate" value="{{ $liveCourse->meeting_id }}"
                                        name="meeting_id">
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <label for="course_id ">Course</label>
                                    <input type="text" id="course_id "  readonly class="validate" value="{{ $liveCourse->course->translateOrDefault()->title  }}"
                                        name="course_id ">
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <label for="ropic">Topic *</label>
                                    <input type="text" id="topic" class="validate" value="{{ $liveCourse->topic }}"
                                        name="topic" required>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <textarea name="description" id="description"
                                        class="materialize-textarea" required>{{ $liveCourse->description }}</textarea>
                                        <label for="description">Agenda *</label>
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <label for="password">Password *</label>
                                    <input type="text" class="validate" value="{{ $liveCourse->password }}"
                                        name="password">
                                </div>

                                <div class="input-field col s12 m6 l6">
                                    <label for="duration">Duration (min) *</label>
                                    <input type="number" class="validate" id="duration" value="{{ $liveCourse->duration }}"
                                        name="duration">
                                </div>

                                <div class="col s12 m6 l6">
                                    <label for="">Start at *</label>
                                    <input type="datetime-local" name="start_at" class="validate"
                                        value="{{ $liveCourse->start_at->format('Y-m-d\TH:i') }}" id="start_at">
                                </div>

                                {{-- <div class="input-field col s12 m6 l6">
                                    <label for="join_url">Join url</label>
                                    <input type="text" readonly class="validate" id="join_url" value="{{ $liveCourse->join_url }}"
                                        name="join_url">
                                </div> --}}
                                
                                <div class="input-field col s12 m6 l6">
                                    <label for="price">Course price *</label>
                                    <input type="number" class="validate" value="{{ $liveCourse->course->price }}"
                                        name="price">
                                </div>

                                <div class="input-field input-field col s12 ">
                                    <p>
                                        <label>Settings</label>
                                    </p>
                                    <p>
                                        <label>
                                        <input name="mute_upon_entry" @if ($liveCourse->mute_upon_entry)
                                            checked
                                        @endif type="checkbox">
                                        <span>Mute upon entry</span>
                                        </label>
                                    </p>
                                    <p>
                                        <label>
                                        <input name="participant_video" @if ($liveCourse->participant_video)
                                            checked
                                        @endif type="checkbox">
                                        <span>Participant video</span>
                                        </label>
                                    </p>
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
