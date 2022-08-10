{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Artists')

{{-- vendor styles --}}
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
<style>
    table.dataTable, table.dataTable th, table.dataTable td {
        box-sizing: inherit;
    }
</style>
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
                                            <th class="no-sort">{{ __('Profile Picture')}}</th>
                                            <th>{{ __('Full name')}}</th>
                                            <th>{{ __('Phone Number')}}</th>
                                            <th>{{ __('Price per Hour')}}</th>
                                            <th>{{ __('Percentage')}}</th>
                                            <th>{{ __('Gender')}}</th>
                                            <th>{{ __('Rate')}}</th>
                                            <th>{{ __('Status')}}</th>
                                            <th class="no-sort">{{ __('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($artists as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><img src="{{ $item->profile->getProfileImage() }}" width="40" height="40"
                                                        class="circle" /> </td>
                                                <td> {{ $item->profile->fullName }} </td>
                                                <td>
                                                    <span class="chip lighten-5 blue blue-text"><strong>{{'+' .$item->profile->phone}}</strong></span>
                                                </td>
                                                <td>
                                                    {{ $item->profile->price_per_hour }}
                                                </td>
                                                <td>
                                                    {{ $item->profile->percentage }}%
                                                </td>
                                                <td>
                                                    @if ($item->profile->gender)
                                                    {{ App\Enums\GenderTypes::fromValue($item->profile->gender)->description}}
                                                    @endif
                                                </td>
                                                <td>
                                                    @php
                                                        $rate = starRatingsCalculator(App\Models\Artist::class, $item->id)
                                                    @endphp
                                                <div class="num-rate" data-rateyo-read-only="true" data-rateyo-rating="{{ $rate['total'] }}">
                                                </td>
                                                <td>
                                                    @if ($item->status == App\Enums\ArtistStatus::Actived)
                                                    <span class="chip lighten-5 green green-text">{{ App\Enums\ArtistStatus::fromValue($item->status)->description}}</span>
                                                    @endif

                                                    @if ($item->status == App\Enums\ArtistStatus::Suspended)
                                                    <span class="chip lighten-5 orange orange-text">{{ App\Enums\ArtistStatus::fromValue($item->status)->description}}</span>
                                                    @endif

                                                    @if ($item->status == App\Enums\ArtistStatus::Blocked)
                                                    <span class="chip lighten-5 red red-text">{{ App\Enums\ArtistStatus::fromValue($item->status)->description}}</span>
                                                    @endif
                                                </td>
                                                <td class="center-align">
                                                    <a href="{{ route('admin.artist.show', $item) }}" class="btn-floating cyan pulse"><i class="material-icons">edit</i></a>
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
    <div id="modalDelete" class="modal">
        <div class="modal-content">
            <h4>{{ __('admin-content.delete') }}</h4>
            <p>{{ __('admin-content.are-you-sure-you-need-to-delete-this') }} ?</p>
        </div>
        <div class="modal-footer">
            <form id="frm_confirm_delete" action="#" method="POST">
                @csrf
                @method('DELETE')
                <input type="hidden" value="" name="id" id="item_id">
                <a href="#!" class="modal-action modal-close waves-effect waves-red btn-flat ">Cancel</a>
                <button class="btn waves-effect waves-light" type="submit" name="action">Submit
                    <i class="material-icons right">send</i>
                </button>
            </form>
        </div>
    </div>
@endsection
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
