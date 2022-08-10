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
        <div class="col xl12    ">
            <div class="card">
                <div class="card-content invoice-print-area">
                    <!-- header section -->
                    <div class="row invoice-date-number">
                        <div class="col xl4 s12">
                            <span class="invoice-number mr-1">Order#</span>
                            <span>{{ $order->order_number }}</span>
                        </div>
                        <div class="col xl8 s12">
                            <div class="invoice-date display-flex align-items-center flex-wrap">
                                <div class="mr-3">
                                    <small>Date Issue:</small>
                                    <span>{{ $order->created_at->format('Y-m-d') }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- logo and title -->
                    <div class="row mt-3 invoice-logo-title">
                        <div class="col m6 s12 display-flex invoice-logo mt-1 push-m6">
                            {{-- <img src="{{asset('images/logo/ic_launcher.png')}}" alt="logo" height="46" width="164">
                            --}}
                        </div>
                        <div class="col m6 s12 pull-m6">
                            <h4 class="indigo-text">Order</h4>
                            <span>
                                @if ($order->status)
                                {{ App\Enums\OrderStatus::fromValue($order->status)->description}}
                                @endif
                            </span>
                        </div>
                    </div>
                    <div class="divider mb-3 mt-3"></div>
                    <!-- invoice address and contact -->
                    <div class="row invoice-info">
                        <div class="col m12 s12">
                            <h6 class="invoice-from">Customer Information</h6>
                            <div class="invoice-address">
                                <span>PhoneNumber: {{ $order->customer->username }}</span>
                            </div>
                            <div class="invoice-address">
                                <span>Email: {{ $order->customer->email }}</span>
                            </div>
                        </div>
                    </div>
                    <div class="divider mb-3 mt-3"></div>
                    <!-- product details table-->
                    <div class="invoice-product-details">
                        <table class="striped responsive-table">
                            <thead>
                                <tr>
                                    <th>Item</th>
                                    <th>Course</th>
                                    <th>Coupon</th>
                                    <th class="right-align">Price</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>1</td>
                                    <td>{{ $order->course->title }}</td>
                                    <td>{{ $order->coupon->code ?? "No Code"}}</td>
                                    <td class="indigo-text right-align">${{ $order->total_cost }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                    <!-- invoice subtotal -->
                    <div class="divider mt-3 mb-3"></div>
                    <div class="invoice-subtotal">
                        <div class="row">
                            <div class="col m5 s12">
                            </div>
                            <div class="col xl4 m7 s12 offset-xl3">
                                <ul>
                                    <li class="display-flex justify-content-between">
                                        <span class="invoice-subtotal-title">Subtotal</span>
                                        <h6 class="invoice-subtotal-value">{{ $order->total_cost }}</h6>
                                    </li>
                                    <li class="display-flex justify-content-between">
                                        <span class="invoice-subtotal-title">Discount</span>
                                        @if(isset($order->coupon->percentage))
                                        <h6 class="invoice-subtotal-value">{{ $order->total_cost *
                                            $order->coupon->percentage/100 }}</h6>
                                        @else
                                        <h6 class="invoice-subtotal-value">0</h6>
                                        @endif
                                    </li>
                                    <li class="display-flex justify-content-between">
                                        <span class="invoice-subtotal-title">Totla</span>
                                        @if(isset($order->coupon->percentage))
                                        <h6 class="invoice-subtotal-value">{{ $order->total_cost -($order->total_cost*
                                            $order->coupon->percentage/100) }}</h6>
                                        @else
                                        <h6 class="invoice-subtotal-value">{{ $order->total_cost}}</h6>
                                        @endif
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
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
