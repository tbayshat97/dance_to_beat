{{-- extend layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Subscriptions')

{{-- page styles --}}
@section('page-style')
<link rel="stylesheet" type="text/css" href="{{asset('css/pages/pricing.css')}}">
@endsection

{{-- page content --}}
@section('content')
<div class="row">
    <div class="col s12 m12 l12">
        <div id="basic-tabs" class="card card card-default scrollspy">
            <div class="card-content">
                <h4 class="card-title">Pricing </h4>
                <div class="row">
                    <div class="col s12">
                        <div class="row">
                            <div class="plans-container">
                                @foreach ($subscriptions as $item)
                                <div class="col s12 m6 l4">
                                    <div class="card hoverable animate fadeLeft">
                                        <div class="card-image gradient-45deg-light-blue-cyan waves-effect">
                                            <div class="card-title">{{ strtoupper($item->name) }}</div>
                                            <div class="price">
                                                <sup>JOD</sup>{{ $item->price }}
                                                <sub>/<span>{{ $item->month_count }} mo</span></sub>
                                            </div>
                                        </div>
                                        <div class="card-content">
                                            <ul class="collection">
                                                <li class="collection-item">Unlimited courses</li>
                                                <li class="collection-item">1 user</li>
                                            </ul>
                                        </div>
                                        <div class="card-action center-align">
                                            <a href="{{ route('admin.subscription.show', $item->id) }}" class="waves-effect waves-light gradient-45deg-indigo-purple gradient-shadow btn" role="button" aria-pressed="true">Update</a>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
