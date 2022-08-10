@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', ' Course Reviews')
{{-- vendor style --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/dropify/css/dropify.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/rateYo/jquery.rateyo.min.css')}}">
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
                            <h4 class="card-title">{{'Show'}}</h4>
                        </div>
                        <div class="col s12 m6 l2">
                        </div>
                    </div>
                </div>
                <table id="page-length-option" class="display">
                    <thead>
                        <tr>
                            <th>{{ __('#')}}</th>
                            <th>{{ __('Customer Name') }}</th>
                            <th>{{ __('Rate') }}</th>
                            <th>{{ __('Note') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->reviews as $key => $item)
                        {{-- {{ dd($course->reviews) }} --}}
                            <tr>
                                <td>{{ $key + 1 }}</td>
                                <td>{{ $item->Customer->profile->full_name }}</td>
                                <td>
                                <div class="num-rate" data-rateyo-read-only="true" data-rateyo-rating="{{ $item->rate }}">
                                </div>
                                </td>
                                <td>{{ $item->note }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
{{-- vendor script --}}
@section('vendor-script')
<script src="{{asset('vendors/rateYo/jquery.rateyo.min.js')}}"></script>
<script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('vendors/dropify/js/dropify.min.js') }}"></script>
<script src="{{ asset('vendors/jquery-validation/jquery.validate.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')

<script src="{{ asset('js/scripts/form-file-uploads.js') }}"></script>
<script src="{{ asset('js/scripts/form-validation.js') }}"></script>
<script src="{{asset('vendors/rateYo/jquery.rateyo.min.js')}}"></script>
<script src="{{asset('js/scripts/extra-components-ratings.js')}}"></script>
@endsection
