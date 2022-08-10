{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Dances')

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
                                <h4 class="card-title">Update</h4>
                            </div>
                            <div class="col s12 m6 l2">
                            </div>
                        </div>
                    </div>
                    <div id="html-view-validations">
                        <form id="addform" class="forms-sample" method="POST"
                            action="{{ route('admin.dance.update', $dance->id) }}" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                @foreach ($langs as $key => $lang)
                                <div class="input-field col s12 m6 l6 ">
                                    <input type="text" name="name_{{ $lang['code'] }}" id="name_{{ $lang['code'] }}"
                                    value="{{$dance->translateOrDefault($lang['code'])->name}}"
                                        class="validate" required />
                                    <label for="name_{{ $lang['code'] }}">{{ __('admin-content.name') }} ({{
                                        $lang['name'] }})*</label>
                                </div>
                                @endforeach
                                <div class="col s12">
                                    <label for="Image">Image</label>
                                    <div class="s12 input-field">
                                        <input type="file" name="image" id="input-file-events" class="dropify-event"
                                            data-default-file="{{ asset('storage') . '/' .$dance->image }}"
                                            accept="image/*" />
                                    </div>
                                </div>
                                <div class="col s12">
                                    <label for="status">Status</label>
                                    <div class="s12 input-field">
                                        <div class="switch">
                                            <label>
                                                Inactive
                                                <input type="checkbox" name="is_active" id="status" @if($dance->is_active) checked @endif>
                                                <span class="lever"></span>
                                                Active
                                            </label>
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
                    <div class="modal fade" id="exampleModalCenter" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalCenterLabel">{{
                                        __('admin-content.delete-image')}}</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                                            aria-hidden="true">&times;</span></button>
                                </div>
                                <div class="modal-body">
                                    {{ __('admin-content.are-you-sure-you-need-to-delete-this')}} {{
                                    __('admin-content.image')}}?
                                </div>
                                <div class="modal-footer">
                                    <form id="frm_confirm_delete_multiple_image" action="#" method="POST">
                                        @csrf
                                        <input type="hidden" value="" name="id" id="item_id">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">{{
                                            __('admin-content.close')}}</button>
                                        <button type="submit" class="btn btn-primary" href="">{{
                                            __('admin-content.delete')}}</button>
                                    </form>
                                </div>
                            </div>
                        </div>
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
