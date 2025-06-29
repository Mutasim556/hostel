@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Add Seats') }}
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
        <div class="row">
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Add Seats') }}</h3>
                    </div>
                    <div class="card-body">
                        <form class="form" action="{{ route('admin.seats.store') }}" method="POST" id="add_seat_form">
                            @csrf
                            <div class="row">
                                 <div class="col-md-6 rounded py-4" style="box-shadow: 0px 0px 10px gray">
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="">{{ __('admin_local.Select Hostel') }}</label>
                                            <select type="text" class="form-control" name="hostel" id="hostel">
                                                <option value="">{{ __('admin_local.Select Please') }}</option>
                                                @foreach ($hostels as $hostel)
                                                    <option value="{{ $hostel->id }}">{{ $hostel->hostel_name }}</option>
                                                @endforeach
                                            </select>
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">{{ __('admin_local.Select Building') }}</label>
                                            <select type="text" class="form-control" name="building" id="building">

                                            </select>
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="">{{ __('admin_local.Select Floor') }}</label>
                                            <select type="text" class="form-control" name="floor" id="floor">

                                            </select>
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">{{ __('admin_local.Select Block') }}</label>
                                            <select type="text" class="form-control" name="block" id="block">

                                            </select>
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="">{{ __('admin_local.Select Room') }}</label>
                                            <select type="text" class="form-control" name="room" id="room">

                                            </select>
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">{{ __('admin_local.Seat Number') }}</label>
                                            <input type="text" class="form-control" name="seat_number" id="seat_number">
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <label for="">{{ __('admin_local.Seat Maximum Price') }}</label>
                                            <input type="text" class="form-control" name="seat_maximum_price" id="seat_maximum_price">
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                        <div class="col-md-6">
                                            <label for="">{{ __('admin_local.Seat Minimum Price') }}</label>
                                            <input type="text" class="form-control" name="seat_minimum_price" id="seat_minimum_price">
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                        <div class="col-md-6 mt-2">
                                            <label for="">{{ __('admin_local.Price For') }}</label>
                                            <select class="form-control" name="price_for" id="price_for">
                                                <option value="day">{{ __('admin_local.Per-day') }}</option>
                                                <option value="month">{{ __('admin_local.Per-month') }}</option>
                                            </select>
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <input type="checkbox" name="has_any_service_charge" id="has_any_service_charge">
                                            <label for="">{{ __('admin_local.Has any service charge ?') }}</label>
                                        </div>

                                    </div>
                                    <div class="row" id="service_charge_row" style="display:none">
                                        <div class="col-md-6">
                                            <input type="text" class="form-control" name="service_charge" id="service_charge" placeholder="{{ __('admin_local.Example') }} - 1200">
                                            <span class="text-danger err-mgs"></span>
                                        </div>
                                    </div>
                                    {{-- <div class="row">
                                        <div class="col-md-6">
                                            <input type="checkbox" name="has_any_other_charge" id="has_any_other_charge">
                                            <label for="">{{ __('admin_local.Has any other charge ?') }}</label>
                                        </div>
                                        <div class="col-md-6">
                                            <button type="button" class="btn btn-info px-1 py-0">{{ __('admin_local.Add new charge') }}</button>
                                        </div>
                                    </div>
                                    <div id="append_other_charge_div">

                                    </div> --}}
                                 </div>
                                 {{-- <div class="col-md-6 rounded py-4" style="box-shadow: 0px 0px 10px gray">

                                 </div> --}}
                            </div>

                            <div class="row">
                                 <div class="col-lg-12 mt-2">
                                    <button class="btn btn-success" type="submit" id="submit_btn" style="float:left"><strong>{{ __('admin_local.Submit') }}</strong></button>
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
        var oTable = $("#basic-1").DataTable();

        var form_url = "{{ route('admin.seats.store') }}";
        var translate_url = `{{ route('admin.translateString') }}`;
        var submit_btn_after = `<strong>{{ __('admin_local.Submitting') }} &nbsp; <i class="fa fa-rotate-right fa-spin"></i></strong>`;
        var submit_btn_before = `<strong><i class="fa fa-paper-plane"></i> &nbsp; {{ __('admin_local.Submit') }}</strong>`;

        $(document).on('change','#has_any_service_charge',function(){

            if($(this).is(':checked')){
                $('#service_charge_row').show('slow');
            }else{
                $('#service_charge_row').hide('slow');
            }
        });



        $(document).on('change','#has_any_other_charge',function(){
            if($(this).is(':checked')){
                $('#append_other_charge_div').empty();

                $('#append_other_charge_div').append(`
                    <div class="row mb-3" id="other_charge_row">
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="charge_name" id="charge_name" placeholder="{{ __('admin_local.Charge Name') }}">
                            <span class="text-danger err-mgs"></span>
                        </div>
                        <div class="col-md-6">
                            <input type="text" class="form-control" name="charge_amount" id="charge_amount" placeholder="{{ __('admin_local.Charge Amount') }}">
                            <span class="text-danger err-mgs"></span>
                        </div>
                    </div>
                `);
            }else{
                $('#append_other_charge_div').empty();
            }
        });

    </script>
    <script src="{{ asset('public/admin/custom/seats/add_seats.js') }}"></script>
@endpush
