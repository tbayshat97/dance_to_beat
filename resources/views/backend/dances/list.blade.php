{{-- layout --}}
@extends('layouts.contentLayoutMaster')

{{-- page title --}}
@section('title', 'Dances')

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
                                            <th class="no-sort">{{ __('admin-content.image') }}</th>
                                            <th>{{ __('admin-content.title') }}</th>
                                            <th>{{ __('admin-content.status') }}</th>
                                            <th>{{ __('admin-content.added-last-modified-date') }}</th>
                                            <th class="no-sort">{{ __('admin-content.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($dances as $item)
                                            <tr>
                                            <td>{{ $item->id }}</td>
                                            <td><img src="{{ asset('storage/' . $item->image) }}" width="75" height="75"
                                                    class="" /> </td>
                                            <td> {{ $item->translateOrDefault()->name }} </td>
                                            <td>
                                                @if ($item->is_active)
                                                    <span
                                                        class="chip lighten-5 green green-text">{{ __('admin-content.active') }}</span>
                                                @else
                                                    <span
                                                        class="chip lighten-5 red red-text">{{ __('admin-content.inactive') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small><b>{{ __('admin-content.added-date') }}:</b>
                                                    {{ $item->created_at }}</small>
                                                <br>
                                                <small><b>{{ __('admin-content.modified-date') }}:</b>
                                                    {{ $item->updated_at }}</small>
                                            </td>
                                            <td class="center-align">
                                                <a href="{{ route('admin.dance.show', $item) }}" class="btn-floating cyan pulse"><i class="material-icons">edit</i></a>
                                                <a href="#modalDelete" onclick="setRoute('{{ $item }}', '{{ route('admin.dance.destroy', $item) }}')" class="modal-trigger btn-floating red pulse"><i class="material-icons">delete</i></a>
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
