@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', $customer->profile->full_name .' profile')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
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
                            <h4 class="card-title">{{ $customer->profile->full_name .' profile' }}</h4>
                        </div>
                        <div class="col s12 m6 l2">
                        </div>
                    </div>
                </div>
                <div id="html-view-validations">
                    <form id="addform" class="formValidate0" method="POST"
                        action="{{ route('admin.customer.update', $customer) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="username">Phone number *</label>
                                <input class="validate" disabled value="{{ $customer->username }}" type="text">
                            </div>
                            <div class="input-field col s12">
                                <label for="email">E-Mail *</label>
                                <input id="email" name="email" placeholder="Email" value="{{$customer->email}}"
                                    class="validate" type="email">
                            </div>
                            <div class="input-field col s12">
                                <label for="curl0">First name *</label>
                                <input type="text" value="{{ $customer->profile->first_name }}" class="validate"
                                    name="first_name">
                            </div>
                            <div class="input-field col s12">
                                <label for="curl0">Last name *</label>
                                <input type="text" value="{{ $customer->profile->last_name }}" class="validate"
                                    name="last_name">
                            </div>
                            {{-- <div class="input-field col s12">
                                <textarea id="bio" name="bio"
                                    class="materialize-textarea">{{ $customer->profile->bio }}</textarea>
                                <label for="bio">Bio</label>
                            </div> --}}

                            <div class="col s12">
                                <p>Gender</p>
                                <p>
                                    <label>
                                        <input class="validate" name="gender" type="radio" value="1"
                                            @if($customer->profile->gender && $customer->profile->gender ===
                                        App\Enums\GenderTypes::Male)
                                        checked
                                        @endif />
                                        <span>Male</span>
                                    </label>
                                </p>
                                <label>
                                    <input class="validate" name="gender" type="radio" value="2"
                                        @if($customer->profile->gender && $customer->profile->gender ===
                                    App\Enums\GenderTypes::Female)
                                    checked
                                    @endif />
                                    <span>Female</span>
                                </label>
                                <div class="input-field">
                                </div>
                            </div>
                            {{-- <div class="input-field col s12">
                                <input type="text" name="birthdate" class="datepicker" id="dob" @if ($customer->profile
                                && $customer->profile->birthdate)
                                value="{{ $customer->profile->birthdate->format('d/m/Y') }}"
                                @endif>
                                <label for="dob">DOB</label>
                            </div> --}}
                            <div class="col s12">
                                <label for="Image">Image</label>
                                <div class="s12 input-field">
                                    <input type="file" name="image" id="input-file-events" class="dropify-event"
                                        data-default-file="{{ asset('storage') . '/' .$customer->profile->image }}"
                                        accept="image/*" />
                                </div>
                            </div>
                            <div class="input-field col s12">
                                {!! Form::select('interests[]', $dances, $customer->interests()->pluck('dance_id')->toArray(),
                                ['multiple' => true]) !!}
                                <label>{{ __('Interests') }}*</label>
                            </div>
                            <div class="col s12">
                                <label for="status">Status</label>
                                <div class="s12 input-field">
                                    <div class="switch">
                                        <label>
                                            Block
                                            <input type="checkbox" name="is_blocked" id="status"
                                                @if(!$customer->is_blocked) checked @endif>
                                            <span class="lever"></span>
                                            Active
                                        </label>
                                    </div>
                                </div>
                            </div>
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
<script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
<script src="{{ asset('js/scripts/form-validation.js') }}"></script>
@endsection
