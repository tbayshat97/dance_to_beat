{{-- layout --}}
@extends('layouts-artist.contentLayoutMaster')

{{-- page title --}}
@section('title', 'available times')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
@endsection

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
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
                                <h4 class="card-title">Update {{ $date . ' available times' }}</h4>
                            </div>
                            <div class="col s12 m6 l2">
                            </div>
                        </div>
                    </div>
                    <div id="html-view-validations">
                        <form class="formValidate0" id="formValidate0" method="POST"
                            action="{{ route('artist.artistAvailableTime.updateSingleDateAvailableTimes', $date) }}"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="col s12">
                                    <label for="available_times">{{ __('Available times') }}</label>
                                    @if($availableTimes)
                                    @foreach ($availableTimes as $key => $item)
                                    <div class="row mb-2">
                                        <input type="hidden" name="available_times_old[{{$key}}][id]"
                                            value="{{ $item->id }}">
                                        <div class="input-field col s9">
                                            <input type="time"
                                                name="available_times_old[{{$key}}][available_times_time]"
                                                class="form-control" value="{{ $item->time }}" placeholder="time">
                                        </div>
                                        <button type="button" class="btn-floating red pulse ml-2 btn-remove-old-pn">
                                            <i class="material-icons">delete</i>
                                        </button>
                                    </div>
                                    @endforeach
                                    @endif
                                    <div class="repeater">
                                        <div data-repeater-list="available_times">
                                            <div data-repeater-item class="row mb-2">
                                                <div class="input-field col s9">
                                                    <input type="time" name="available_times_time"
                                                        class="form-control" placeholder="Name english">
                                                </div>
                                                <button data-repeater-delete type="button"
                                                    class="btn-floating red pulse">
                                                    <i class="material-icons">delete</i>
                                                </button>
                                            </div>
                                        </div>
                                        <button data-repeater-create type="button"
                                            class="btn-floating cyan pulse right">
                                            <i class="material-icons">add</i>
                                        </button>
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
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
<script src="{{ asset('js/scripts/form-validation.js') }}"></script>
<script src="{{ asset('plugins/jquery.repeater/jquery.repeater.min.js') }}"></script>
<script>
    $('.btn-remove-old-pn').click(function (e) {
        if (confirm('Are you sure you want to delete this element?')) {
            $(this).parent().remove();
        }
    });

    $('.btn-remove-old-pr').click(function (e) {
        if (confirm('Are you sure you want to delete this element?')) {
            $(this).parent().remove();
        }
    });

    $('.repeater').repeater({
        initEmpty: true,
        show: function () {
            $(this).slideDown();
            $(function () {
                $('.file-upload-browse').on('click', function () {
                    var file = $(this).parent().parent().parent().find('.file-upload-default');
                    file.trigger('click');
                });
                $('.file-upload-default').on('change', function () {
                    $(this).parent().find('.form-control').val($(this).val().replace(/C:\\fakepath\\/i, ''));
                });
            });
        },
        hide: function (deleteElement) {
            if (confirm('Are you sure you want to delete this element?')) {
                $(this).slideUp(deleteElement);
            }
        },
        isFirstItemUndeletable: true
    });
</script>
@endsection
