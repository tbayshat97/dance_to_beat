{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Appointments Report')

{{-- vendor styles --}}
@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
@endsection

{{-- page style --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{ asset('css/pages/data-tables.css') }}">
<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

@section('content')
<div class="section section-data-tables">
    <div class="row">
        <div class="col xl12 m12 s12">
            <div class="card">
                <div class="card-content px-36">
                    <!-- header section -->
                    <div class="row mb-3">
                        <form method="get" action="{{route('admin.bookings-report')}}">
                            <div class="col s12 m6 l6">
                                <label for="">Start Date</label>
                                <input type="date" class="validate" id="start_id"
                                    value="{{ Request::get('start_date') ?? '' }}" name="start_date">
                            </div>
                            <div class="col s12 m6 l6">
                                <label for="">End Date</label>
                                <input type="date" class="validate" id="start_id"
                                    value="{{ Request::get('end_date') ?? '' }}" name="end_date">
                            </div>
                    </div>
                    <div class="col xl4 m12 display-flex align-items-center">
                        <div class="form-row">
                            <div class="col xl12 sm12 m12">
                                <button type="submit" class="btn btn-md btn-outline-dark btn-loading">
                                    Filter
                                </button>
                                <a class="btn btn-outline-danger btn-loading" href="{{route('admin.bookings-report')}}">
                                    Reset
                                </a>
                            </div>
                        </div>
                    </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
    <div class="col s12 m12 l12">
        <div id="button-trigger" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">{{ __('List') }}</h4>
                <div class="row">
                    <div class="col s12">
                        <table id="page-length-option" class="display">
                            <thead>
                                <tr>
                                    <th>{{ __('#')}}</th>
                                    <th>{{ __('Customer Name')}}</th>
                                    <th>{{ __('Artist Name')}}</th>
                                    <th>{{ __('Appointment Date')}}</th>
                                    <th>{{ __('Appointment Time')}}</th>
                                    <th>{{ __('Status')}}</th>
                                    <th class="no-sort">{{ __('Action')}}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($books as $key => $item)
                                <tr>
                                    <td>{{ $key + 1 }}</td>
                                    <td>
                                        <span class="chip lighten-5 blue blue-text">
                                            <a class="tooltipped" data-position="top" data-delay="50"
                                                data-tooltip="Show profile"
                                                href="{{route('admin.customer.show', $item->customer->id)}}"> {{
                                                $item->customer->profile->fullName }}
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        <span class="chip lighten-5 blue blue-text">
                                            <a class="tooltipped" data-position="top" data-delay="50"
                                                data-tooltip="Show profile"
                                                href="{{route('admin.artist.show', $item->artist->id)}}"> {{
                                                $item->artist->profile->fullName }}
                                            </a>
                                        </span>
                                    </td>
                                    <td>
                                        <span>{{$item->date->format('d/m/Y')}}</span>
                                    </td>
                                    <td>
                                        <span>{{$item->date->format('g:i A')}}</span>
                                    </td>
                                    <td>
                                        @if ($item->status)
                                        {{ App\Enums\AppointmentStatus::fromValue($item->status)->description}}
                                        @endif
                                    </td>
                                    <td class="center-align">
                                        <a href="{{ route('admin.appointment.show', $item) }}"
                                            class="btn-floating cyan pulse"><i class="material-icons">visibility</i></a>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
</div>
@endsection
{{-- vendor scripts --}}
@section('vendor-script')
<script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{ asset('js/scripts/data-tables.js') }}"></script>
<script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/1.7.1/js/buttons.html5.min.js"></script>
@endsection
