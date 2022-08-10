{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Clients transactions')

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
@endsection

@section('content')
    <div class="section section-data-tables">
        <div class="row">
            <div class="col s12 m12 l12">
                <div id="button-trigger" class="card card card-default scrollspy">
                    <div class="card-content">
                        <h4 class="card-title">{{ __('List') }}</h4>
                        <div class="row">
                            <div class="col s12">
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>{{ __('#') }}</th>
                                            <th>{{ __('Client') }}</th>
                                            <th>{{ __('Type') }}</th>
                                            <th>{{ __('Status') }}</th>
                                            <th>{{ __('Total cost') }}</th>
                                            <th>{{ __('admin-content.added-last-modified-date') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customerTransactions as $item)
                                            <tr>
                                            <td>{{ $item->id }}</td>
                                            <td>
                                                <span class="chip lighten-5 blue blue-text">
                                                    <a class="tooltipped" data-position="top"
                                                        data-delay="50" data-tooltip="Show profile"
                                                        href="{{route('admin.customer.show', $item->customer->id)}}"> {{ $item->customer->profile->fullName }}
                                                    </a>
                                                </span>
                                            </td>
                                            @if ($item->transable_type === App\Models\Order::class)
                                                <td>
                                                <span class="chip lighten-5 blue blue-text">
                                                    <a class="tooltipped" data-position="top"
                                                        data-delay="50" data-tooltip="Show order"
                                                        href="{{route('admin.order.show', $item->transable_id)}}"> {{ 'Course Order' }}
                                                    </a>
                                                </span>    
                                                </td>
                                            @endif

                                            @if ($item->transable_type === App\Models\Appointment::class)
                                            <td>
                                            <span class="chip lighten-5 blue blue-text">
                                                <a class="tooltipped" data-position="top"
                                                data-delay="50" data-tooltip="Show appointment"
                                                href="{{route('admin.appointment.show', $item->transable_id)}}"> {{ 'Appointment' }}
                                                </a>
                                            </span>    
                                            </td>
                                            @endif

                                            @if ($item->transable_type === App\Models\CustomerSubscription::class)
                                            <td>
                                                <span class="chip lighten-5 blue blue-text">
                                                    <a class="tooltipped" data-position="top"
                                                        data-delay="50" data-tooltip="Show subscribers"
                                                        href="{{route('admin.customer.subscribers')}}"> {{ 'Subscribe' }}
                                                    </a>
                                                </span>    
                                            </td>
                                            @endif
                                            <td> {{ App\Enums\TransactionStatus::fromValue($item->status)->description}} </td>

                                            <td> {{ $item->total_cost }} </td>
                                            <td>
                                                <small><b>{{ __('admin-content.added-date') }}:</b>
                                                    {{ $item->created_at }}</small>
                                                <br>
                                                <small><b>{{ __('admin-content.modified-date') }}:</b>
                                                    {{ $item->updated_at }}</small>
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
