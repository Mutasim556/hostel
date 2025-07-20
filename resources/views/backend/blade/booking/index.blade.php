 @extends('backend.shared.layouts.admin')
 @push('title')
     {{ __('admin_local.booking List') }}
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

         .receipt-container {
             max-width: 600px;
             margin: auto;
             background: #fff;
             padding: 30px;
             border-radius: 10px;
             box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
         }

         .receipt-header {
             text-align: center;
             margin-bottom: 30px;
         }

         .receipt-header h2 {
             margin: 0;
         }

         .receipt-details {
             width: 100%;
             margin-bottom: 20px;
         }

         .receipt-details th,
         .receipt-details td {
             text-align: left;
             padding: 8px 0;
         }

         .receipt-details th {
             width: 40%;
             color: #555;
         }

         .total {
             font-weight: bold;
             font-size: 1.1em;
             margin-top: 20px;
         }

         .receipt-footer {
             text-align: center;
             margin-top: 30px;
             font-size: 0.9em;
             color: #777;
         }

         .line {
             border-top: 1px dashed #ccc;
             margin: 20px 0;
         }

         .paid-stamp {
             text-align: right;
             margin-top: 10px;
             color: green;
             font-weight: bold;
             font-size: 1.2em;
         }
     </style>
 @endpush
 @section('content')
     {{-- Add booking Modal Start --}}

     <div class="modal fade" id="booking-payment-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg" aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">
                 <div class="modal-header d-flex align-items-center" style="border-bottom:1px dashed gray">
                     <h4 class="modal-title" id="myLargeModalLabel">
                         {{ __('admin_local.Invoice') }} <span id="invoice_id_append"></span>
                     </h4>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>

                 {{-- <p class="px-3 text-danger"><i>{{ __('admin_local.The field labels marked with * are required input fields.') }}</i>
                </p> --}}
                 <div class="modal-body" style="margin-top: -20px">
                     <div class="row py-3">
                         <ul class="nav nav-tabs nav-primary" id="pills-warningtab" role="tablist">
                             <li class="nav-item"><a class="nav-link active" id="pills-payments-tab" data-bs-toggle="pill"
                                     href="#pills-payments" role="tab" aria-controls="pills-payments"
                                     aria-selected="true"><i class="icofont icofont-notepad"
                                         style="font-size:22px"></i>Payments</a></li>
                             <li class="nav-item"><a class="nav-link" id="pills-makepayment-tab" data-bs-toggle="pill"
                                     href="#pills-makepayment" role="tab" aria-controls="pills-makepayment"
                                     aria-selected="false"><i class="icofont icofont-pay" style="font-size:22px"></i>Make
                                     Payment</a></li>
                         </ul>
                         <div class="tab-content px-0 " id="pills-warningtabContent">
                             <div class="tab-pane fade show active" id="pills-payments" role="tabpanel"
                                 aria-labelledby="pills-payments-tab">
                                 <table class="table table-hover table-striped table-bordered mt-2">
                                     <thead class="table-dark">
                                         <tr class="text-center">
                                             <th>{{ __('admin_local.Payment Date') }}</th>
                                             <th>{{ __('admin_local.Amount') }}</th>
                                             <th>{{ __('admin_local.Method') }}</th>
                                             <th>{{ __('admin_local.Received By') }}</th>
                                             <th>{{ __('admin_local.Action') }}</th>
                                         </tr>
                                     </thead>
                                     <tbody id="append_payments" class="overflow-auto" style="max-height: 300px;">

                                     </tbody>
                                     <div style="display:none" id="append_print_btn">

                                     </div>

                                 </table>
                             </div>
                             <div class="tab-pane fade" id="pills-makepayment" role="tabpanel"
                                 aria-labelledby="pills-makepayment-tab">
                                 <div>
                                     <form class="form" action="" id="make_payment_form">
                                         @csrf
                                         <input type="hidden" name="payment_invoice_id" id="payment_invoice_id">
                                         <div class="row mt-3 px-3">
                                             <div class="form-group col-md-6">
                                                 <label for="">{{ __('admin_local.Payable Amount') }}</label>
                                                 <input type="text" class="form-control" name="payable_amount"
                                                     id="payable_amount" readonly>
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="">{{ __('admin_local.Paying Amount') }}</label>
                                                 <input type="text" class="form-control" name="paying_amount"
                                                     id="paying_amount" required>
                                                 <span class="text-danger err-mgs" id="paying_amount_err"></span>
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="">{{ __('admin_local.Remaining Due') }}</label>
                                                 <input type="text" class="form-control" name="remaining_due"
                                                     id="remaining_due" readonly>
                                             </div>
                                             <div class="form-group col-md-6">
                                                 <label for="">{{ __('admin_local.Payment Method') }}</label>
                                                 <select class="form-control" name="payment_method" id="payment_method">
                                                     <option value="CASH" selected>CASH</option>
                                                 </select>
                                             </div>
                                         </div>
                                         <div class="row mt-4 mb-2 px-3">
                                             <div class="form-group col-lg-12">

                                                 <button
                                                     class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                                     data-bs-dismiss="modal" style="float: right"
                                                     type="button">{{ __('admin_local.Close') }}</button>
                                                 <button class="btn btn-primary mx-2" style="float: right"
                                                     type="submit">{{ __('admin_local.Submit') }}</button>
                                             </div>
                                         </div>
                                     </form>
                                 </div>
                             </div>

                         </div>

                     </div>
                 </div>

             </div>
             <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
     </div>

     {{-- Add booking Modal End --}}

     {{-- Add booking Modal Start --}}

     <div class="modal fade" id="print-payment-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
         aria-hidden="true">
         <div class="modal-dialog modal-lg">
             <div class="modal-content">

                 <div class="modal-body" style="margin-top: -20px">
                     <div class="row my-4">
                         <div class="col-lg-12">
                             <button style="float:right;font-size:20px" type="button" id="printBtn"
                                 class="btn btn-primary btn-sm py-1"><i class="fa fa-print"></i>
                                 {{ __('admin_local.Print') }}</button>
                         </div>
                     </div>
                     <div class="receipt-container" id="printArea">

                         <div class="receipt-header">
                             <h2>{{ __('admin_local.Payment Receipt') }}</h2>
                             <p id="print_hostel_name"></p>
                             <p id="hostel_contact_info"></p>
                         </div>

                         <div class="line"></div>

                         <table class="receipt-details">
                             <tr>
                                 <th>{{ __('admin_local.Receipt No') }}</th>
                                 <td id="print_receipt_number"></td>
                             </tr>

                             <tr>
                                 <th>{{ __('admin_local.Payment Date') }}</th>
                                 <td id="print_payment_date"></td>
                             </tr>
                             <tr>
                                 <th>{{ __('admin_local.Paid By') }}</th>
                                 <td id="print_paid_by"></td>
                             </tr>
                             <tr>
                                 <th>{{ __('admin_local.Booking Phone Number') }}</th>
                                 <td id="print_booking_phone"></td>
                             </tr>
                             <tr>
                                 <th>{{ __('admin_local.Payment Received By') }}</th>
                                 <td id="print_received_by"></td>
                             </tr>
                             <tr>
                                 <th>{{ __('adminlocal.Payment Method') }}</th>
                                 <td id="print_payment_method"></td>
                             </tr>
                             <tr>
                                 <th>{{ __('admin_local.Invoice Number') }}</th>
                                 <td id="print_invoice_number"></td>
                             </tr>
                         </table>

                         <div class="line"></div>

                         <table class="receipt-details">

                             <tr>
                                 <th>{{ __('admin_local.Total Payable') }}</th>
                                 <td id="print_total_payable"></td>
                             </tr>
                             <tr class="total">
                                 <th>{{ __('admin_local.Total Paid') }}</th>
                                 <td id="print_total_paid"></td>
                             </tr>
                             <tr class="total">
                                 <th>{{ __('admin_local.Total Due') }}</th>
                                 <td id="print_total_due"></td>
                             </tr>
                         </table>

                         <div class="paid-stamp">✔ {{ __('admin_local.RECEIVED') }}</div>

                         <div class="receipt-footer">
                             {{ __('admin_local.Thank you for your payment') }}<br>
                             {{ 'admin_local.This is a computer-generated receipt and does not require a signature' }}
                         </div>
                     </div>
                     <div class="row mt-4 mb-2">
                         <div class="form-group col-lg-12">

                             <button class="btn btn-danger text-white font-weight-medium waves-effect text-start"
                                 data-bs-dismiss="modal" style="float: right"
                                 type="button">{{ __('admin_local.Close') }}</button>
                         </div>

                     </div>
                 </div>

             </div>
             <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
     </div>

     {{-- Add booking Modal End --}}

     <div class="modal fade" id="edit-payment-modal" tabindex="-1" aria-labelledby="bs-example-modal-lg"
         aria-hidden="true">
         <div class="modal-dialog modal-lg" style="margin-top: 200px;">
             <div class="modal-content">
                <div class="modal-header d-flex align-items-center bg-primary" style="border-bottom:1px dashed gray">
                     <h4 class="modal-title" id="myLargeModalLabel">
                         {{ __('admin_local.Receipt') }} <span id="receipt_id_append"></span>
                     </h4>
                     <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                 </div>
                 <div class="modal-body bg-info">
                     <div class="row my-4">
                         <form class="form" action="" id="edit_payment_form">
                             @csrf
                             <input type="hidden" name="payment_invoice_id" id="epayment_invoice_id">
                             <div class="row mt-3 px-3">
                                 <div class="form-group col-md-6">
                                     <label for="">{{ __('admin_local.Payable Amount') }}</label>
                                     <input type="text" class="form-control" name="payable_amount"
                                         id="epayable_amount" readonly>
                                 </div>
                                 <div class="form-group col-md-6">
                                     <label for="">{{ __('admin_local.Paying Amount') }}</label>
                                     <input type="text" class="form-control" name="paying_amount" id="epaying_amount"
                                         required>
                                     <span class="text-danger err-mgs" id="epaying_amount_err"></span>
                                 </div>
                                 <div class="form-group col-md-6">
                                     <label for="">{{ __('admin_local.Remaining Due') }}</label>
                                     <input type="text" class="form-control" name="remaining_due" id="eremaining_due"
                                         readonly>
                                 </div>
                                 <div class="form-group col-md-6">
                                     <label for="">{{ __('admin_local.Payment Method') }}</label>
                                     <select class="form-control" name="payment_method" id="epayment_method">
                                         <option value="CASH" selected>CASH</option>
                                     </select>
                                 </div>
                             </div>
                             <div class="row mt-4 mb-2 px-3">
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

             </div>
             <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
     </div>

     {{-- Add booking Modal End --}}



     <div class="container-fluid">
         <div class="row">
             <!-- Column -->
             <div class="col-lg-12 mx-auto">
                 <div class="card">
                     <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                         <h3 class="card-title mb-0 text-center">{{ __('admin_local.booking List') }}</h3>
                     </div>

                     <div class="card-body">
                         @if (hasPermission(['booking-create']))
                             <div class="row mb-3">
                                 <div class="col-md-3">
                                     <a href="{{ route('admin.booking.create') }}" class="btn btn-success">+
                                         {{ __('admin_local.Booking') }}</a>
                                 </div>
                             </div>
                         @endif
                         <div class="table-responsive theme-scrollbar">
                             <table id="basics-1" class="display table-bordered" style="width: 1200px">
                                 <thead>
                                     <tr>
                                         <th style="width: 100px">{{ __('admin_local.Booking Date') }}</th>
                                         <th style="width: 100px">{{ __('admin_local.Checkout Date') }}</th>
                                         <th>{{ __('admin_local.Room Number') }}</th>
                                         <th>{{ __('admin_local.Total Room') }}</th>
                                         <th>{{ __('admin_local.Booking Person') }}</th>
                                         <th>{{ __('admin_local.Phone Number') }}</th>
                                         <th>{{ __('admin_local.Total Amount') }}</th>
                                         <th>{{ __('admin_local.Total Discount') }}</th>
                                         <th>{{ __('admin_local.Total Payable') }}</th>
                                         <th>{{ __('admin_local.Total Paid') }}</th>
                                         <th>{{ __('admin_local.Total Due') }}</th>
                                         <th>{{ __('admin_local.Payment Status') }}</th>
                                         <th>{{ __('admin_local.Action') }}</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($bookings as $booking)
                                         <tr id="trid-{{ $booking->id }}" data-id="{{ $booking->id }}">
                                             {{-- <td>{{ $booking-> }}</td> --}}
                                             <td>{{ date('d M ,Y', strtotime($booking->booking_start_date)) }}</td>
                                             <td>{{ date('d M ,Y', strtotime($booking->booking_end_date)) }}</td>
                                             <td>
                                                 @foreach ($booking->rooms as $room)
                                                     <span
                                                         class="badge badge-primary mr-1 p-2">{{ $room->room_number }}</span>
                                                 @endforeach
                                             </td>
                                             <td>{{ count($booking->rooms) }}</td>
                                             <td>{{ $booking->bookingperson->booking_person_name }}</td>
                                             <td>{{ $booking->bookingperson->booking_phone_number }}</td>
                                             <td>{{ $booking->seat_price ? $booking->seat_price + $booking->seat_service_charge : 0 }}
                                             </td>
                                             <td>{{ $booking->discount ?? 0 }}</td>
                                             <td>{{ $booking->total_payable ?? 0 }}</td>
                                             <td>{{ $booking->total_paid ?? 0 }}</td>
                                             <td>{{ $booking->total_due ?? 0 }}</td>
                                             <td>{!! $booking->total_payable == $booking->total_paid
                                                 ? '<span class="badge badge-success">' . __('admin_local.Paid') . '</span'
                                                 : ($booking->total_paid == 0
                                                     ? '<span class="badge badge-danger">' . __('admin_local.Unpaid') . '</span'
                                                     : '<span class="badge badge-warning">' . __('admin_local.Prtially Paid') . '</span') !!}</td>
                                             {{-- <td>{{ $booking->total_window }}</td> --}}
                                             {{-- <td>{{ $booking->total_fan }}</td>
                                            <td>{{ $booking->total_light }}</td> --}}

                                             {{-- <td class="text-center">
                                                @if (hasPermission(['booking-update']))
                                                <span class="mx-2">{{ $booking->status==1?'Active':'Inactive' }}</span><input
                                                    data-status="{{ $booking->status == 1 ? 0 : 1 }}"
                                                    id="status_change" type="checkbox" data-toggle="switchery"
                                                    data-color="green" data-secondary-color="red" data-size="small"
                                                    {{ $booking->status == 1 ? 'checked' : '' }} />
                                                @else
                                                    <span class="badge badge-danger">{{ __("admin_local.No Permission") }}</span>
                                                @endif
                                            </td> --}}
                                             <td class="text-center">
                                                 @if (hasPermission(['booking-update', 'booking-delete']))
                                                     <div class="dropdown">
                                                         <button
                                                             class="btn btn-info text-white px-2 py-1 dropbtn">{{ __('admin_local.Action') }}
                                                             <i class="fa fa-angle-down"></i></button>
                                                         <div class="dropdown-content">
                                                             @if (hasPermission(['booking-payment']) && $booking->payment_status != 1)
                                                                 <a style="cursor: pointer;" href="#"
                                                                     data-bs-toggle="modal"
                                                                     data-bs-target="#booking-payment-modal"
                                                                     id="show_payments"><i class=" fa fa-money mx-1"></i>
                                                                     {{ __('admin_local.Payment') }}</a>
                                                             @endif
                                                             @if (hasPermission(['booking-update']))
                                                                 <a style="cursor: pointer;"
                                                                     href="{{ route('admin.booking.edit', $booking->id) }}"><i
                                                                         class=" fa fa-edit mx-1"></i>
                                                                     {{ __('admin_local.Edit') }}</a>
                                                             @endif
                                                             @if (hasPermission(['booking-update']))
                                                                 <a style="cursor: pointer;"
                                                                     href="{{ route('admin.booking.edit', $booking->id) }}"><i
                                                                         class=" fa fa-print mx-1"></i>
                                                                     {{ __('admin_local.Print Invoice') }}</a>
                                                             @endif
                                                             @if (hasPermission(['booking-delete']))
                                                                 <a class="text-danger" id="delete_button"
                                                                     style="cursor: pointer;"><i
                                                                         class="fa fa-trash mx-1"></i>
                                                                     {{ __('admin_local.Cancel') }}</a>
                                                             @endif
                                                         </div>
                                                     </div>
                                                 @else
                                                     <span
                                                         class="badge badge-danger">{{ __('admin_local.No Permission') }}</span>
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
             dropdownParent: $('#add-booking-modal')
         });
         $('.js-example-basic-single1').select2({
             dropdownParent: $('#edit-booking-modal')
         });
         $(document).on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
         });
         var oTable = $("#basics-1").DataTable({
             autoWidth: false,

         });

         var payment_form_url = "{{ route('admin.booking.makeBookingPayments') }}";
         var submit_btn_after =
             `<strong>{{ __('admin_local.Saving ') }} &nbsp; <i class="fa fa-rotate-right fa-spin"></i></strong>`;
         var submit_btn_before = `{{ __('admin_local.Submit') }}</strong>`;
         var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;
         var comfirm_btn = `{{ __('admin_local.Ok') }}`;

        var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
        var delete_swal_text =
            `{{ __('admin_local.Once deleted, you will not be able to recover this data') }}`;
        var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;
        var no_file = `{{ __('admin_local.No file') }}`;
     </script>
     <script src="{{ asset('public/admin/custom/booking/booking_list.js') }}"></script>
 @endpush
