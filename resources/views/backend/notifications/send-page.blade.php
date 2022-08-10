@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Send notification')
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
                            <h4 class="card-title">{{ 'Send notification' }}</h4>
                        </div>
                        <div class="col s12 m6 l2">
                        </div>
                    </div>
                </div>
                <div id="html-view-validations">
                    <form id="addform" class="formValidate0" method="POST"
                        action="{{ route('admin.send-notification')}}" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="curl0">Title *</label>
                                <input type="text" class="validate"
                                    name="title">
                            </div>
                            <div class="input-field col s12">
                                <textarea id="message" name="message"
                                    class="materialize-textarea"></textarea>
                                <label for="message">Message *</label>
                            </div>
                            <div class="col s12">
                                <p>Type</p>
                                <p>
                                    <label>
                                        <input class="validate" name="type" type="radio" value="{{ App\Models\Customer::class }}"/>
                                        <span>Customer</span>
                                    </label>
                                </p>
                                <div class="input-field">
                                </div>
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
