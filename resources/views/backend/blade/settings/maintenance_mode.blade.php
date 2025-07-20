@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Maintenance Mood') }}
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
    {{-- Turn On Modal Start --}}

    <div class="modal fade" id="turn-on-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Turn On Maintenance Mode') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger">
                    <i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="turn_on_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="secret_code"><strong>{{ __('admin_local.Secret Code') }} *</strong></label>
                                <input type="text" class="form-control" name="secret_code" id="secret_code" readonly>
                                <span class="text-danger err-mgs"></span>
                            </div>

                            <div class="col-lg-12 mt-2">
                                <label for="message"><strong>{{ __('admin_local.Message') }} *</strong></label>
                                <textarea class="form-control" name="message" id="message" rows="2">Hello</textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="message"><strong>{{ __('admin_local.Mail Option') }} *</strong></label><br>
                                <input type="radio" value="0" name="mail_option" checked> Mail to all admins
                                &nbsp;&nbsp;&nbsp;
                                <input type="radio" value="1" name="mail_option"> Mail to super admin
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="mail_subject"><strong>{{ __('admin_local.Mail Subject') }} *</strong></label>
                                <input type="text" class="form-control" name="mail_subject" id="mail_subject"
                                    value="Maintance Mode Mail">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-12 mt-2">
                                <label for="mail_body"><strong>{{ __('admin_local.Mail Body') }} *</strong></label>
                                <textarea class="form-control" name="mail_body" id="mail_body" rows="2">Scheduled maintenance of IT systems is an almost unavoidable part of life. However, your IT systems are the backbone of your organization, and employees rely on them to be able to do their work. By appropriately communicating with employees ahead of time, you can help make the process less painful for everyone involved. And that is why you need a scheduled maintenance email template.</textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                        </div>

                        <div class="row mt-4 mb-2">
                            <div class="form-group col-lg-12">

                                <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                    data-bs-dismiss="modal" style="float: right"
                                    type="button">{{ __('admin_local.Close') }}</button>
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

    {{-- Turn On Modal End --}}


    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-8 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Maintenance Mode') }}</h3>
                    </div>
                    <div class="card-body my-2">
                        <div class="col-xl-12 box-col-12">
                            <div class="widget-joins card widget-arrow">
                                <div class="card-body">
                                    <div class="row gy-4">
                                        @if (!app()->isDownForMaintenance())
                                            <div class="col-sm-6 mx-auto">
                                                <div class="widget-card bg-success">
                                                    <div class="d-flex align-self-center">
                                                        <div class="widget-icon bg-light flex-shrink-0"><i
                                                                class="icofont icofont-arrow-up font-success"></i></div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="text-light">
                                                                {{ __('admin_local.Maintenance mode is off') }}</h6>
                                                            <button id="turn_on_btn" data-bs-toggle="modal"
                                                                data-bs-target="#turn-on-modal"
                                                                class="btn btn-danger">{{ __('admin_local.Turn On') }}</button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-sm-6 mx-auto">
                                                <div class="widget-card bg-danger">
                                                    <div class="d-flex align-self-center">
                                                        <div class="widget-icon bg-light flex-shrink-0"><i
                                                                class="icofont icofont-arrow-down font-danger"></i></div>
                                                        <div class="flex-grow-1">
                                                            <h6 class="text-light">
                                                                {{ __('admin_local.Maintenance mode is on') }}</h6>
                                                            <a href="{{ route('admin.settings.server.up') }}"
                                                                id="turn_off_btn"
                                                                class="btn btn-success">{{ __('admin_local.Turn Off') }}</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-xl-12">
                            <h4 class="modal-title text-center mb-3" id="myLargeModalLabel">
                                {{ __('admin_local.Maintenance Report') }}
                            </h4>
                            @if (!app()->isDownForMaintenance() && $maintenances->count()>0)
                                <h4 class="modal-title mb-3" id="myLargeModalLabel1">
                                    <button type="button" id="delete_all_btn"
                                        class="btn btn-danger py-1">{{ __('admin_local.Delete All') }}</button>
                                </h4>
                            @endif

                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Created By') }}</th>
                                        <th>{{ __('admin_local.Secret Key') }}</th>
                                        <th>{{ __('admin_local.Creation Time') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($maintenances as $key => $maintenance)
                                        <tr class="{{ $key == 0 ? 'bg-info' : '' }}">
                                            <td class="{{ $key == 0 ? 'bg-info' : '' }}">{{ $maintenance->admin->name }}
                                                (Id :{{ $maintenance->admin->id }})
                                            </td>
                                            <td>{{ $maintenance->secret_code }}</td>
                                            <td>{{ date('Y-m-d h:i:s A', strtotime($maintenance->created_at)) }}</td>
                                            <td>
                                                @if (app()->isDownForMaintenance() && $key != 0)
                                                    <button class="btn btn-danger px-1 py-0" type="button"
                                                        id="delete_button" data-id="{{ $maintenance->id }}"><i
                                                            class="fa fa-trash"></i></button>
                                                @elseif(!app()->isDownForMaintenance())
                                                    <button class="btn btn-danger px-1 py-0" type="button"
                                                        id="delete_button" data-id="{{ $maintenance->id }}"><i
                                                            class="fa fa-trash"></i></button>
                                                @else
                                                    <span
                                                        class="badge badge-danger">{{ __("admin_local.Can't delete") }}</span>
                                                @endif

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
            dropdownParent: $('#add-role-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-role-modal')
        });
        $('.js-example-basic-single3').select2({
            dropdownParent: $('#add-specific-user-permission-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable({
            columnDefs: [{
                width: 100,
                targets: 0
            }, {
                width: 100,
                targets: 2
            }, {
                width: 60,
                targets: 3
            }],

        });

        var form_url_on = "{{ route('admin.settings.server.maintenanceModeOn') }}";
        var getting_permission =
            `<span>{{ __('admin_local.Getting Permissons') }} ...... <i class="fa fa-spinner fa-spin" ></i></span>`;
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var confirm_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var confirm_swal_text = `{{ __('admin_local.Once trun on, you will not be able to visit this site') }}`;
        var confirm_swal_cancel_text = `{{ __('admin_local.Turn on request canceld successfully') }}`;

        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this maintenance data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
    </script>
    <script src="{{ asset('public/admin/custom/settings/maintenance.js') }}"></script>
@endpush
