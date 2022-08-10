@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', $artist->profile->full_name .' profile')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/rateYo/jquery.rateyo.min.css')}}">
@endsection

@section('page-style')
<link rel="stylesheet" href="{{ asset('plugins/fileuploader/dist/font/font-fileuploader.css') }}">
<link rel="stylesheet" href="{{ asset('plugins/fileuploader/dist/jquery.fileuploader.min.css') }}">
@endsection

{{-- page content --}}
@section('content')
<div class="row">
    <div class="col s12">
        <div id="html-validations" class="card card-tabs">
            <div class="card-content">
                <div class="card-title">
                    <div class="row">
                        <div class="col s12 m6 l10">
                            <h4 class="card-title">{{ $artist->profile->full_name .' profile' }}</h4>
                            @php
                            $rate = starRatingsCalculator(App\Models\Artist::class, $artist->id)
                            @endphp
                            </td>
                        </div>
                        <div class="col s12 m6 l2">
                            <div class="num-rate" data-rateyo-read-only="true"
                                data-rateyo-rating="{{ $rate['total'] }}">
                            </div>
                        </div>
                    </div>
                    <div id="html-view-validations">
                        <form id="addform" class="formValidate0" method="POST"
                            action="{{ route('admin.artist.update', $artist) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="username">Username / E-mail*</label>
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
                                <div class="input-field col s12">
                                    {!! Form::select('dances', $dances, $artist->profile->dance->id) !!}
                                    <label>{{ __('Dance') }} *</label>
                                </div>

                                <div class="input-field col s12">
                                    <textarea id="bio" name="bio"
                                        class="materialize-textarea">{{ $artist->profile->bio }}</textarea>
                                    <label for="bio">Bio</label>
                                </div>

                                <div class="col s12">
                                    <p>Gender</p>
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
                                    <input type="text" name="birthdate" class="datepicker" id="dob" @if($artist->profile && $artist->profile->birthdate)
                                    value="{{ $artist->profile->birthdate->format('d/m/Y') }}"
                                    @endif>
                                    <label for="dob">DOB</label>
                                </div>
                                <div class="col s12">
                                    <label for="image">Artist Image*</label>
                                    <div class="jFiler-input-dragDrop pos-relative">
                                        <div class="jFiler-input-inner">
                                            <div class="jFiler-input-icon">
                                                <i class="icon-jfi-cloud-up-o"></i>
                                            </div>
                                            <div class="filediv">
                                                <input type="file" name="image"
                                                    data-fileuploader-files="{{ getFileUploaderMedia($artist->profile->image) }}"
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
                                                    data-fileuploader-files="{{ getFileUploaderMedia($artist->profile->gallery) }}"
                                                    class="file" multiple="" />
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col s12">
                                    <label for="status">Status</label>
                                    {!! Form::select('status', $artistStatuses, $artist->status) !!}
                                </div>
                                <div class="input-field col s12">
                                    <label for="curl0">Price per hour *</label>
                                    <input type="text" value="{{ $artist->profile->price_per_hour }}" class="validate"
                                        name="price_per_hour">
                                </div>
                                <div class="input-field col s12">
                                    <label for="curl0">Percentage*</label>
                                    <input type="text" value="{{ $artist->profile->percentage }}" class="validate"
                                        name="percentage">
                                </div>
                                {{-- <div class="input-field col s12">
                                    <label for="curl0">Facebook Link</label>
                                    <input type="text" value="{{ $artist->profile->facebook_link }}" class="validate"
                                        name="facebook_link">
                                </div>
                                <div class="input-field col s12">
                                    <label for="curl0">Twitter Link</label>
                                    <input type="text" value="{{ $artist->profile->twitter_link }}" class="validate"
                                        name="twitter_link">
                                </div>
                                <div class="input-field col s12">
                                    <label for="curl0">LinkedIn Link</label>
                                    <input type="text" value="{{ $artist->profile->linkedin_link }}" class="validate"
                                        name="linkedin_link">
                                </div> --}}
                                <div class="input-field col s12">
                                    <label for="password">Password</label>
                                    <input class="validate" id="password" type="password" name="password">
                                </div>
                                <div class="input-field col s12">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input class="validate" id="password_confirmation" type="password"
                                        name="password_confirmation">
                                </div>
                                <div class="input-field col s12">
                                    <button class="btn waves-effect waves-light right" type="submit">Submit
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
<script src="{{asset('vendors/rateYo/jquery.rateyo.min.js')}}"></script>
<script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/extra-components-ratings.js')}}"></script>
<script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
<script src="{{ asset('js/scripts/form-validation.js') }}"></script>
<script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
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
