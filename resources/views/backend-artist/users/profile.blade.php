{{-- extend layout --}}
@extends('layouts-artist.contentLayoutMaster')

{{-- page title --}}
@section('title','Account Settings')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2.min.css')}}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/select2/select2-materialize.css')}}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">

@endsection

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/page-account-settings.css')}}">
<link rel="stylesheet" href="{{ asset('plugins/fileuploader/dist/font/font-fileuploader.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fileuploader/dist/jquery.fileuploader.min.css') }}">
@endsection

{{-- page content --}}
@section('content')
<!-- Account settings -->
<section class="tabs-vertical mt-1 section">
    <div class="row">
        <div class="col l4 s12">
            <!-- tabs  -->
            <div class="card-panel">
                <ul class="tabs">
                    <li class="tab">
                        <a href="#general">
                            <i class="material-icons">brightness_low</i>
                            <span>General</span>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#change-password">
                            <i class="material-icons">lock_open</i>
                            <span>Change Password</span>
                        </a>
                    </li>
                    <li class="tab">
                        <a href="#info">
                            <i class="material-icons">error_outline</i>
                            <span> Info</span>
                        </a>
                    </li>
                    {{-- <li class="tab">
                        <a href="#social-link">
                            <i class="material-icons">chat_bubble_outline</i>
                            <span>Social Links</span>
                        </a>
                    </li> --}}
                </ul>
            </div>
        </div>
        <div class="col l8 s12">
            <!-- tabs content -->
            <div id="general">
                <div class="card-panel">
                    <form id="addform" class="formValidate0" method="POST" action="{{ route('artist.profile.update') }}"
                    enctype="multipart/form-data">
                    @csrf
                        <div class="row">
                            <input name="step" value="1" type="hidden">
                            <div class="input-field col s12">
                                <label for="username">Username / E-mail *</label>
                                <input class="validate" disabled value="{{ $artist->username }}" type="text">
                            </div>
                            <div class="input-field col s12">
                                <label for="curl0">First name *</label>
                                <input type="text" value="{{ $artist->profile->first_name }}" class="validate"
                                    name="first_name">
                            </div>
                            <div class="input-field col s12">
                                <label for="curl0">Last name *</label>
                                <input type="text" value="{{ $artist->profile->last_name }}" class="validate"
                                    name="last_name">
                            </div>
                            <div class="input-field col s12">
                                <label for="curl0">Phone Number *</label>
                                <input type="tel" value="{{ $artist->profile->phone }}" class="validate"
                                    name="phone">
                            </div>
                            <div class="col s12">
                                <label for="image">Single Image*</label>
                                <div class="jFiler-input-dragDrop pos-relative">
                                    <div class="jFiler-input-inner">
                                        <div class="jFiler-input-icon">
                                            <i class="icon-jfi-cloud-up-o"></i>
                                        </div>
                                        <div class="filediv">
                                            <input type="file" name="image" data-fileuploader-files="{{ getFileUploaderMedia($artist->profile->image) }}"
                                                class="file" />
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
                                            <input type="file" name="gallery[]"
                                                data-fileuploader-files="{{ getFileUploaderMedia($artist->profile->gallery)}}" class="file" multiple="" />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col s12 display-flex justify-content-end form-action">
                                <button type="submit" class="btn indigo waves-effect waves-light mr-2">
                                    Save changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="change-password">
                <div class="card-panel">
                    <form id="addform" class="formValidate0" method="POST" action="{{ route('artist.profile.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input name="step" value="2" type="hidden">
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="password">Password</label>
                                <input class="validate" id="password" type="password" name="password">
                            </div>
                            <div class="input-field col s12">
                                <label for="password_confirmation">Confirm Password</label>
                                <input class="validate" id="password_confirmation" type="password"
                                    name="password_confirmation">
                            </div>
                            <div class="col s12 display-flex justify-content-end form-action">
                                <button type="submit" class="btn indigo waves-effect waves-light mr-1">Save
                                    changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div id="info">
                <div class="card-panel">
                    <form id="addform" class="formValidate0" method="POST" action="{{ route('artist.profile.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input name="step" value="3" type="hidden">
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="curl0">Price per hour *</label>
                                <input type="text" value="{{ $artist->profile->price_per_hour }}" class="validate"
                                    name="price_per_hour">
                            </div>
                            <div class="input-field col s12">
                                <textarea id="bio" name="bio"
                                    class="materialize-textarea">{{ $artist->profile->bio }}</textarea>
                                <label for="bio">Bio</label>
                            </div>
                            <div class="col s12">
                                <label for="gender">Gender</label>
                                <p>
                                    <label>
                                        <input class="validate" name="gender" type="radio" value="1"
                                            @if($artist->profile->gender && $artist->profile->gender ===
                                        App\Enums\GenderTypes::Male)
                                        checked
                                        @endif />
                                        <span>Male</span>
                                    </label>
                                </p>
                                <label>
                                    <input class="validate" name="gender" type="radio" value="2"
                                        @if($artist->profile->gender && $artist->profile->gender ===
                                    App\Enums\GenderTypes::Female)
                                    checked
                                    @endif />
                                    <span>Female</span>
                                </label>
                                <div class="input-field">
                                </div>
                            </div>
                            <div class="input-field col s12">
                                <input type="text" name="birthdate" class="datepicker" id="dob" @if ($artist->profile
                                && $artist->profile->birthdate)
                                value="{{ $artist->profile->birthdate->format('d/m/Y') }}"
                                @endif>
                                <label for="dob">DOB</label>
                            </div>
                            <div class="col s12 display-flex justify-content-end form-action">
                                <button type="submit" class="btn indigo waves-effect waves-light mr-2">Save
                                    changes</button>
                                <button type="button"
                                    class="btn btn-light-pink waves-effect waves-light ">Cancel</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- <div id="social-link">
                <div class="card-panel">
                    <form id="addform" class="formValidate0" method="POST" action="{{ route('artist.profile.update') }}"
                        enctype="multipart/form-data">
                        @csrf
                        <input name="step" value="4" type="hidden">
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="facebook_link">Facebook Link</label>
                                <input type="text" id="facebook_link" value="{{ $artist->profile->facebook_link }}" class="validate"
                                    name="facebook_link">
                            </div>
                            <div class="input-field col s12">
                                <label for="twitter_link">Twitter Link</label>
                                <input type="text" id="twitter_link" value="{{ $artist->profile->twitter_link }}" class="validate"
                                    name="twitter_link">
                            </div>
                            <div class="input-field col s12">
                                <label for="linkedin_link">LinkedIn Link</label>
                                <input type="text" id="linkedin_link" value="{{ $artist->profile->linkedin_link }}" class="validate"
                                    name="linkedin_link">
                            </div>
                            <div class="col s12 display-flex justify-content-end form-action">
                                <button type="submit" class="btn indigo waves-effect waves-light mr-2">Save
                                    changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>
</section>
@endsection

{{-- page scripts --}}
@section('vendor-script')
<script src="{{asset('vendors/select2/select2.full.min.js')}}"></script>
<script src="{{asset('vendors/jquery-validation/jquery.validate.min.js')}}"></script>
<script src="{{ asset('plugins/fileuploader/dist/jquery.fileuploader.min.js') }}"></script>
<script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/page-account-settings.js')}}"></script>
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
