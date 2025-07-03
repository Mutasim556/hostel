@extends('backend.shared.layouts.admin')
@push('title')
    {{ __('admin_local.Booking') }}
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

        .selectedClass{
            background-color: rgb(244, 69, 250);
            color: rgb(255, 255, 255);
            border: 1px solid black;
        }
    </style>
@endpush
@section('content')


    <div class="modal fade" id="add-booking-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Add booking') }}
                    </h4>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form method="POST" action="" id="add_booking_form" enctype="multipart/form-data">
                        @csrf
                        <div class="row">
                            <div id="append_hidden_inputs">

                            </div>
                            <div class="row" id="append_booking_seats">

                            </div>
                            <div class="row mt-4">
                                <u><h5>{{ __('admin_local.Booking Informations') }}</h5></u>
                                <div class="col-md-3 mb-3">
                                    <label for="">{{ __('admin_local.Booking Start Date') }}</label>
                                    <input type="date" name="booking_start_date" id="booking_start_date" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">{{ __('admin_local.Booking End Date') }}</label>
                                    <input type="date" name="booking_end_date" id="booking_end_date" class="form-control">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">{{ __('admin_local.Booking Total Days') }}</label>
                                    <input type="number" name="booking_total_days" id="booking_total_days" class="form-control" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">{{ __('admin_local.Total Price') }}</label>
                                    <input type="text" name="booking_total_price" id="booking_total_price" class="form-control" >
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">{{ __('admin_local.Total Service Charge') }}</label>
                                    <input type="text" name="booking_total_service_charge" id="booking_total_service_charge" class="form-control" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">{{ __('admin_local.Total Discount') }}</label>
                                    <input type="text" name="booking_total_discount" id="booking_total_discount" class="form-control" value="0">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">{{ __('admin_local.Total Payable') }}</label>
                                    <input type="text" name="booking_total_payable" id="booking_total_payable" class="form-control" readonly>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">{{ __('admin_local.Total Paid') }}</label>
                                    <input type="text" name="booking_total_paid" id="booking_total_paid" class="form-control" >
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="">{{ __('admin_local.Total Due') }}</label>
                                    <input type="text" name="booking_total_due" id="booking_total_due" class="form-control" readonly>
                                </div>
                            </div>
                            <div class="row mt-4">

                                <u><h5>{{ __('admin_local.Booking Person Informations') }}</h5></u>
                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.Phone Number') }}</label>
                                    <input type="text" name="booking_phone_number" id="booking_phone_number" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.Person Email') }}</label>
                                    <input type="text" name="booking_person_email" id="booking_person_email" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.Person Name') }}</label>
                                    <input type="text" name="booking_person_name" id="booking_person_name" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.Gender') }}</label><br>
                                    <input type="radio" name="booking_person_gender" value="Male"> {{ __('admin_local.Male') }} &nbsp; &nbsp;
                                    <input type="radio" name="booking_person_gender" value="Female"> {{ __('admin_local.Female') }}
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.Date Of Birth') }}</label>
                                    <input type="date" name="booking_person_dob" id="booking_person_dob" class="form-control">
                                </div>

                                 <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.NID Number') }}</label>
                                    <input type="text" name="booking_nid_number" id="booking_nid_number" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.Address') }}</label>
                                    <textarea class="form-control" name="booking_person_address" id="booking_person_address" placeholder="Division,District,Thana,Village/Street/Road No"></textarea>
                                </div>

                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.Service ID') }}</label>
                                    <input type="text" name="booking_service_id" id="booking_service_id" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.Workplace Address') }}</label>
                                    <textarea class="form-control" name="booking_person_workplace_address" id="booking_person_workplace_address"></textarea>
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.Image') }}</label>
                                    <input type="file" name="booking_person_image" id="booking_person_image" class="form-control">
                                </div>
                                <div class="col-md-4 mb-3">
                                    <label for="">{{ __('admin_local.NID') }}</label>
                                    <input type="file" name="booking_person_nid" id="booking_person_nid" class="form-control">
                                </div>
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

    {{-- <div class="modal fade" id="edit-booking-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
        aria-hidden="true">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                    <h4 class="modal-title" id="myLargeModalLabel">
                        {{ __('admin_local.Edit booking') }}
                    </h4>
                    <button type="button" class="btn-close " data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p>
                <div class="modal-body" style="margin-top: -20px">
                    <form id="edit_booking_form" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" id="booking_id" name="booking_id" value="">
                        <div class="row">
                            <div class="col-lg-6 mt-2">
                                <label for="booking_name"><strong>{{ __('admin_local.booking Name') }} ({{ __('admin_local.Default') }})
                                        *</strong></label>
                                <input type="text" class="form-control" name="booking_name"
                                    id="booking_name">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @foreach (getLangs() as $lang)
                            <div class="col-lg-6 mt-2">
                                <label for="booking_name"><strong>{{ __('admin_local.booking Name') }} ( {{ $lang->name }} )
                                    *</strong></label>
                                <input type="text" class="form-control" name="booking_name_{{ $lang->lang }}"
                                    id="booking_name_{{ $lang->lang }}">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            @endforeach
                            <div class="col-lg-3 mt-2">
                                <input type="checkbox" name="translate_autometic" id="translate_autometic" > &nbsp;
                                <label for="booking_name"><strong>{{ __('admin_local.Translate Autometic') }}</strong></label>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="booking_name"><strong>{{ __('admin_local.booking Type') }}
                                        *</strong></label>
                                <select class="form-control" name="booking_type" id="booking_type">
                                    <option value="">{{ __('admin_local.Select Please') }}</option>
                                    <option value="Boys">{{ __('admin_local.Boys') }}</option>
                                    <option value="Girls">{{ __('admin_local.Girls') }}</option>
                                    <option value="All">{{ __('admin_local.All') }}</option>
                                </select>
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="booking_phone"><strong>{{ __('admin_local.booking Phone') }}
                                        *</strong></label>
                                <input type="text" class="form-control" name="booking_phone"
                                    id="booking_phone">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-3 mt-2">
                                <label for="booking_email"><strong>{{ __('admin_local.booking Email') }}
                                        </strong></label>
                                <input type="text" class="form-control" name="booking_email"
                                    id="booking_email">
                                <span class="text-danger err-mgs"></span>
                            </div>
                            <div class="col-lg-6 mt-2">
                                <label for="booking_address"><strong>{{ __('admin_local.booking Address') }}
                                        </strong></label>
                                <textarea class="form-control" name="booking_address"
                                    id="booking_address"></textarea>
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
                        <div class="row mb-4">
                            <div class="col-lg-4 mt-2">
                                <input type="checkbox" name="has_multiple_building" id="has_multiple_building" > &nbsp;
                                <label for="booking_name"><strong>{{ __('admin_local.Has multiple building ?') }}</strong></label>
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
    </div> --}}

    {{-- Add User Modal End --}}



    <div class="container-fluid">
        <div class="row">
            <!-- Column -->
            <div class="col-lg-12 mx-auto">
                <div class="card">
                    <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                        <h3 class="card-title mb-0 text-center">{{ __('admin_local.Booking') }}</h3>
                    </div>

                    <div class="card-body">
                        <form id="search_form" action="{{ route('admin.booking.getAvailableSeats') }}" method="post">
                            @csrf
                            <div class="row">
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.Hostel') }}</label>
                                    <select class="form-control append-select2" name="hostel" id="hostel">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @php
                                            $hostels = \App\Models\Admin\Hostel::where([['status',1],['delete',0]])->get();
                                        @endphp
                                        @foreach ($hostels as $hostel)
                                            <option value="{{ $hostel->id }}">{{ $hostel->hostel_name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.Building') }}</label>
                                    <select class="form-control append-select2" name="building" id="building">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.Floor') }}</label>
                                    <select class="form-control append-select2" name="floor" id="floor">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>

                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.Booking Type') }}</label>
                                    <select class="form-control append-select2" name="booking_type" id="booking_type">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        <option value="day">{{ __('admin_local.Per-Day') }}</option>
                                        <option value="month">{{ __('admin_local.Per-Month') }}</option>
                                    </select>
                                </div>

                            </div>
                            <div class="row mt-3" id="per_day_div" style="display:none">
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.From') }}</label>
                                    <input min="{{ date('Y-m-d') }}" type="date" class="form-control" name="start_date" id="start_date">
                                </div>
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.To') }}</label>
                                    <input type="date" class="form-control" name="end_date" id="end_date" disabled>
                                </div>
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.Total Days') }}</label>
                                    <input type="number" class="form-control" name="total_days" id="total_days" readonly>
                                </div>
                            </div>

                            <div class="row mt-3" id="per_month_div" style="display:none">
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.From') }}</label>
                                    <select class="form-control append-select2" name="start_month" id="start_month">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @php
                                            $firstDay = \Carbon\Carbon::now()->firstOfMonth();
                                            $startDate = \Carbon\Carbon::parse($firstDay->toDateString());
                                            $dateS = \Carbon\Carbon::parse($startDate);
                                            $newDate = $dateS->addMonths(15);
                                            $endDate =\Carbon\Carbon::parse($newDate->toDateString());;
                                        @endphp
                                        @while ($startDate->lessThanOrEqualTo($endDate))
                                            <option value="{{ $startDate->format('Y-m-d') }}">{{ strtoupper($startDate->format('F - Y')) }}</option>

                                            @php
                                                $startDate->addMonth();
                                            @endphp
                                        @endwhile
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.To') }}</label>
                                    <select class="form-control append-select2" name="end_month" id="end_month">
                                        <option value="">{{ __('admin_local.Select Please') }}</option>
                                        @php
                                            $firstDay = \Carbon\Carbon::now()->firstOfMonth();
                                            $startDate = \Carbon\Carbon::parse($firstDay->toDateString());
                                            $dateS = \Carbon\Carbon::parse($startDate);
                                            $newDate = $dateS->addMonths(15);
                                            $endDate =\Carbon\Carbon::parse($newDate->toDateString());
                                            $lastDay = \Carbon\Carbon::create( $startDate->format('Y'),$startDate->format('m'), 1)->endOfMonth();
                                        @endphp
                                        @while ($startDate->lessThanOrEqualTo($endDate))
                                            <option value="{{ $startDate->format('Y-m-d') }}">{{ strtoupper($startDate->format('F - Y')) }}</option>

                                            @php
                                                $startDate->addMonth();
                                            @endphp
                                        @endwhile
                                    </select>
                                </div>
                                <div class="col-md-3">
                                    <label for="">{{ __('admin_local.Total Months') }}</label>
                                    <input type="number" class="form-control" name="total_months" id="total_months" readonly>
                                </div>
                                 <div class="col-md-3">
                                    <label for="">{{ __('admin_local.Date Range') }}</label>
                                    <input type="text" class="form-control" name="date_range" id="date_range" readonly>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-3 pt-2">
                                    <button class="btn btn-primary mt-4 px-2" type="submit">{{ __('admin_local.View Available Rooms/Seats') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="card-body" id="room_card_body" style="display:none">
                        <div class="row" id="append_room_div_main">
                            <h4 class="text-center" id="append_room_div" style="display: none">{{ __('admin_local.Available Rooms/Seats') }}</h4>

                        </div>
                        <div class="row">
                            <div class="col-md-8">

                            </div>
                            <div class="col-md-4">
                                <button type="button" id="book_now_btn" class="btn btn-info" style="float:right" data-bs-toggle="modal" data-bs-target="#add-booking-modal" disabled>{{__('admin_local.Book Now')}}</button>
                            </div>
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
        $('.append-select2').each(function(){
            $(this).select2();
        })

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

        var form_url = "{{ route('admin.booking.store') }}";
        var search_url = "{{ route('admin.booking.getAvailableSeats') }}";
        var search_btn_after = `{{ __('admin_local.Getting data') }}`;
        var search_btn_before = `{{ __('admin_local.View Available Rooms/Seats') }}`;

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


        $(document).on('change','#booking_type',function(){
            if($(this).val()=='day'){
                $('#per_day_div').show('slow');
                $('#per_montn_div').hide('slow');
            }else if($(this).val()=='month'){
                $('#per_day_div').hide('slow');
                $('#per_month_div').show('slow');
            }
        })

        $(document).on('change','#start_date',function(){
            // alert('dddd')
            $('#end_date').prop('disabled',false);
            $('#end_date').val('');

            const date = new Date($(this).val());
            date.setDate(date.getDate() + 1); // Add 1 day

            const nextDate = date.toISOString().split('T')[0];


            $('#end_date').prop('min',nextDate)
        })

        $(document).on('change','#end_date',function(){
            const startDate = new Date($('#start_date').val());
            const endDate = new Date($(this).val());

            // Calculate difference in milliseconds
            const diffTime = endDate - startDate;

            // Convert milliseconds to days
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            $('#total_days').val(diffDays);
        })

        $(document).on('change','#end_month',function(){
            if($(this).val()){
                var valDate = $(this).val();
                var splitDate = valDate.split('-');
                let month = parseInt(parseInt(splitDate[1]));
                const lastDate = new Date(splitDate[0],month, 1);
                const lastDayFormatted = lastDate.toISOString().split('T')[0];

                if($('#start_month').val()){
                    const start = new Date($('#start_month').val());
                    const end = new Date(lastDayFormatted);

                    if (!isNaN(start) && !isNaN(end)) {
                        let years = end.getFullYear() - start.getFullYear();
                        let months = end.getMonth() - start.getMonth();
                        let totalMonths = years * 12 + months;

                        $('#total_months').val(totalMonths+1)


                    }

                    $('#date_range').val($('#start_month').val()+" to "+lastDayFormatted);
                }
            }

        })

    </script>
    <script src="{{ asset(env('ASSET_DIRECTORY','public').'/'.'admin/custom/booking/booking.js') }}"></script>
    {{-- <script src="{{ asset(env('ASSET_DIRECTORY').'/'.'inventory/custom/user/user_list.js') }}"></script> --}}
@endpush
