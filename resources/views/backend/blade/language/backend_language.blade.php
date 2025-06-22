@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Admin Language') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/custom.css') }}">
@endpush
@push('page_css')
    <style>
        .loader-box {
            height: auto;
            padding: 10px 0px;
        }

        .loader-box .loader-35:after {
            height: 20px;
            width: 10px;
        }

        .loader-box .loader-35:before {
            width: 20px;
            height: 10px;
        }
    </style>
@endpush
@section('content')
    {{-- Add apikey Modal Start --}}

    <div class="modal fade" id="edit-apikey-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Update Api Key') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="edit_apikey_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="api_key"><strong>{{ __('admin_local.Microsoft Translate Api Key') }} *</strong></label>
                                <textarea rows="5" class="form-control" name="api_key" id="api_key">{{ $api_key?$api_key->api_key:"" }}</textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">
                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right" type="button">{{ __('admin_local.Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit">{{ __('admin_local.Update') }}</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Add apikey Modal End --}}



    {{-- Edit String Modal Start --}}

    <div class="modal fade" id="edit-string-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-md">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit String') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="edit_string_form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="lang_code" name="lang_code" value="">
                        <input type="hidden" id="file_name" name="file_name" value="">
                        <input type="hidden" id="trid" name="trid" value="">
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="string"><strong>{{ __('admin_local.String') }} *</strong></label>
                                <input type="text" class="form-control" name="string" id="string" readonly>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="translation"><strong>{{ __('admin_local.Translation') }} *</strong></label>
                                <textarea rows="5" class="form-control" name="translation" id="translation"></textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">

                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right" type="button">{{ __('admin_local.Close') }}</button>
                                <button class="btn btn-primary mx-2" style="float: right"
                                    type="submit">{{ __('admin_local.Submit') }}</button>
                            </div>

                        </div>
                    </form>
                </div>

            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    {{-- Edit String Modal End --}}

    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.Admin Language') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Language') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Admin Language') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Admin Language') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['backend-api-accesskey']))
                        <div class="row mb-3">
                            <div class="col-md-12 text-right">
                                <button class="btn btn-info" style="float: right;" type="btn" data-bs-toggle="modal"
                                    data-bs-target="#edit-apikey-modal">+  {{ __('admin_local.Add Api Key')}}</button>
                            </div>
                        </div>
                        @endif
                        <ul class="nav nav-tabs nav-primary" id="pills-warningtab" role="tablist">
                            @foreach ($languages as $language)
                                <li class="nav-item"><a
                                        class="nav-link {{ $language->lang == getLanguageSession() ? 'active' : '' }}"
                                        id="{{ $language->name }}-tab" data-bs-toggle="pill" href="#{{ $language->name }}"
                                        role="tab" aria-controls="{{ $language->name }}"
                                        aria-selected="true">{{ $language->name }}</a></li>
                            @endforeach

                            {{-- <li class="nav-item"><a class="nav-link" id="pills-warningprofile-tab" data-bs-toggle="pill"
                                    href="#pills-warningprofile" role="tab" aria-controls="pills-warningprofile"
                                    aria-selected="false"><i class="icofont icofont-man-in-glasses"></i>Profile</a></li>
                            <li class="nav-item"><a class="nav-link" id="pills-warningcontact-tab" data-bs-toggle="pill"
                                    href="#pills-warningcontact" role="tab" aria-controls="pills-warningcontact"
                                    aria-selected="false"><i class="icofont icofont-contacts"></i>Contact</a></li> --}}
                        </ul>
                        <div class="tab-content" id="pills-warningtabContent">
                            @foreach ($languages as $language)
                                <div class="tab-pane fade show {{ $language->lang == getLanguageSession() ? 'active' : '' }}"
                                    id="{{ $language->name }}" role="tabpanel"
                                    aria-labelledby="{{ $language->name }}-tab">
                                    <div class="row">
                                        @if (hasPermission(['backend-string-generate']))
                                        <div class="col-md-3">
                                            <form method="POST" action="{{ route('admin.backend.language.store') }}">
                                                @csrf
                                                <input type="hidden" value="{{ resource_path('views/backend') }},{{ app_path('Http/Controllers/Admin') }},{{ app_path('Http/Middleware/Admin') }}" name="directory">
                                                <input type="hidden" value="admin_local" name="file_name">
                                                <input type="hidden" value="{{ $language->lang }}" name="lang">
                                                <button type="submit" class="btn btn-success m-t-30"> {{ __('admin_local.Generate String')}}</button>
                                            </form>
                                        </div>
                                        @endif
                                        @if (hasPermission(['backend-string-translate']))
                                        <div class="col-md-3">
                                            <form method="POST" action="{{ route('admin.backend.language.storeTranslateString') }}">
                                                @csrf
                                                <input type="hidden" value="admin_local" name="file_name">
                                                <input type="hidden" value="{{ $language->lang }}" name="lang">
                                                <button type="submit" class="btn btn-dark m-t-30"> {{ __('admin_local.Translate String')}}</button>
                                            </form>
                                        </div>
                                        @endif
                                    </div>
                                    <div class="table-responsive theme-scrollbar mb-0 m-t-30">
                                        <table class="display table-bordered dataTable">
                                            <thead>
                                                <tr>
                                                    <th>{{ __('admin_local.String') }}</th>
                                                    <th>{{ __('admin_local.Traslation') }}</th>
                                                    <th>{{ __('admin_local.Action') }}</th>
                                                </tr>
                                            </thead> 
                                            <tbody>
                                                @php
                                                    $translatedvalue = trans('admin_local', [], $language->lang);
                                                    // dd($translatedvalue);
                                                @endphp
                                                @foreach ($translatedvalue as $key => $value)
                                                    <tr id="{{ $language->lang.str_replace(' ','_',str_replace('.','',$key)) }}">
                                                        <td>{{ $key }}</td>
                                                        <td>{{ $value }}</td>
                                                        <td class="text-center">
                                                            @if (hasPermission(['backend-string-update']))
                                                            <button id="edit_button" data-key="{{ $key }}" data-value="{{ $value }}" data-lang_code="{{ $language->lang }}" data-filename="admin_local" class="btn btn-danger px-2 py-1" data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-string-modal">
                                                                <i class="fa fa-pencil-square-o"></i> 
                                                            </button>
                                                            @else
                                                            <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                            @endif
                                                        </td>
                                                    </tr>
                                                @endforeach

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endforeach

                        </div>

                    </div>
                </div>
            </div>

        </div>
        <!-- Row -->
    </div>
