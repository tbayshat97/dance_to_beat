{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Clients')

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
                                <table id="page-length-option" class="display">
                                    <thead>
                                        <tr>
                                            <th>{{ __('#')}}</th>
                                            <th class="no-sort">{{ __('Profile Picture')}}</th>
                                            <th>{{ __('Full name')}}</th>
                                            <th>{{ __('Phone Number')}}</th>
                                            <th>{{ __('Email')}}</th>
                                            <th>{{ __('Status')}}</th>
                                            <th>{{ __('Source')}}</th>
                                            <th class="no-sort">{{ __('Action')}}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($customers as $key => $item)
                                            <tr>
                                                <td>{{ $key + 1 }}</td>
                                                <td><img src="{{ asset(isset($item->profile->image) ? 'storage/' . $item->profile->image : 'images/placeholders/user.png') }}" width="40" height="40"
                                                        class="circle" /> </td>
                                                <td> {{ $item->profile->fullName }} </td>
                                                <td>
                                                    @if(isValidNumber($item->username))
                                                    <span class="chip lighten-5 green green-text"><strong>{{'+'
                                                            .$item->username}}</strong></span>
                                                    @else
                                                    <span class="chip lighten-5 orange orange-text">{{ __('Social login')}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if($item->email)
                                                    <span class="chip lighten-5 green green-text">{{$item->email}}</span>
                                                    @else
                                                    <span class="chip lighten-5 red red-text">{{ __('Need to update')}}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->profile && !$item->is_blocked)
                                                        <span
                                                            class="chip lighten-5 green green-text">{{ __('admin-content.active') }}</span>
                                                    @else
                                                        <span
                                                            class="chip lighten-5 red red-text">{{ __('admin-content.inactive') }}</span>
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($item->profile && $item->profile->source)
                                                    {{ App\Enums\SourceType::fromValue($item->profile->source)->description }}
                                                    @endif
                                                </td>
                                                <td class="center-align">
                                                    <a href="{{ route('admin.customer.show', $item) }}" class="btn-floating cyan pulse"><i class="material-icons">edit</i></a>
                                                    <a href="#modalDelete" onclick="setRoute('{{ $item }}', '{{ route('admin.customer.destroy', $item) }}')" class="modal-trigger btn-floating red pulse"><i class="material-icons">delete</i></a>
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

