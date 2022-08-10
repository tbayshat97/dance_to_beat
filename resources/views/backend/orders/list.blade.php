{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Orders')

    {{-- vendor styles --}}
@section('vendor-style')
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
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
                                <table id="scroll-dynamic" class="display">
                                    <thead>
                                        <tr>
                                            <th>{{ __('#')}}</th>
                                            <th>{{ __('Order Number') }}</th>
                                            <th>{{ __('Customer Name')}}</th>
                                            <th>{{ __('Course Name')}}</th>
                                            <th>{{ __('Coupon')}}</th>
                                            <th>{{ __('Order Date')}}</th>
                                            <th>{{ __('Finished')}}</th>
                                            <th>{{ __('Status')}}</th>
                                            <th>{{ __('Total Cost') }}</th>
                                            <th class="no-sort">{{ __('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($orders as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td> {{ $item->order_number }} </td>
                                                <td>
                                                    <span>{{ $item->Customer->profile->full_name}}</span>
                                                </td>
                                                <td>
                                                    <span>{{ $item->Course->translateOrDefault()->title }}</span>
                                                </td>
                                                <td>
                                                    @if ($item->coupon()->count())
                                                        <span class="chip lighten-5 blue blue-text">
                                                            {{ $item->coupon->code }}
                                                        </span>
                                                    @else
                                                        <span class="chip lighten-5 green green-text">No coupon used</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    <span>{{$item->created_at->format('d/m/Y')}}</span>
                                                </td>
                                                <td>
                                                    @if ($item->is_finished)
                                                        <span class="chip lighten-5 green green-text">Yes</span>
                                                    @else
                                                        <span class="chip lighten-5 red red-text">No</span>
                                                    @endif

                                                </td>
                                                <td>
                                                    @if ($item->status)
                                                    {{ App\Enums\OrderStatus::fromValue($item->status)->description}}
                                                    @endif
                                                </td>
                                                <td>
                                                    <span>{{$item->total_cost}}</span>
                                                </td>
                                                <td class="center-align">
                                                    <a href="{{ route('admin.order.show', $item) }}" class="btn-floating cyan pulse"><i class="material-icons">visibility</i></a>
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
    <script>
        function setRoute($id, $route) {
            $('#item_id').val($id);
            $('#frm_confirm_delete').attr('action', $route);
        }
    </script>
@endsection