@endsection
@push('js')
    <script src="{{ asset('public/admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('public/admin/assets/js/select2/select2.full.min.js') }}"></script>
    <script>
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            dropdownParent: $('#add-language-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-language-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        // var oTable = $("#basic-1").DataTable();
        $('.dataTable').each(function(idx, val) {
            $(this).DataTable({
                "orderCellsTop": true
            });
        })

        var form_url = "{{ route('admin.backend.language.store') }}";
        var updating = "{{ __('admin_local.Updating') }}"
        var update_btn = "{{ __('admin_local.Update') }}"
    </script>
    <script src="{{ asset('public/admin/custom/language/admin_localization.js') }}"></script>

    <script>
        function invalidApiKey(x) {
            $.notify(
                '<i class="fa fa-close"></i><strong> &nbsp;&nbsp;'+x+'</strong>', {
                    type: 'danger',
                    allow_dismiss: true,
                    delay: 3000,
                    showProgressbar: true,
                    timer: 300,
                    placement: {
                        from: 'bottom',
                        align: 'center'
                    },
                    animate: {
                        enter: 'animated zoomInUp',
                        exit: 'animated zoomOutDown'
                    }
                });
        };
        function successTranslate(x) {
            $.notify(
                '<i class="fa fa-check-square-o"></i><strong> &nbsp;&nbsp;'+x+'</strong>', {
                    type: 'success',
                    allow_dismiss: true,
                    delay: 3000,
                    showProgressbar: true,
                    timer: 300,
                    placement: {
                        from: 'top',
                        align: 'right'
                    },
                    animate: {
                        enter: 'animated bounceIn',
                        exit: 'animated bounceDown'
                    }
                });
        };
    </script>
    @if(Session::has('no_api_key'))
    <script>
        $(document).ready(function(){
            invalidApiKey('{{ session()->get("no_api_key") }}');
        });
    </script>
    @endif
    @if(Session::has('success_translate'))
    <script>
        $(document).ready(function(){
            successTranslate('{{ session()->get("success_translate") }}');
        });
    </script>
    @endif
@endpush
