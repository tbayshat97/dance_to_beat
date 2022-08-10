{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title','App Invoice View' )

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/app-invoice.css')}}">
@endsection

{{-- page content --}}
@section('content')
<!-- app invoice View Page -->
<section class="invoice-view-wrapper section">
    <div class="row">
        <!-- invoice view page -->
        <div class="col xl12 m8 s12">
            <div class="card">
                <div class="card-content invoice-print-area">
                    <!-- header section -->
                    <div class="row invoice-date-number">
                        <div class="col xl4 s12">
                            <span class="invoice-number mr-1">Appointment#</span>
                            <span>{{$appointment->id}}</span>
                        </div>
                        <div class="col xl8 s12">
                            <div class="invoice-date display-flex align-items-center flex-wrap">
                                <div class="mr-3">
                                    <small>Date Appointed:</small>
                                    <span>{{ $appointment->date->format('Y-m-d') }}</span>
                                </div>
                                {{-- <div>
                                    <small>Date:</small>
                                    <span>{{ $appointment->date->format('d-m-y') }}</span>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                    <!-- logo and title -->
                    <div class="row mt-3 invoice-logo-title">
                        <div class="col m6 s12 display-flex invoice-logo mt-1 push-m6">
                            {{-- <img src="{{asset('images/gallery/pixinvent-logo.png')}}" alt="logo" height="46"
                                width="164"> --}}
                        </div>
                        <div class="col m6 s12 pull-m6">
                            <h4 class="indigo-text">Appointment</h4>
                            <span>
                                @if ($appointment->status)
                                {{ App\Enums\AppointmentStatus::fromValue($appointment->status)->description}}
                                @endif</span>
                        </div>
                    </div>
                    <div class="divider mb-3 mt-3"></div>
                    <!-- invoice address and contact -->
                    <div class="row invoice-info">
                        {{-- <div class="col m6 s12">
                            <h6 class="invoice-from">Date</h6>
                            <div class="invoice-address">
                                <span>Day: {{ $appointment->created_at->format('D') }}</span>
                            </div>
                            <div class="invoice-address">
                                <span>Month: {{ $appointment->created_at->format('M') }}</span>
                            </div>
                            <div class="invoice-address">
                                <span>Year: {{ $appointment->created_at->format('Y') }}</span>
                            </div>
                            <div class="invoice-address">
                                <span>TIme: {{ $appointment->created_at->totimestring() }}</span>
                            </div>
                        </div> --}}
                        <div class="col m6 s12">
                            <div class="divider show-on-small hide-on-med-and-up mb-3"></div>
                            <h6 class="invoice-to">Appointed At</h6>
                            <div class="invoice-address">
                                <span>Day:{{ $appointment->date->format('D') }}</span>
                            </div>
                            <div class="invoice-address">
                                <span>Month: {{ $appointment->date->format('M') }}</span>
                            </div>
                            <div class="invoice-address">
                                <span>Year: {{$appointment->date->format('Y')}}</span>
                            </div>
                            <div class="invoice-address">
                                <span>Time: {{$appointment->date->totimestring()}}</span>
                            </div>
                        </div>
                    </div>
                    <!--Customer and artist info-->
                    <div class="divider mb-3 mt-3"></div>
                    <div class="row invoice-info">
                        <div class="col m6 s12">
                            <h6 class="invoice-from">Customer</h6>
                            <div class="invoice-address">
                                <span>Phone:{{ $appointment->customer->username }}</span>
                            </div>
                            <div class="invoice-address">
                                <span>Email: {{ $appointment->customer->email }}</span>
                            </div>
                            <div class="invoice-address">
                                {{-- <span>{{ $appointment->created_at->format('Y') }}</span> --}}
                            </div>
                            <div class="invoice-address">
                                {{-- <span>601-678-8022</span> --}}
                            </div>
                        </div>
                        <div class="col m6 s12">
                            <div class="divider show-on-small hide-on-med-and-up mb-3"></div>
                            <h6 class="invoice-to">Artist</h6>
                            <div class="invoice-address">
                                <span>Username: {{ $appointment->artist->username }}</span>
                            </div>
                            <div class="invoice-address">
                                <span>Name: {{ $appointment->artist->profile->first_name}}
                                    {{$appointment->artist->profile->last_name }}</span>
                            </div>
                            <div class="invoice-address">
                                <span>Phone: {{$appointment->artist->profile->phone}}</span>
                            </div>
                            <div class="invoice-address">
                                {{-- <span>987-352-5603</span> --}}
                            </div>
                        </div>
                    </div>
                    <div class="divider mb-3 mt-3"></div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection

{{-- page scripts --}}
@section('page-script')
<script src="{{asset('js/scripts/app-invoice.js')}}"></script>
@endsection
