@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', $administration->profile->full_name .' profile')
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
                            <h4 class="card-title">{{ $administration->profile->fullName .' profile' }}</h4>
                        </div>
                        <div class="col s12 m6 l2">
                        </div>
                    </div>
                </div>
                <div id="html-view-validations">
                    <form id="addform" class="formValidate0" method="POST" action="{{ route('admin.administration.update', $administration->id) }}"
                        enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input id="id" type="hidden" name="id" value="{{$administration->id}}">
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="email">E-Mail *</label>
                                <input id="email" name="username" placeholder="Email" value="{{$administration->username}}"
                                    class="validate" type="email">
                            </div>
                            <div class="input-field col s12">
                                <label for="curl0">First name *</label>
                                <input type="text" value="{{ $administration->profile->first_name }}" class="validate"
                                    name="first_name">
                            </div>
                            <div class="input-field col s12">
                                <label for="curl0">Last name *</label>
                                <input type="text" value="{{ $administration->profile->last_name }}" class="validate"
                                    name="last_name">
                            </div>
                            <div class="input-field col s12">
                                {!! Form::select('roles[]', $roles, $selected_roles, ['multiple' => true, 'id' => 'selectPer']) !!}
                                <label>{{ __('Roles') }}</label>
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

