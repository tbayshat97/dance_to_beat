@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','Coupon')
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
                            <h4 class="card-title">{{ 'Coupon' }}</h4>
                        </div>
                        <div class="col s12 m6 l2">
                        </div>
                    </div>
                </div>
                <div id="html-view-validations">
                    <form id="addform" class="formValidate0" method="POST"
                        action="{{ route('admin.coupon.update', $coupon) }}" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <div class="input-field col s12">
                                <label for="curl0">Coupon Code *</label>
                                <input type="text" value="{{ $coupon->code }}" class="validate" name="code">
                            </div>

                            <div class="input-field col s12">
                                <label for="curl0">Percentage *</label>
                                <input type="number" value="{{ $coupon->percentage }}" class="validate"
                                    name="percentage">
                            </div>

                            <div class="input-field col s12">
                                <label for="curl0">Expire Count *</label>
                                <input type="number" value="{{ $coupon->expire_count }}" class="validate"
                                    name="expire_count">
                            </div>

                            <div class="col s12 m6 l6">
                                <label for="">Start at *</label>
                                <input type="datetime-local" name="start_at" class="validate"
                                    value="{{ $coupon->start_at->format('Y-m-d\TH:i') }}" id="start_id">
                            </div>

                            <div class="col s12 m6 l6">
                                <label for="end_at">End at *</label>
                                <input type="datetime-local" name="end_at" class="validate"
                                    value="{{ $coupon->end_at->format('Y-m-d\TH:i') }}" id="end_at">
                            </div>

                            <div class="col s12">
                                <label for="is_active">Status</label>
                                <div class="s12 input-field">
                                    <div class="switch">
                                        <label>
                                            Not Active
                                            <input type="checkbox" name="is_active" id="is_active"
                                                @if($coupon->is_active) checked @endif>
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
