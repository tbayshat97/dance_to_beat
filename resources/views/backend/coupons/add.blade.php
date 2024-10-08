{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Add Coupon')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
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
                        <form id="addform" class="formValidate0" method="POST"
                            action="{{ route('admin.coupon.store') }}" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="input-field col s12">
                                    <label for="curl0">Coupon Code *</label>
                                    <input type="text" class="validate" name="code">
                                </div>
                                <div class="input-field col s12">
                                    <label for="curl0">Percentage *</label>
                                    <input type="number" class="validate" name="percentage">
                                </div>
                                <div class="input-field col s12">
                                    <label for="curl0">Expire Count *</label>
                                    <input type="number" class="validate" name="expire_count">
                                </div>
                                <div class="col s12 m6 l6">
                                    <label for="">Start at *</label>
                                    <input type="datetime-local" name="start_at" class="validate" id="start_at">
                                </div>
                                <div class="col s12 m6 l6">
                                    <label for="end_at">End at *</label>
                                    <input type="datetime-local" name="end_at" class="validate" id="end_at">
                                </div>
                                <div class="col s12">
                                    <label for="is_active">Status</label>
                                    <div class="s12 input-field">
                                        <div class="switch">
                                            <label>
                                                Not Active
                                                <input type="checkbox" name="is_active" id="is_active" checked>
                                                <span class="lever"></span>
                                                Active
                                            </label>
                                        </div>
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
