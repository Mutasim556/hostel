@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Admin Profile') }}
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
                    <h3>{{ __('admin_local.My Profile') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.html"><i data-feather="user"></i></a></li>
                        <li class="breadcrumb-item">{{ __('admin_local.My Profile') }}</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
    <!-- Container-fluid starts-->
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-5 mx-auto">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="text-center">{{ __('admin_local.Profile Details') }}</h4>
                        <h4 style="text-align: right"><i data-toggle="tooltip" data-placement="bottom"
                                title="Edit basic info." class="fa fa-edit float-right" id="trigger_user_basic_edit"
                                style="font-size:21px;cursor:pointer"></i></h4>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-lg-4">
                                <label for=""><strong>{{ __('admin_local.Name') }}</strong></label>
                            </div>
                            <div class="col-lg-8">
                                <span for="">{{ $profile_info->name }}</span>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for=""
                                    class="lebelcolor"><strong>{{ __('admin_local.Email') }}</strong></label>
                            </div>
                            <div class="col-lg-8">
                                <label for="">{{ $profile_info->email }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for=""
                                    class="lebelcolor"><strong>{{ __('admin_local.Phone') }}</strong></label>
                            </div>
                            <div class="col-lg-8">
                                <label for="">{{ $profile_info->phone }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for=""
                                    class="lebelcolor"><strong>{{ __('admin_local.Username') }}</strong></label>
                            </div>
                            <div class="col-lg-8">
                                <label for="">{{ $profile_info->username }}</label>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-4">
                                <label for=""
                                    class="lebelcolor"><strong>{{ __('admin_local.My role') }}</strong></label>
                            </div>
                            <div class="col-lg-8">
                                <label
                                    for="">{{ $profile_info->role == 1 ? 'Admin' : ($profile_info->role == 2 ? 'Supervisor' : ($profile_info->role == 2 ? 'Editor' : ($profile_info->role == 4 ? 'Customer' : ''))) }}</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body" id="user_basic_edit" style="display: none">
                        <form class="theme-form" action="" id="update_basic_info_form" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for=""
                                        class="lebelcolor"><strong>{{ __('admin_local.Name') }}</strong></label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" value="{{ $profile_info->name }}"
                                        name="user_name">
                                    <label for="user_name"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for=""
                                        class="lebelcolor"><strong>{{ __('admin_local.Email') }}</strong></label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" value="{{ $profile_info->email }}"
                                        name="user_email">
                                    <label for="user_email"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for=""
                                        class="lebelcolor"><strong>{{ __('admin_local.Phone') }}</strong></label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" value="{{ $profile_info->phone }}"
                                        name="user_phone">
                                    <label for="user_phone"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-4">
                                    <label for="" class="lebelcolor"><strong>{{ _('Username') }}</strong></label>
                                </div>
                                <div class="col-lg-8">
                                    <input type="text" class="form-control" value="{{ $profile_info->username }}"
                                        name="username">
                                    <label for="username"></label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-lg-12">
                                    <button type="submit" id="update_basic_info_button"
                                        class="btn btn-info form-control">{{ __('admin_local.Update Profile Info') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="col-sm-5 mx-auto">
                <div class="card">
                    <div class="card-header pb-0">
                        <h4 class="text-center">Change Password</h4>

                    </div>
                    <div class="card-body">
                        <form class="theme-form" action="" id="change_password_form" method="POST"
                            enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-4 py-0 my-0 ">
                                    <label for="" class="lebelcolor">{{ __('admin_local.Old Password') }}</label>
                                </div>
                                <div class="input-group col-md-8 mb-3">
                                    <input type="password" class="form-control" name="old_password" id="old_password"
                                        placeholder="old password" aria-label="Recipient's username"
                                        aria-describedby="basic-addon4">
                                    <span style="border: 1px solid gray" class="input-group-text " id="basic-addon4"
                                        onclick="password_status('old_password','basic-addon4')"><i
                                            class="fa fa-eye"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 my-0">
                                    <label for="" class="lebelcolor">{{ __('admin_local.New Password') }}</label>
                                </div>
                                <div class="input-group col-md-8 mb-3">
                                    <input type="password" class="form-control" placeholder="new password"
                                        name="new_password" id="new_password" aria-label="Recipient's username"
                                        aria-describedby="basic-addon3">
                                    <span style="border: 1px solid gray" class="input-group-text" id="basic-addon3"
                                        onclick="password_status('new_password','basic-addon3')"><i
                                            class="fa fa-eye"></i></span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-4 my-0">
                                    <label for=""
                                        class="lebelcolor">{{ __('admin_local.Re-type Password') }}</label>
                                </div>
                                <div class="input-group col-md-8 mb-3">
                                    <input type="password" class="form-control" name="retype_password"
                                        id="retype_password" placeholder="retype password"
                                        aria-label="Recipient's username" aria-describedby="basic-addon2">
                                    <span style="border: 1px solid gray" class="input-group-text" id="basic-addon2"
                                        onclick="password_status('retype_password','basic-addon2')"><i
                                            class="fa fa-eye"></i></span>
                                </div>
                            </div>

                            <button type="submit" id="update_password_button"
                                class="btn btn-success form-control">{{ __('admin_local.Change Password') }}</button>
                        </form>
                        <script>
                            function password_status(x, y) {
                                var status = document.getElementById(x).type;
                                if (status == 'password') {
                                    document.getElementById(x).type = 'text';
                                    document.getElementById(y).classList.add('text-danger');
                                } else {
                                    document.getElementById(x).type = 'password';
                                    document.getElementById(y).classList.remove('text-danger');
                                }
                            }
                        </script>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection


@push('js')
    <script src="{{ asset('public/admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset('public/admin/custom/admin_profile.js') }}"></script>
@endpush
