@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Cancel Policies') }}
@endpush
@push('css')
    <link rel="stylesheet" href="{{ asset(env('ASSET_DIRECTORY', 'public') . '/' . 'admin/assets/css/custom.css') }}">
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
                    <h3>{{ __('admin_local.Cancel Policies') }}</h3>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <a href="javascript:void(0)">{{ __('admin_local.Booking') }}</a>
                        </li>
                        <li class="breadcrumb-item active">{{ __('admin_local.Cancel Policies') }}</li>
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
                    <div class="card-body">
                        <form action="{{ route('admin.cancelPolicy.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <h4 class="text-center my-3"><u>{{ __("admin_local.After Booking Started") }}</u></h4>
                                <div class="col-lg-3">
                                    <input type="checkbox" name="has_policy_after_booking_started" id="has_policy_after_booking_started" {{ $rpolicies->has_policy_after_booking_started==1?'checked':'' }}> {{ __('admin_local.Has policy after booking started ?') }}
                                    <label for=""></label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Deduction') }}</label>
                                    <input type="text" name="started_deduction" id="started_deduction" class="form-control" value="{{ $rpolicies->started_deduction>0?$rpolicies->started_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Service Charge Deduction') }}</label>
                                    <input type="text" name="started_service_charge_deduction" id="started_service_charge_deduction" class="form-control" value="{{ $rpolicies->started_service_charge_deduction>0?$rpolicies->started_service_charge_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Maximum Refund') }}</label>
                                    <input type="text" name="started_maximum_refund" id="started_maximum_refund" class="form-control" value="{{ $rpolicies->started_maximum_refund>0?$rpolicies->started_maximum_refund:0 }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h4 class="text-center my-3"><u>{{ __("admin_local.One Day Before Booking") }}</u></h4>
                                <div class="col-lg-3">
                                    <input type="checkbox"
                                        name="has_policy_before_one_day" id="has_policy_before_one_day" {{ $rpolicies->has_policy_before_one_day==1?'checked':'' }}> {{ __('admin_local.Has policy before one day ?') }}
                                    <label for=""></label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Deduction') }}</label>
                                    <input type="text" name="one_day_deduction" id="one_day_deduction" class="form-control" value="{{ $rpolicies->one_day_deduction>0?$rpolicies->one_day_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Service Charge Deduction') }}</label>
                                    <input type="text" name="one_day_service_charge_deduction" id="one_day_service_charge_deduction" class="form-control" value="{{ $rpolicies->one_day_service_charge_deduction>0? $rpolicies->one_day_service_charge_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Maximum Refund') }}</label>
                                    <input type="text" name="one_day_maximum_refund" id="one_day_maximum_refund" class="form-control" value="{{ $rpolicies->one_day_maximum_refund>0?$rpolicies->one_day_maximum_refund:0 }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h4 class="text-center my-3"><u>{{ __("admin_local.Two Day Before Booking") }}</u></h4>
                                <div class="col-lg-3">
                                    <input type="checkbox"
                                        name="has_policy_before_two_day" id="has_policy_before_two_day" {{ $rpolicies->has_policy_before_two_day==1?'checked':'' }} > {{ __('admin_local.Has policy before two day ?') }}
                                    <label for=""></label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Deduction') }}</label>
                                    <input type="text" name="two_day_deduction" id="two_day_deduction" class="form-control" value="{{ $rpolicies->two_day_deduction>0?$rpolicies->two_day_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Service Charge Deduction') }}</label>
                                    <input type="text" name="two_day_service_charge_deduction" id="two_day_service_charge_deduction" class="form-control" value="{{ $rpolicies->two_day_service_charge_deduction>0?$rpolicies->two_day_service_charge_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Maximum Refund') }}</label>
                                    <input type="text" name="two_day_maximum_refund" id="two_day_maximum_refund" class="form-control" value="{{ $rpolicies->two_day_maximum_refund>0?$rpolicies->two_day_maximum_refund:0 }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h4 class="text-center my-3"><u>{{ __("admin_local.Three Day Before Booking") }}</u></h4>
                                <div class="col-lg-3">
                                    <input type="checkbox"
                                        name="has_policy_before_three_day" id="has_policy_before_three_day"{{ $rpolicies->has_policy_before_three_day==1?'checked':'' }}> {{ __('admin_local.Has policy before three day ?') }}
                                    <label for=""></label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Deduction') }}</label>
                                    <input type="text" name="three_day_deduction" id="three_day_deduction" class="form-control" value="{{ $rpolicies->three_day_deduction>0?$rpolicies->three_day_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Service Charge Deduction') }}</label>
                                    <input type="text" name="three_day_service_charge_deduction" id="three_day_service_charge_deduction" class="form-control" value="{{ $rpolicies->three_day_service_charge_deduction>0?$rpolicies->three_day_service_charge_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Maximum Refund') }}</label>
                                    <input type="text" name="three_day_maximum_refund" id="three_day_maximum_refund" class="form-control" value="{{ $rpolicies->three_day_maximum_refund>0?$rpolicies->three_day_maximum_refund:0 }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h4 class="text-center my-3"><u>{{ __("admin_local.Five Day Before Booking") }}</u></h4>
                                <div class="col-lg-3">
                                    <input type="checkbox"
                                        name="has_policy_before_five_day" id="has_policy_before_five_day" {{ $rpolicies->has_policy_before_five_day==1?'checked':'' }}> {{ __('admin_local.Has policy before five day ?') }}
                                    <label for=""></label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Deduction') }}</label>
                                    <input type="text" name="five_day_deduction" id="five_day_deduction" class="form-control" value="{{ $rpolicies->five_day_deduction>0?$rpolicies->five_day_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Service Charge Deduction') }}</label>
                                    <input type="text" name="five_day_service_charge_deduction" id="five_day_service_charge_deduction" class="form-control" value="{{ $rpolicies->five_day_service_charge_deduction>0?$rpolicies->five_day_service_charge_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Maximum Refund') }}</label>
                                    <input type="text" name="five_day_maximum_refund" id="five_day_maximum_refund" class="form-control" value="{{ $rpolicies->five_day_maximum_refund>0?$rpolicies->five_day_maximum_refund:0 }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h4 class="text-center my-3"><u>{{ __("admin_local.Seven Day Before Booking") }}</u></h4>
                                <div class="col-lg-3">
                                    <input type="checkbox"
                                        name="has_policy_before_seven_day" id="has_policy_before_seven_day" {{ $rpolicies->has_policy_before_seven_day==1?'checked':'' }}> {{ __('admin_local.Has policy before seven day ?') }}
                                    <label for=""></label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Deduction') }}</label>
                                    <input type="text" name="seven_day_deduction" id="seven_day_deduction" class="form-control" value="{{ $rpolicies->seven_day_deduction>0?$rpolicies->seven_day_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Service Charge Deduction') }}</label>
                                    <input type="text" name="seven_day_service_charge_deduction" id="seven_day_service_charge_deduction" class="form-control" value="{{ $rpolicies->seven_day_service_charge_deduction>0?$rpolicies->seven_day_service_charge_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Maximum Refund') }}</label>
                                    <input type="text" name="seven_day_maximum_refund" id="seven_day_maximum_refund" class="form-control" value="{{ $rpolicies->seven_day_maximum_refund>0?$rpolicies->seven_day_maximum_refund:0 }}">
                                </div>
                            </div>
                            <hr>
                            <div class="row">
                                <h4 class="text-center my-3"><u>{{ __("admin_local.More Then Seven Day Before Booking") }}</u></h4>
                                <div class="col-lg-3">
                                    <input type="checkbox"
                                        name="has_policy_before_eight_day" id="has_policy_before_eight_day" {{ $rpolicies->has_policy_before_eight_day==1?'checked':'' }}> {{ __('admin_local.Has policy before more then seven day ?') }}
                                    <label for=""></label>
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Deduction') }}</label>
                                    <input type="text" name="eight_day_deduction" id="eight_day_deduction" class="form-control" value="{{ $rpolicies->eight_day_deduction>0?$rpolicies->eight_day_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Service Charge Deduction') }}</label>
                                    <input type="text" name="eight_day_service_charge_deduction" id="eight_day_service_charge_deduction" class="form-control" value="{{ $rpolicies->eight_day_service_charge_deduction>0?$rpolicies->eight_day_service_charge_deduction:0 }}">
                                </div>
                                <div class="col-lg-3">
                                    <label for="">{{ __('admin_local.Maximum Refund') }}</label>
                                    <input type="text" name="eight_day_maximum_refund" id="eight_day_maximum_refund" class="form-control" value="{{ $rpolicies->eight_day_maximum_refund>0?$rpolicies->eight_day_maximum_refund:0 }}">
                                </div>
                            </div>
                            <div class="row mt-5">
                                <div class="col-md-12">
                                    <button class="btn btn-success" style="float: right;" type="submit">{{ __('admin_local.Update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
        <!-- Row -->
    </div>
@endsection
@push('js')
    <script src="{{ asset(env('ASSET_DIRECTORY', 'public') . '/' . 'admin/assets/js/sweet-alert/sweetalert.min.js') }}"></script>
    <script
        src="{{ asset(env('ASSET_DIRECTORY', 'public') . '/' . 'admin/assets/js/datatable/datatables/jquery.dataTables.min.js') }}">
    </script>
    <script src="{{ asset(env('ASSET_DIRECTORY', 'public') . '/' . 'admin/plugins/switchery/switchery.min.js') }}"></script>
    <script src="{{ asset(env('ASSET_DIRECTORY', 'public') . '/' . 'admin/assets/js/select2/select2.full.min.js') }}"></script>
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
    <script src="{{ asset(env('ASSET_DIRECTORY', 'public') . '/' . 'admin/custom/hostel/hostel.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
