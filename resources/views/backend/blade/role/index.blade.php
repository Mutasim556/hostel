@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Roles And Permissions') }}
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
    <div class="container-fluid">
        <div class="page-title">
            <div class="row">
                <div class="col-sm-6">
                    <h3>{{ __('admin_local.Roles And Permissions') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Role') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Roles And Permissions') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    {{-- Add role Modal Start --}}

    <div class="modal fade" id="add-role-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Create Role') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="add_role_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="role_name"><strong>{{ __('admin_local.Role Name') }} *</strong></label>
                                <input type="text" class="form-control" name="role_name" id="role_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @foreach ($permissions as $group=>$permission)
                                <div class="col-lg-12 mt-4">
                                    <label for="user_permission">{{ $group }}</label><br>
                                    @foreach ($permission as $item)
                                        <input data-status="" id="permission-switch" type="checkbox" data-toggle="switchery" data-color="green" data-secondary-color="red" data-size="small" value="{{ $item->name }}" name="permissions[]"/>
                                        <span class="mx-2">{{ $item->name }}</span>
                                    @endforeach
                                </div>
                            @endforeach
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

    {{-- Add role Modal End --}}

    {{-- Add role Modal Start --}}

    <div class="modal fade" id="edit-role-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit Role') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="edit_role_form">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="role_id" name="role_id" value="">
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="role_name"><strong>{{ __('admin_local.Role Name') }} *</strong></label>
                                <input type="text" class="form-control" name="role_name" id="role_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div id="edit_permission">
                               <span>{{ __('admin_local.Getting Permissons') }} ...... <i class="fa fa-spinner fa-spin" ></i></span>
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

    {{-- Add role Modal End --}}

    {{-- Add permission to specific user Modal start--}}

    <div class="modal fade" id="add-specific-user-permission-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add Specific Permission') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form action="" id="add_specific_user_permission_form">
                        @csrf
                        <div class="row">
                            <div class="col-lg-12 mt-2">
                                <label for="user_id"><strong>{{ __('admin_local.Select User') }} *</strong></label>
                                <select class="form-control js-example-basic-single3" name="user_id" id="user_id">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    @foreach ($users as $user)
                                        @php
                                            if($user->getRoleNames()->first()=='Super Admin'){
                                                continue;
                                            }
                                        @endphp
                                        <option value="{{ $user->id }}">{{ $user->name }} ( {{ $user->email }} )</option>
                                    @endforeach
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            
                        </div>
                        <div class="row" id="role_and_permission">

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

    {{-- permission to specific user Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-11 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Roles And Permissions') }}</h3>
                    </div>

                    <div class="card-body">
                        
                        <div class="row mb-3">
                            @if (hasPermission(['role-permission-create']))
                            <div class="col-md-3">
                                <button class="btn btn-success" type="btn" data-bs-toggle="modal"
                                    data-bs-target="#add-role-modal">+  {{ __('admin_local.Add Role')}}</button>
                            </div>
                            @endif
                            @if (hasPermission(['specific-permission-create']))
                            <div class="col-md-9 offset-md-3">
                                <button class="btn btn-outline-info" style="float:right" type="btn" data-bs-toggle="modal"
                                    data-bs-target="#add-specific-user-permission-modal">+  {{ __('admin_local.Give Permission To Specific User')}}</button>
                            </div>
                            @endif
                        </div> 
                        
                        <div class="table-responsive theme-scrollbar">
                            <table id="basic-1" class="display table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ __('admin_local.ID') }}</th>
                                        <th>{{ __('admin_local.Role') }}</th>
                                        <th>{{ __('admin_local.Permission') }}</th>
                                        <th>{{ __('admin_local.Action') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr id="tr-{{ $role->id }}" data-id="{{ $role->id }}">
                                            <td>{{ $role->id }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @if ($role->name==='Super Admin')
                                                    <span class="badge badge-info">{{ __('admin_local.All Permission') }}</span>
                                                @else
                                                    @if (count($role->permissions)<1)
                                                    <span class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
                                                    @endif
                                                    @foreach ($role->permissions as $permission)
                                                        <span class="badge badge-success">{{ $permission->name }}</span>
                                                    @endforeach
                                                @endif
                                               
                                            </td>
                                            <td>
                                                @if ($role->name==='Super Admin')
                                                    <span class="badge badge-danger">{{ __('admin_local.No Action') }}</span>
                                                @else
                                                    @if (hasPermission(['role-permission-update']))
                                                        <button id="edit_button" data-bs-toggle="modal" style="cursor: pointer;" data-bs-target="#edit-role-modal" class="btn btn-primary px-2 py-1"><i class="fa fa-pencil-square-o"></i></button>
                                                    @endif
                                                    @if (hasPermission(['role-permission-delete']))
                                                        <button id="delete_button" class="btn btn-danger px-2 py-1"><i class="fa fa-trash"></i></button>
                                                    @endif
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
            columnDefs: [{ width: 20, targets: 0 },{ width: 80, targets: 1 },{ width: 60, targets: 3 }],
        });

        var form_url = "{{ route('admin.role.store') }}";
        var getting_permission = `<span>{{ __('admin_local.Getting Permissons') }} ...... <i class="fa fa-spinner fa-spin" ></i></span>`;
        var submit_btn_after = `{{ __('admin_local.Submitting') }}`;
        var submit_btn_before = `{{ __('admin_local.Submit') }}`;
    </script>
    <script src="{{ asset('public/admin/custom/role/role_list.js') }}"></script>
@endpush
