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
                    <h3>{{ __('admin_local.Hostel List') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Hostels') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Hostel List') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Add User Modal Start --}}

    <div class="modal fade" id="add-hostel-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add Hostel') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form method="POSt" action="" id="add_hostel_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="hostel_name"><strong>{{ __('admin_local.Hostel Name') }} ({{ __('admin_local.Default') }})
                                        *</strong></label>
                                <input type="text" class="form-control" name="hostel_name"
                                    id="hostel_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @foreach (getLangs() as $lang)
                            <div class="col-lg-6 mt-2">
                                <label for="hostel_name"><strong>{{ __('admin_local.Hostel Name') }} ( {{ $lang->name }} )
                                    *</strong></label>
                                <input type="text" class="form-control" name="hostel_name_{{ $lang->lang }}"
                                    id="hostel_name_{{ $lang->lang }}">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @endforeach
                            <div class="col-lg-3 mt-2">
                                <input type="checkbox" name="translate_autometic" id="translate_autometic" > &nbsp;
                                <label for="hostel_name"><strong>{{ __('admin_local.Translate Autometic') }}</strong></label>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="hostel_name"><strong>{{ __('admin_local.Hostel Type') }}
                                        *</strong></label>
                                <select class="form-control" name="hostel_type" id="hostel_type">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="Boys">{{ __('admin_local.Boys') }}</option>
                                    <option value="Girls">{{ __('admin_local.Girls') }}</option>
                                    <option value="All">{{ __('admin_local.All') }}</option>
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="hostel_phone"><strong>{{ __('admin_local.Hostel Phone') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="hostel_phone"
                                    id="hostel_phone">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="hostel_email"><strong>{{ __('admin_local.Hostel Email') }}
                                        </strong></label>
                                <input type="text" class="form-control" name="hostel_email"
                                    id="hostel_email">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="hostel_address"><strong>{{ __('admin_local.Hostel Address') }}
                                        </strong></label>
                                <textarea class="form-control" name="hostel_address"
                                    id="hostel_address"></textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="concern_person_name"><strong>{{ __('admin_local.Concern Person Name') }} *
                                        </strong></label>
                                <input type="text" class="form-control" name="concern_person_name"
                                    id="concern_person_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="concern_person_phone"><strong>{{ __('admin_local.Concern Person Phone') }} *
                                        </strong></label>
                                <input type="text" class="form-control" name="concern_person_phone"
                                    id="concern_person_phone">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="concern_person_email"><strong>{{ __('admin_local.Concern Person Email') }}
                                        </strong></label>
                                <input type="text" class="form-control" name="concern_person_email"
                                    id="concern_person_email">
                                <span class="text-danger err-mgs"></span>
                            </div>

                        </div>
                        <div class="row mb-4">
                            <div class="col-lg-4 mt-2">
                                <input type="checkbox" name="has_multiple_building" id="has_multiple_building" > &nbsp;
                                <label for="hostel_name"><strong>{{ __('admin_local.Has multiple building ?') }}</strong></label>
                            </div>
                            <div class="col-lg-4 mt-2">
                                <button class="btn btn-info" type="button" id="add_building_btn" style="display:none">+{{ __('admin_local.Add Building') }}</button>
                            </div>
                        </div>
                        <div class="row mb-3" id="append_building_div" >

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

    <div class="modal fade" id="edit-hostel-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit Hostel') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form id="edit_hostel_form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="hostel_id" name="hostel_id" value="">
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="hostel_name"><strong>{{ __('admin_local.Hostel Name') }} ({{ __('admin_local.Default') }})
                                        *</strong></label>
                                <input type="text" class="form-control" name="hostel_name"
                                    id="hostel_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @foreach (getLangs() as $lang)
                            <div class="col-lg-6 mt-2">
                                <label for="hostel_name"><strong>{{ __('admin_local.Hostel Name') }} ( {{ $lang->name }} )
                                    *</strong></label>
                                <input type="text" class="form-control" name="hostel_name_{{ $lang->lang }}"
                                    id="hostel_name_{{ $lang->lang }}">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @endforeach
                            <div class="col-lg-3 mt-2">
                                <input type="checkbox" name="translate_autometic" id="translate_autometic" > &nbsp;
                                <label for="hostel_name"><strong>{{ __('admin_local.Translate Autometic') }}</strong></label>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="hostel_name"><strong>{{ __('admin_local.Hostel Type') }}
                                        *</strong></label>
                                <select class="form-control" name="hostel_type" id="hostel_type">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="Boys">{{ __('admin_local.Boys') }}</option>
                                    <option value="Girls">{{ __('admin_local.Girls') }}</option>
                                    <option value="All">{{ __('admin_local.All') }}</option>
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="hostel_phone"><strong>{{ __('admin_local.Hostel Phone') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="hostel_phone"
                                    id="hostel_phone">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="hostel_email"><strong>{{ __('admin_local.Hostel Email') }}
                                        </strong></label>
                                <input type="text" class="form-control" name="hostel_email"
                                    id="hostel_email">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="hostel_address"><strong>{{ __('admin_local.Hostel Address') }}
                                        </strong></label>
                                <textarea class="form-control" name="hostel_address"
                                    id="hostel_address"></textarea>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="concern_person_name"><strong>{{ __('admin_local.Concern Person Name') }}
                                        </strong></label>
                                <input type="text" class="form-control" name="concern_person_name"
                                    id="concern_person_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="concern_person_phone"><strong>{{ __('admin_local.Concern Person Phone') }}
                                        </strong></label>
                                <input type="text" class="form-control" name="concern_person_phone"
                                    id="concern_person_phone">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="concern_person_email"><strong>{{ __('admin_local.Concern Person Email') }}
                                        </strong></label>
                                <input type="text" class="form-control" name="concern_person_email"
                                    id="concern_person_email">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            
                        </div>
                        <div class="row">
                            <div class="col-lg-4 mt-2">
                                <input type="checkbox" name="has_multiple_building" id="has_multiple_building" > &nbsp;
                                <label for="hostel_name"><strong>{{ __('admin_local.Has multiple building ?') }}</strong></label>
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
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Hostel List') }}</h3>
                    </div>

                    <div class="card-body">
                        @if (hasPermission(['hostel-create']))
                            <div class="row mb-3">
                                <div class="col-md-3">
                                    <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                        data-bs-target="#add-hostel-modal">+ {{ __('admin_local.Add Hostel') }}</button>
                                </div>
                            </div>
                        @endif

                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.Hostel Name') }}</th>
                                        <th>{{ __('admin_local.Hostel Type') }}</th>
                                        <th>{{ __('admin_local.Hostel Phone') }}</th>
                                        <th>{{ __('admin_local.Hostel Email') }}</th>
                                        <th>{{ __('admin_local.Hostel Address') }}</th>
                                        <th>{{ __('admin_local.Concern Person Name') }}</th>
                                        <th>{{ __('admin_local.Concern Person Phone') }}</th>
                                        <th>{{ __('admin_local.Concern Person Email') }}</th>
                                        <th>{{ __('admin_local.Status') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($hosteles as $hostel)
                                        <tr id="trid-{{ $hostel->id }}"
                                            data-id="{{ $hostel->id }}">
                                            <td>{{ $hostel->hostel_name }}</td>
                                            <td>{{ $hostel->hostel_type }}</td>
                                            <td>{{ $hostel->hostel_phone }}</td>
                                            <td>{{ $hostel->hostel_email }}</td>
                                            <td>{{ $hostel->hostel_address }}</td>
                                            <td>{{ $hostel->concern_person_name }}</td>
                                            <td>{{ $hostel->concern_person_phone }}</td>
                                            <td>{{ $hostel->concern_person_email }}</td>
                                            <td class="text-center">
                                                @if (hasPermission(['hostel-update']))
                                                    <span
                                                        class="mx-2">{{ $hostel->status == 0 ? 'Inactive' : 'Active' }}</span><input
                                                        data-status="{{ $hostel->status == 0 ? 1 : 0 }}"
                                                        id="status_change" type="checkbox" data-toggle="switchery"
                                                        data-color="green" data-secondary-color="red" data-size="small"
                                                        {{ $hostel->status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                @if (hasPermission(['hostel-update','hostel-delete']))
                                                <div class="dropdown">
                                                    <button
                                                        class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                        <i class="fa fa-angle-down"></i></button>
                                                    <div class="dropdown-content">
                                                        @if (hasPermission(['hostel-update']))
                                                        <a data-bs-toggle="modal" style="cursor: pointer;"
                                                            data-bs-target="#edit-hostel-modal" class="text-primary"
                                                            id="edit_button"><i class=" fa fa-edit mx-1"></i>{{ __('admin_local.Edit') }}</a>
                                                        @endif
                                                        @if (hasPermission(['hostel-delete']))
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

        $(document).on('change','#has_multiple_building',function(){
            if($(this).is(':checked')){
                $('#add_building_btn','#add_hostel_form').show('slow');
                $('#append_building_div','#add_hostel_form').empty().append(`
                   
                    <div class="col-md-4 mb-2">
                        <label for="buiding_number"><strong>{{ __('admin_local.Buiding Number') }} <span id="building_number_counter">1</span>
                                        </strong></label>
                        <input type="text" class="form-control" name="buiding_number[]"
                            id="buiding_number">
                        <span class="text-danger err-mgs"></span>
                    </div>
                `);
            }
        })

        $(document).on('click','#add_hostel_form #add_building_btn',function(){
            var count_div = $('.col-md-4','#add_hostel_form').length;
            // alert(count_div);
            $('#append_building_div','#add_hostel_form').append(`
                <div class="col-md-4">
                    <button type="button" class="btn btn-danger px-1 py-0" id="remove_btn" style="float:right">{{ __('admin_local.Remove') }}</button>
                    <label for="buiding_number"><strong>{{ __('admin_local.Buiding Number') }} <span id="building_number_counter">${count_div+1}</span>
                                    </strong></label>
                    <input type="text" class="form-control" name="buiding_number[]"
                        id="buiding_number">
                    <span class="text-danger err-mgs"></span>
                </div>
            `);
        })

        $(document).on('click','#remove_btn',function(){
            $(this).closest('.col-md-4').remove();
            $('.col-md-4','#add_hostel_form #append_building_div').each(function(key,val){
                $('#building_number_counter',this).empty().append(key+1);
            })
        })
    </script>
    <script src="{{ asset(env('ASSET_DIRECTORY','public').'/'.'admin/custom/hostel/hostel.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
