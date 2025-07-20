@extends('backend.shared.layouts.auth')
@push('title')
    Login
@endpush
@section('content')
<div class="row m-0">
    <div class="col-12 p-0">
        <div class="login-card" style="background-image: url({{ asset('public/admin/images/login-bg3.jpg') }});background-repeat:no-repeat;background-size: 100% 100%;">
            <div style="width:100%">
                {{-- <div><a class="logo" href="index.html"><img class="img-fluid for-light" src="{{ asset('public/admin/assets/images/logo/logo2.png') }}" alt="looginpage"></a></div> --}}
                <div class="login-main" id="loginform">
                   
                    <form class="theme-form" method="POST" action="{{ route('admin.login') }}">
                        @csrf
                        <h4 class="text-center">{{ __('admin_local.Log In') }}</h4>
                        {{-- <p class="text-center">Enter your email & password to login</p> --}}
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
                            <label class="col-form-label"><strong>{{ __('admin_local.Email / Phone / Username') }}</strong></label>
                            <input class="form-control" id="user_email" name="user_credential" type="text" placeholder="Enhter Your Email or Phone or Username"  value="{{ old('user_credential') }}"/>
                            @error('user_credential')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label class="col-form-label"><strong>{{ __('admin_local.User Password') }}</strong></label>
                            <div class="form-input position-relative">
                                <input class="form-control" id="user_password" name="user_password" type="password" >
                                <div class="show-hide"><span class="show"> </span></div>
                            </div>
                            @error('user_password')
                                <span class="text-danger">{{ $message }}</span>
                            @enderror
                        </div>
                        <div class="form-group mb-0">
                            <div class="checkbox p-0">
                                <input id="checkbox1" type="checkbox">
                                <label class="text-muted" for="checkbox1">{{ __('admin_local.Remember password') }}</label>
                            </div>
                            <div class="d-flex">
                                <div class="ms-auto">
                                    <a href="javascript:void(0)" id="to-recover" class="link font-weight-medium"><i
                                        class="fa fa-lock me-1"></i> {{ __('admin_local.Forgot Password') }} ?</a>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button class=" btn btn-info d-block w-100 waves-effect waves-light" type="submit">
                                    {{ __('admin_local.Log In') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="login-main" id="recoverform" style="display: none;">
                    <form class="col-12" action="" id="forget_password_form">
                        @csrf
                        <!-- email -->
                        <h4 class="text-center">{{ __('admin_local.Forget Password') }}</h4>
                        <div class="form-group row">
                            <div class="col-12">
                                <label for="forget_email">{{ __('admin_local.User Email') }}</label>
                                <input class="form-control" id="email" name="email" type="email" required="" />
                                <span class="text-danger err-mgs"></span>
                            </div>
                        </div>

                        <!-- pwd -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <button class="btn d-block w-100 btn-primary text-uppercase" type="submit" name="action">
                                    {{ __('admin_local.Reset') }}
                                </button>
                                <div class="text-danger countdown"></div>
                            </div>
                            <div class="form-group mt-2">
                                <div class="d-flex">
                                    <div class="ms-auto">
                                        <a href="javascript:void(0)" id="to-sign-in" class="link font-weight-medium">
                                            {{ __('admin_local.Already Have An Account') }} ?</a>
                                    </div>
                                </div>
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
        $("#to-recover").on("click", function() {
            $("#loginform").slideUp();
            $("#recoverform").fadeIn();
        });
        $("#to-sign-in").on("click", function() {
            $("#recoverform").slideUp();
            $("#loginform").fadeIn();
        });

        var reset = '{{ __("admin_local.Reset") }}';
        var wait_mgs = '{{ __("admin_local.Please Wait") }}';
    </script>
    <script src="{{ asset('public/admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script src="{{ asset('public/admin/custom/user/auth.js') }}"></script>
@endpush
