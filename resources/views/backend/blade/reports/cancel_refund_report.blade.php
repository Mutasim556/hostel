 @extends('backend.shared.layouts.admin')
 @push('title')
     {{ __('admin_local.Cancel/Refund reports') }}
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

         #basics-1_wrapper .dt-buttons .btn-group {
             margin-left: 200px !important;
         }
     </style>
 @endpush
 @section('content')
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
                         </div>

                     </div>
                 </div>

             </div>
             <!-- /.modal-content -->
         </div>
         <!-- /.modal-dialog -->
     </div>
     <div class="container-fluid">
         <div class="row">
             <!-- Column -->
             <div class="col-lg-12 mx-auto">
                 <div class="card">
                     <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                         <h3 class="card-title mb-0 text-center">{{ __('admin_local.Cancel/Refund Report') }}</h3>
                     </div>

                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-12">
                                 <form action="{{ route('admin.reports.cancelRefund') }}" id="filter_form"
                                     method="GET">
                                     <div class="row bg-info p-4 mb-4">
                                         <div class="col-md-3">
                                             <label for="">{{ __('admin_local.Start Date') }}</label>
                                             <input type="date" name="start_date"
                                                 value="{{ isset(request()->start_date) ? request()->start_date : '' }}"
                                                 class="form-control">
                                         </div>
                                         <div class="col-md-3">
                                             <label for="">{{ __('admin_local.End Date') }}</label>
                                             <input type="date" name="end_date"
                                                 value="{{ isset(request()->end_date) ? request()->end_date : '' }}"
                                                 class="form-control">
                                         </div>
                                         <div class="col-md-3">
                                             <label for="">{{ __('admin_local.Select Room') }}</label>
                                             <select name="room" class="form-control select2_append">
                                                 <option value="">{{ __('admin_local.Select Please') }}</option>
                                                 <option value="All"
                                                     {{ isset(request()->room) && request()->room == 'All' ? 'selected' : '' }}>
                                                     {{ __('admin_local.All') }}</option>
                                                 @foreach (\App\Models\Admin\Room::where([['status', 1], ['delete', 0]])->get() as $room)
                                                     <option value="{{ $room->id }}"
                                                         {{ isset(request()->room) && request()->room == $room->id ? 'selected' : '' }}>
                                                         {{ $room->floor . '-' . $room->block . '-' . $room->room_number }}
                                                     </option>
                                                 @endforeach

                                             </select>
                                         </div>
                                         <div class="col-md-3">
                                             <label for="">{{ __('admin_local.Service Type') }}</label>
                                             <select name="booking_type" class="form-control select2_append">
                                                 <option value="">{{ __('admin_local.Select Please') }}</option>
                                                 <option value="All">{{ __('admin_local.All') }}</option>
                                                 @foreach (\App\Models\Admin\ServiceType::where([['status', 1], ['delete', 0]])->get() as $service)
                                                     <option value="{{ $service->id }}"
                                                         {{ isset(request()->booking_type) && request()->booking_type == $service->id ? 'selected' : '' }}>
                                                         {{ $service->service_type }} [
                                                         {{ $service->service_code . '-' . $service->room_type }} ]
                                                     </option>
                                                 @endforeach
                                             </select>
                                         </div>
                                         <div class="col-md-12 mt-3" {{--  style="border:1px solid red;"  --}}>
                                             {{-- <label for=""> <span class="text-info"> &nbsp;</span></label><br> --}}
                                             <input type="submit" class="btn btn-primary" style="float:right"
                                                 value="{{ __('admin_local.Search') }}">
                                             <a href="{{ route('admin.reports.cancelRefund') }}"
                                                 class="btn btn-danger mx-4"
                                                 style="float:right">{{ __('admin_local.Reset') }}</a>
                                         </div>
                                     </div>
                                 </form>
                             </div>

                         </div>

                         <div class="table-responsive theme-scrollbar">
                             <table id="basics-1" class="display table-bordered" style="width: 1200px">
                                 <thead>
                                     <tr>
                                         <th style="width: 100px">{{ __('admin_local.Room Number') }}</th>
                                         <th style="width: 100px">{{ __('admin_local.Floor/Block') }}</th>
                                         <th style="width: 100px">{{ __('admin_local.Seat Number') }}</th>
                                         <th>{{ __('admin_local.Invoice Number') }}</th>
                                         <th>{{ __('admin_local.Booking Date') }}</th>
                                         <th>{{ __('admin_local.Checkin Date') }}</th>
                                         <th>{{ __('admin_local.Checkout Date') }}</th>
                                         <th>{{ __('admin_local.Service Type') }}</th>
                                         <th>{{ __('admin_local.Service Charge') }}</th>
                                         <th>{{ __('admin_local.Seat Charge') }}</th>
                                         <th>{{ __('admin_local.Total Charge') }}</th>
                                         <th>{{ __('admin_local.Discount') }}</th>
                                         <th>{{ __('admin_local.Total Payable') }}</th>
                                         <th>{{ __('admin_local.Total Paid') }}</th>
                                         <th>{{ __('admin_local.Total Due') }}</th>
                                         <th>{{ __('admin_local.Cancel Date') }}</th>
                                         <th>{{ __('admin_local.Refund Amout') }}</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($cBooking as $booking)
                                         <tr id="trid-{{ $booking->id }}" data-id="{{ $booking->id }}">

                                             <td>
                                                 @foreach ($booking->invoice->bookings as $count => $room)
                                                     <span
                                                         class="badge badge-info">{{ $room->room->room_number }}{{ count($booking->invoice->bookings) - 2 == $count ? ',' : '' }}</span>
                                                 @endforeach
                                             </td>
                                             <td>
                                                 @foreach ($booking->invoice->bookings as $count => $room)
                                                     {{ $room->room->floor }}{{ count($booking->invoice->bookings) - 2 == $count ? ',' : '' }}
                                                 @endforeach
                                             </td>
                                             <td>
                                                 @foreach ($booking->invoice->bookings as $count => $room)
                                                     {{ $room->seat->seat_number }}{{ count($booking->invoice->bookings) - 2 == $count ? ',' : '' }}
                                                 @endforeach
                                             </td>
                                             <td>{{ '#' . sprintf('%08u', $booking->invoice->id) }}</td>
                                             <td>{{ date('Y-m-d', strtotime($booking->invoice->created_at)) }}</td>
                                             <td>{{ date('Y-m-d', strtotime($booking->invoice->booking_start_date)) }}</td>
                                             <td>{{ date('Y-m-d', strtotime($booking->invoice->booking_end_date)) }}</td>
                                             <td>{{ $booking->invoice->service->service_type . ' [' . $booking->invoice->service->room_type . ']' }}
                                             </td>
                                             <td>{{ $booking->invoice->seat_price }}</td>
                                             <td>{{ $booking->invoice->seat_service_charge }}</td>
                                             <td>{{ $booking->invoice->seat_price + $booking->invoice->seat_service_charge }}
                                             </td>
                                             <td>{{ $booking->invoice->discount }}</td>
                                             <td>{{ $booking->invoice->total_payable }}</td>
                                             <td>{{ $booking->invoice->total_paid }}</td>
                                             <td>{{ $booking->invoice->total_due }}</td>
                                             <td>{{ date('Y-m-d', strtotime($booking->invoice->cancel_date)) }}</td>
                                             <td>{{ $booking->type == 'IN' ? $booking->paying_amount : '-' . $booking->refund_amount }}
                                             </td>
                                         </tr>
                                     @endforeach

                                 </tbody>
                                 <tfoot>
                                     <tr>
                                         <th></th>
                                         <th></th>
                                         <th></th>
                                         <th></th>
                                         <th></th>
                                         <th></th>
                                         <th></th>
                                         <th style="text-align:right">Total:</th>
                                         <th id="seat_sum"></th>
                                         <th id="service_sum"></th>
                                         <th id="total_sum"></th>
                                         <th></th>
                                         <th></th>
                                         <th></th>
                                         <th></th>
                                         <th></th>
                                         <th></th>
                                     </tr>
                                 </tfoot>
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
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.buttons.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/jszip.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/buttons.colVis.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/pdfmake.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/vfs_fonts.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.autoFill.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.select.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/buttons.bootstrap4.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/buttons.html5.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/buttons.print.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.bootstrap4.min.js') }}">
     </script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.responsive.min.js') }}">
     </script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/responsive.bootstrap4.min.js') }}">
     </script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.keyTable.min.js') }}"></script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.colReorder.min.js') }}">
     </script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.fixedHeader.min.js') }}">
     </script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.rowReorder.min.js') }}">
     </script>
     <script src="{{ asset('public/admin/assets/js/datatable/datatable-extension/dataTables.scroller.min.js') }}"></script>
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


         $('#filter_form .select2_append').each(function() {
             $(this).select2();
         });


         $(document).on('select2:open', () => {
             document.querySelector('.select2-search__field').focus();
         });
         var oTable = $("#basics-1").DataTable({
             autoWidth: false,
             lengthMenu: [
                 [3, 10, 25, 50, 100, -1],
                 [3, 10, 25, 50, 100, "All"]
             ],
             dom: 'Blfrtip',
             buttons: [{
                     extend: 'copyHtml5',
                     title: '',
                     text: '<i class="fa fa-copy"></i> Copy',
                     filename: 'seat_wise_booking_report',
                     className: 'btn btn-warning',
                     footer: true,
                 },
                 {
                     extend: 'excelHtml5',
                     title: '',
                     text: '<i class="fa fa-file-excel-o"></i> Excel',
                     filename: 'seat_wise_booking_report',
                     className: 'btn btn-info',
                     footer: true,
                     // or use title: null to remove
                 },
                 // {
                 //     extend: 'csvHtml5',
                 //     title: '',
                 //      text: '<i class="fa fa-file-csv"></i> CSV',
                 //     filename: 'seat_wise_booking_report'
                 // },
                 {
                     extend: 'pdfHtml5',
                     title: 'Buddhijibi Hostel\n\nSeat Wise Booking Report' +
                         ` [ {{ isset(request()->start_date) ? request()->start_date : date('Y-m-d') }} to {{ isset(request()->end_date) ? request()->end_date : date('Y-m-d') }} ]`,
                     filename: 'seat_wise_booking_report',
                     orientation: 'landscape', // <-- This sets landscape layout
                     pageSize: 'A4',
                     text: '<i class="fa fa-file-pdf-o"></i> PDF',
                     className: 'btn btn-success',
                     footer: true,
                     customize: function(doc) {
                         var api = oTable;

                         // Your existing style code here...
                         doc.defaultStyle.fontSize = 8;
                         doc.styles.tableHeader.fontSize = 10;
                         doc.content[0].alignment = 'center';

                         const footerRow = doc.content[1].table.body[doc.content[1].table.body.length - 1];
                         footerRow.forEach(function(cell) {
                             cell.fontSize = 8;
                             cell.bold = true;
                         });

                         doc.content.splice(0, 1);

                         doc.content.unshift({
                             text: 'Buddhijibi Hostel',
                             fontSize: 16,
                             bold: true,
                             alignment: 'center',
                             margin: [0, 0, 0, 5]
                         }, {
                             text: 'Seat Wise Booking Report' +
                                 `[ {{ request()->start_date ?? date('Y-m-d') }} to {{ request()->end_date ?? date('Y-m-d') }} ]`,
                             fontSize: 12,
                             bold: true,
                             alignment: 'center',
                             margin: [0, 0, 0, 10]
                         });

                         // === ADD THIS: Calculate totals for all pages ===
                         function parseValue(i) {
                             return typeof i === 'string' ?
                                 parseFloat(i.replace(/[^\d.-]/g, '')) || 0 :
                                 typeof i === 'number' ? i : 0;
                         }

                         var seatTotalAll = api.column(8, {
                             page: 'all'
                         }).data().reduce(function(a, b) {
                             return parseValue(a) + parseValue(b);
                         }, 0);

                         var serviceTotalAll = api.column(9, {
                             page: 'all'
                         }).data().reduce(function(a, b) {
                             return parseValue(a) + parseValue(b);
                         }, 0);

                         var grandTotalAll = api.column(10, {
                             page: 'all'
                         }).data().reduce(function(a, b) {
                             return parseValue(a) + parseValue(b);
                         }, 0);

                         var discountTotalAll = api.column(11, {
                             page: 'all'
                         }).data().reduce(function(a, b) {
                             return parseValue(a) + parseValue(b);
                         }, 0);

                         var payableAll = api.column(12, {
                             page: 'all'
                         }).data().reduce(function(a, b) {
                             return parseValue(a) + parseValue(b);
                         }, 0);

                         var paidAll = api.column(13, {
                             page: 'all'
                         }).data().reduce(function(a, b) {
                             return parseValue(a) + parseValue(b);
                         }, 0);


                         var dueAll = api.column(14, {
                             page: 'all'
                         }).data().reduce(function(a, b) {
                             return parseValue(a) + parseValue(b);
                         }, 0);

                         var refundAll = api.column(16, {
                             page: 'all'
                         }).data().reduce(function(a, b) {
                             return parseValue(a) + parseValue(b);
                         }, 0);

                         // Update footer cells in PDF with all-pages totals
                         footerRow[8].text = seatTotalAll.toFixed(2);
                         footerRow[9].text = serviceTotalAll.toFixed(2);
                         footerRow[10].text = grandTotalAll.toFixed(2);
                         footerRow[11].text = discountTotalAll.toFixed(2);
                         footerRow[12].text = payableAll.toFixed(2);
                         footerRow[13].text = paidAll.toFixed(2);
                         footerRow[14].text = dueAll.toFixed(2);
                         footerRow[16].text = refundAll.toFixed(2);

                         // Optionally make footer bold
                         [8, 9, 10].forEach(function(i) {
                             footerRow[i].bold = true;
                         });
                     }
                 }
             ],

             order: [
                 [4, 'desc'],
                 [3, 'desc']
             ],

             footerCallback: function(row, data, start, end, display) {
                 var api = this.api();

                 // Helper to parse string to float
                 var parseValue = function(i) {
                     return typeof i === 'string' ?
                         parseFloat(i.replace(/[^\d.-]/g, '')) || 0 :
                         typeof i === 'number' ? i : 0;
                 };

                 // Total calculations
                 var seatTotal = api.column(8, {
                     page: 'current'
                 }).data().reduce(function(a, b) {
                     return parseValue(a) + parseValue(b);
                 }, 0);

                 // Total for service_charge (column 9)
                 var serviceTotal = api.column(9, {
                     page: 'current'
                 }).data().reduce(function(a, b) {
                     return parseValue(a) + parseValue(b);
                 }, 0);

                 // Total for total (column 10)
                 var grandTotal = api.column(10, {
                     page: 'current'
                 }).data().reduce(function(a, b) {
                     return parseValue(a) + parseValue(b);
                 }, 0);

                 var discountTotal = api.column(11, {
                     page: 'current'
                 }).data().reduce(function(a, b) {
                     return parseValue(a) + parseValue(b);
                 }, 0);

                 var payableAll = api.column(12, {
                     page: 'current'
                 }).data().reduce(function(a, b) {
                     return parseValue(a) + parseValue(b);
                 }, 0);

                 var paidAll = api.column(13, {
                     page: 'current'
                 }).data().reduce(function(a, b) {
                     return parseValue(a) + parseValue(b);
                 }, 0);


                 var dueAll = api.column(14, {
                     page: 'current'
                 }).data().reduce(function(a, b) {
                     return parseValue(a) + parseValue(b);
                 }, 0);

                 var refundAll = api.column(16, {
                     page: 'all'
                 }).data().reduce(function(a, b) {
                     return parseValue(a) + parseValue(b);
                 }, 0);

                 // Update footer cells
                 $(api.column(8).footer()).html(seatTotal.toFixed(2));
                 $(api.column(9).footer()).html(serviceTotal.toFixed(2));
                 $(api.column(10).footer()).html(grandTotal.toFixed(2));
                 $(api.column(11).footer()).html(discountTotal.toFixed(2));
                 $(api.column(12).footer()).html(payableAll.toFixed(2));
                 $(api.column(13).footer()).html(paidAll.toFixed(2));
                 $(api.column(14).footer()).html(dueAll.toFixed(2));
                 $(api.column(16).footer()).html(refundAll.toFixed(2));
             }
         });

         var payment_form_url = "{{ route('admin.booking.makeBookingPayments') }}";
         var submit_btn_after =
             `<strong>{{ __('admin_local.Saving ') }} &nbsp; <i class="fa fa-rotate-right fa-spin"></i></strong>`;
         var submit_btn_before = `{{ __('admin_local.Submit') }}</strong>`;
         var no_permission_mgs = `{{ __('admin_local.No Permission') }}`;
         var comfirm_btn = `{{ __('admin_local.Ok') }}`;

         var cancel_btn_after =
             `<strong>{{ __('admin_local.Canceling ') }} &nbsp; <i class="fa fa-rotate-right fa-spin"></i></strong>`;
         var cancel_btn_before = `{{ __('admin_local.Cancel') }}</strong>`;

         var delete_swal_title = `{{ __('admin_local.Are you sure?') }}`;
         var delete_swal_text =
             `{{ __('admin_local.Once deleted, you will not be able to recover this data') }}`;
         var delete_swal_cancel_text = `{{ __('admin_local.Delete request canceld successfully') }}`;

         var cancel_swal_title = `{{ __('admin_local.Are you sure?') }}`;
         var cancel_swal_text =
             `{{ __('admin_local.Once cancel, you will not be able to recover this data') }}`;
         var cancelswal_cancel_text = `{{ __('admin_local.Cancel request declied successfully') }}`;

         var base_url = `{{ \URL::to('/') }}/`;

         var no_file = `{{ __('admin_local.No file') }}`;
     </script>
     <script src="{{ asset('public/admin/custom/booking/cancelled.js') }}"></script>
 @endpush
