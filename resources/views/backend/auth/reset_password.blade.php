@extends('backend.shared.layouts.auth')
@push('title')
    Login
@endpush
@section('content')
<div class="row m-0">
    <div class="col-12 p-0">
        <div class="login-card" style="background-image: url({{ asset('admin/images/login-bg.jpg') }});background-repeat:no-repeat;background-size: 100% 100%;">
            <div style="width:100%">
                {{-- <div><a class="logo" href="index.html"><img class="img-fluid for-light" src="{{ asset('admin/assets/images/logo/logo2.png') }}" alt="looginpage"></a></div> --}}
                <div class="login-main" id="loginform">
                   
                    <form class="theme-form" method="POST" action="{{ route('admin.reset_password') }}">
                        @csrf
                        <h4 class="text-center">{{ __('admin_local.Password Reset') }}</h4>
                       
                        @if (Session::has('invalid_login'))
                            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show"
                                role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <strong>{{ __('admin_local.Invalid Email or Password') }}</strong>
                            </div>
                        @endif
                        @if (Session::has('login_first'))
                            <div class="alert alert-danger alert-dismissible bg-danger text-white border-0 fade show"
                                role="alert">
                                <button type="button" class="btn-close" data-bs-dismiss="alert"
                                    aria-label="Close"></button>
                                <strong>{{ Session::get('login_first') }}</strong>
                            </div>
                        @endif
                        <div class="form-group">
                            <label class="col-form-label"><strong>{{ __('admin_local.Email') }}</strong></label>
                            <input class="form-control" id="email" name="email" type="text" placeholder="Enter Your Email "  value="{{ old('email') }}"/>
                            @error('email')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><strong>{{ __('admin_local.Reset Code') }}</strong></label>
                            <input class="form-control" id="reset_code" name="reset_code" type="text" placeholder="Enter Your Reset Code "  value="{{ old('reset_code') }}"/>
                            @error('reset_code')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><strong>{{ __('admin_local.New Password') }}</strong></label>
                            <div class="form-input position-relative">
                                <input class="form-control" id="new_password" name="new_password" type="password" >
                                <div class="show-hide"><span class="show"> </span></div>
                            </div>
                            @error('new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><strong>{{ __('admin_local.Re-type New Password') }}</strong></label>
                            <div class="form-input position-relative">
                                <input class="form-control" id="retype_new_password" name="retype_new_password" type="password" >
                                <div class="show-hide"><span class="show"> </span></div>
                            </div>
                            @error('retype_new_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-0">
                            <div class="text-end mt-3">
                                <button class=" btn btn-info d-block w-100 waves-effect waves-light" type="submit">
                                    {{ __('admin_local.Reset Password') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                
            </div>
        </div>
    </div>
</div>
@endsection
@push('js')
    <script>
        var reset = '{{ __("admin_local.Reset") }}';
        var wait_mgs = '{{ __("admin_local.Please Wait") }}';
    </script>
    <script src="{{ asset('admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('admin/custom/user/auth.js') }}"></script>
@endpush
