@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Hostels') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset(env('ASSET_DIRECTORY','public').'/'.'admin/assets/css/custom.css') }}">
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
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.Service Types') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Booking') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Service Types') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="add-service-type-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add Service Type') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form method="POSt" action="{{ route('admin.service-type.store') }}" ienctype="multipart/form-data">
                        @csrf
                        <div class="row">

                            <div class="col-lg-6 mt-2">
                                <label for="service_code"><strong>{{ __('admin_local.Service Code') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="service_code"
                                    id="service_code" required>
                                <span class="text-danger err-mgs"></span>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <label for="service_name"><strong>{{ __('admin_local.Service Name') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="service_name"
                                    id="service_name" required>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="service_type"><strong>{{ __('admin_local.Service Type') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="service_type"
                                    id="service_type" required>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="room_name"><strong>{{ __('admin_local.Room Type') }}
                                        *</strong></label>
                                <select class="form-control" name="room_type" id="room_type" required>
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="AC">{{ __('admin_local.AC') }}</option>
                                    <option value="NON-AC">{{ __('admin_local.NON-AC') }}</option>
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="hostel_phone"><strong>{{ __('admin_local.Charge') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="charge"
                                    id="charge" required>
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

    {{-- Add User Modal End --}}

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="edit-service-type-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit Service Type') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form id="edit_service_type_form" action="{{ route('admin.service-type.update',1) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="service_id" name="service_id" value="">
                        <div class="row">

                            <div class="col-lg-6 mt-2">
                                <label for="service_code"><strong>{{ __('admin_local.Service Code') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="service_code"
                                    id="service_code" required>
                                <span class="text-danger err-mgs"></span>
                            </div>

                            <div class="col-lg-6 mt-2">
                                <label for="service_name"><strong>{{ __('admin_local.Service Name') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="service_name"
                                    id="service_name" required>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="service_type"><strong>{{ __('admin_local.Service Type') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="service_type"
                                    id="service_type" required>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="room_name"><strong>{{ __('admin_local.Room Type') }}
                                        *</strong></label>
                                <select class="form-control" name="room_type" id="room_type" required>
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="AC">{{ __('admin_local.AC') }}</option>
                                    <option value="NON-AC">{{ __('admin_local.NON-AC') }}</option>
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <label for="hostel_phone"><strong>{{ __('admin_local.Charge') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="charge"
                                    id="charge" required>
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

    {{-- Add User Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Service Types') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['service-type-create']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                        data-bs-target="#add-service-type-modal">+ {{ __('admin_local.Add Service Type') }}</button>
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Service Code') }}</th>
                                        <th>{{ __('admin_local.Service Type') }}</th>
                                        <th>{{ __('admin_local.Service Name') }}</th>
                                        <th>{{ __('admin_local.Room Type') }}</th>
                                        <th>{{ __('admin_local.Charge') }}</th>
                                        <th>{{ __('admin_local.Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($servicetypes as $servicetype)

                                        <tr id="trid-{{ $servicetype->id }}"
                                            data-id="{{ $servicetype->id }}">
                                            <td>{{ $servicetype->service_code }}</td>
                                            <td>{{ $servicetype->service_type }}</td>
                                            <td>{{ $servicetype->service_name }}</td>
                                            <td>{{ $servicetype->room_type }}</td>
                                            <td>{{ $servicetype->charge }}</td>
                                            <td class="text-center">
                                                @if (hasPermission(['service-type-update']))
                                                    <span
                                                        class="mx-2">{{ $servicetype->status == 0 ? 'Inactive' : 'Active' }}</span><input
                                                        data-status="{{ $servicetype->status == 0 ? 1 : 0 }}"
                                                        id="status_change" type="checkbox" data-toggle="switchery"
                                                        data-color="green" data-secondary-color="red" data-size="small"
                                                        {{ $servicetype->status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (hasPermission(['service-type-update','service-type-delete']))
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content">
                                                        @if (hasPermission(['service-type-update']))
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-service-type-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                        @endif
                                                        @if (hasPermission(['service-type-delete']))
                                                        <a class="text-danger" id="delete_button"
                                                            style="cursor: pointer;"><i class="fa fa-trash mx-1"></i>
                                                            {{ __('admin_local.Delete') }}</a>
                                                        @endif
                                                    </div>
                                                </div>
                                                @else
                                                <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @csrf
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row -->
    </div>
@endsection
@push('js')
    <script src="{{ asset(env('ASSET_DIRECTORY','public').'/'.'admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY','public').'/'.'admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY','public').'/'.'admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY','public').'/'.'admin/assets/js/select2/select2.full.min.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/assets/js/select2/select2-custom.js') }}"></script> --}}
    <script>
        $('[data-toggle="switchery"]').each(function(idx, obj) {
            new Switchery($(this)[0], $(this).data());
        });
        $('.js-example-basic-single').select2({
            dropdownParent: $('#add-brand-modal')
        });
        $('.js-example-basic-single1').select2({
            dropdownParent: $('#edit-brand-modal')
        });
        $(document).on('select2:open', () => {
            document.querySelector('.select2-search__field').focus();
        });
        var oTable = $("#basic-1").DataTable({
            "language": {
                "decimal": "",
                "emptyTable": "{{ __('admin_local.No size available in table') }}",
                "info": "Showing _START_ to _END_ of _TOTAL_ entries",
                "infoEmpty": "Showing 0 to 0 of 0 entries",
                "infoFiltered": "(filtered from _MAX_ total entries)",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "Show _MENU_ entries",
                "loadingRecords": "Loading...",
                "processing": "",
                "search": "Search:",
                "zeroRecords": "No matching records found",
                "paginate": {
                    "first": "First",
                    "last": "Last",
                    "next": "Next",
                    "previous": "Previous"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            }
        });

        var form_url = "{{ route('admin.hostel.store') }}";
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
        var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;


        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this size data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = `{{ __('admin_local.No file') }}`;
        var base_url = `{{ baseUrl() }}`;
        var translate_url = `{{ route('admin.translateString') }}`;


    </script>
    <script src="{{ asset(env('ASSET_DIRECTORY','public').'/'.'admin/custom/booking/service_types.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
