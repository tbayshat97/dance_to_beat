{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Artists Reviews')

@section('vendor-style')
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/flag-icon/css/flag-icon.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/jquery.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css"
    href="{{ asset('vendors/data-tables/extensions/responsive/css/responsive.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{ asset('vendors/data-tables/css/select.dataTables.min.css') }}">
<link rel="stylesheet" type="text/css" href="{{asset('vendors/rateYo/jquery.rateyo.min.css')}}">
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
                                            <th>{{ __('#')}}</th>
                                            <th>{{ __('Artist')}}</th>
                                            <th>{{ __('Rate') }}</th>
                                            <th class="no-sort">{{ __('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($artists as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td> {{ $item->profile->full_name }} </td>
                                                <td>
                                                    @php
                                                        $rate = starRatingsCalculator(App\Models\Course::class, $item->id)
                                                    @endphp
                                                <div class="num-rate" data-rateyo-read-only="true" data-rateyo-rating="{{ $rate['total'] }}">
                                                </div>
                                                </td>
                                                <td class="center-align">
                                                    <a href="{{ route('admin.artists-review.show', $item) }}" class="btn-floating cyan pulse"><i class="material-icons">visibility</i></a>
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
{{-- vendor scripts --}}
@section('vendor-script')
<script src="{{asset('vendors/rateYo/jquery.rateyo.min.js')}}"></script>
<script src="{{ asset('vendors/data-tables/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/extensions/responsive/js/dataTables.responsive.min.js') }}"></script>
<script src="{{ asset('vendors/data-tables/js/dataTables.select.min.js') }}"></script>
@endsection

{{-- page script --}}
@section('page-script')
<script src="{{asset('js/scripts/extra-components-ratings.js')}}"></script>
<script src="{{ asset('js/scripts/data-tables.js') }}"></script>
<script src="{{ asset('js/scripts/advance-ui-modals.js') }}"></script>
<script src="{{asset('js/scripts/extra-components-ratings.js')}}"></script>
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
