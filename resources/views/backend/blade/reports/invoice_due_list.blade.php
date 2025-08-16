 @extends('backend.shared.layouts.admin')
 @push('title')
     {{ __('admin_local.Due List') }}
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
     <div class="container-fluid">
         <div class="row">
             <!-- Column -->
             <div class="col-lg-12 mx-auto">
                 <div class="card">
                     <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                         <h3 class="card-title mb-0 text-center">{{ __('admin_local.Due List') }}</h3>
                     </div>

                     <div class="card-body">
                         <div class="row">
                             <div class="col-md-12">
                                 <form action="{{ route('admin.reports.invoiceDueList') }}" id="filter_form" method="GET">
                                     <div class="row bg-info p-4 mb-4 text-center">
                                         <div class="col-md-2">
                                             <label for="">{{ __('admin_local.Start Date') }}</label>
                                             <input type="date" name="start_date"
                                                 value="{{ isset(request()->start_date) ? request()->start_date : '' }}"
                                                 class="form-control">
                                         </div>
                                         <div class="col-md-2">
                                             <label for="">{{ __('admin_local.End Date') }}</label>
                                             <input type="date" name="end_date"
                                                 value="{{ isset(request()->end_date) ? request()->end_date : '' }}"
                                                 class="form-control">
                                         </div>
                                         <div class="col-md-2">
                                             <label for="">{{ __('admin_local.Invoice ID') }}</label>
                                             <input type="text" name="invoice_id"
                                                 value="{{ isset(request()->invoice_id) ? request()->invoice_id : '' }}"
                                                 class="form-control">
                                         </div>
                                         <div class="col-md-3">
                                             <label for="">{{ __('admin_local.Customer Phone') }}</label>
                                             <input type="text" name="phone"
                                                 value="{{ isset(request()->phone) ? request()->phone : '' }}"
                                                 class="form-control">
                                         </div>
                                         {{-- <div class="col-md-2">
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
                                         </div> --}}
                                         <div class="col-md-3">
                                             <label for="">{{ __('admin_local.Received By') }}</label>
                                             <select name="user" class="form-control select2_append">
                                                 <option value="">{{ __('admin_local.Select Please') }}</option>
                                                 @foreach (\App\Models\Admin::where([['status', 1], ['delete', 0]])->get() as $admin)
                                                     <option value="{{ $admin->id }}"
                                                         {{ isset(request()->user) && request()->user == $admin->id ? 'selected' : '' }}>
                                                         {{ $admin->name }}
                                                     </option>
                                                 @endforeach
                                             </select>
                                         </div>
                                         <div class="col-md-12 mt-3" {{--  style="border:1px solid red;"  --}}>
                                             {{-- <label for=""> <span class="text-info"> &nbsp;</span></label><br> --}}
                                             <input type="submit" class="btn btn-primary" style="float:right"
                                                 value="{{ __('admin_local.Search') }}">
                                             <a href="{{ route('admin.reports.invoiceDueList') }}"
                                                 class="btn btn-danger mx-4"
                                                 style="float:right">{{ __('admin_local.Reset') }}</a>
                                         </div>
                                     </div>
                                 </form>
                             </div>

                         </div>

                         <div class="table-responsive theme-scrollbar">
                             <table id="basics-1" class="display table-bordered" style="width: 100%">
                                 <thead>
                                     <tr>
                                         <th>{{ __('admin_local.Invoice Number') }}</th>
                                         <th>{{ __('admin_local.Booking Date') }}</th>
                                         <th>{{ __('admin_local.Booking Phone Number') }}</th>
                                         <th>{{ __('admin_local.Booking Person') }}</th>
                                         <th>{{ __('admin_local.Checkin Date') }}</th>
                                         <th>{{ __('admin_local.Checkout Date') }}</th>
                                         <th>{{ __('admin_local.Booking By') }}</th>
                                         <th>{{ __('admin_local.Total Seat Charge') }}</th>
                                         <th>{{ __('admin_local.Total Service Charge') }}</th>
                                         <th>{{ __('admin_local.Total Discount') }}</th>
                                         <th>{{ __('admin_local.Total Payable') }}</th>
                                         <th>{{ __('admin_local.Total Paid') }}</th>
                                         <th>{{ __('admin_local.Total Due') }}</th>
                                     </tr>
                                 </thead>
                                 <tbody>
                                     @foreach ($invoices as $invoice)
                                         <tr id="trid-{{ $invoice->id }}" data-id="{{ $invoice->id }}">
                                             <td>{{ '#' . sprintf('%08u', $invoice->id) }}</td>
                                             <td>{{ date('Y-m-d', strtotime($invoice->created_at)) }}</td>
                                             <td>{{ $invoice->bookingperson->booking_phone_number }}</td>
                                             <td>{{ $invoice->bookingperson->booking_person_name }}</td>
                                             <td>{{ date('Y-m-d', strtotime($invoice->booking_start_date)) }}</td>
                                             <td>{{ date('Y-m-d', strtotime($invoice->booking_end_date)) }}</td>
                                             <td>{{ $invoice->createuser->name }}</td>
                                             <td>{{ $invoice->seat_price }}</td>
                                             <td>{{ $invoice->seat_service_charge }}</td>
                                             <td>{{ $invoice->discount }}</td>
                                             <td>{{ $invoice->total_payable }}</td>
                                             <td>{{ $invoice->total_paid }}</td>
                                             <td>{{ $invoice->total_due }}</td>
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
                                         <th style="text-align:right">Total:</th>
                                         <th id="seat_charge"></th>
                                         <th id="seat_service_charge"></th>
                                         <th id="discount"></th>
                                         <th id="total_payable"></th>
                                         <th id="total_paid"></th>
                                         <th id="total_due"></th>
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
                 [-1, 10, 25, 50, 100, -1],
                 ["All", 10, 25, 50, 100, "All"]
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
                     filename: 'due_collection_report',
                     className: 'btn btn-info',
                     footer: false,
                     exportOptions: {
                         modifier: {
                             page: 'all' // ✅ export all pages
                         }
                     },
                     customize: function(xlsx) {
                         var api = $('#basics-1').DataTable();

                         // Calculate total for ALL pages
                         function parseValue(i) {
                             return typeof i === 'string' ?
                                 parseFloat(i.replace(/[^\d.-]/g, '')) || 0 :
                                 typeof i === 'number' ?
                                 i :
                                 0;
                         }

                         var seatChargeAll = api.column(7, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatServiceChargeAll = api.column(8, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatDiscountAll = api.column(9, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatPayableAll = api.column(10, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatPaidAll = api.column(11, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatDueAll = api.column(12, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);

                         // Insert total into the Excel footer row
                         var sheet = xlsx.xl.worksheets['sheet1.xml'];

                         // Find the last row number
                         var lastRow = $('row', sheet).last();
                         var rowIndex = parseInt(lastRow.attr('r')) + 1;

                         // Append a new row with the total
                         var newRow =
                             '<row r="' + rowIndex + '">' +
                             // Total text spanning first 5 columns
                             '<c t="inlineStr" r="A' + rowIndex + '" s="2"><is><t></t></is></c>' +
                             '<c t="inlineStr" r="B' + rowIndex + '" s="2"><is><t></t></is></c>' +
                             '<c t="inlineStr" r="C' + rowIndex + '" s="2"><is><t></t></is></c>' +
                             '<c t="inlineStr" r="D' + rowIndex + '" s="2"><is><t></t></is></c>' +
                             '<c t="inlineStr" r="E' + rowIndex + '" s="2"><is><t></t></is></c>' +
                             '<c t="inlineStr" r="F' + rowIndex + '" s="2"><is><t></t></is></c>' +
                             '<c t="inlineStr" r="G' + rowIndex + '" s="2"><is><t>Total:</t></is></c>' +

                             // Total value in 6th column
                             '<c t="n" r="H' + rowIndex + '"><v>' + seatChargeAll.toFixed(2) + '</v></c>' +
                             '<c t="n" r="I' + rowIndex + '"><v>' + seatServiceChargeAll.toFixed(2) +
                             '</v></c>' +
                             '<c t="n" r="J' + rowIndex + '"><v>' + seatDiscountAll.toFixed(2) + '</v></c>' +
                             '<c t="n" r="K' + rowIndex + '"><v>' + seatPayableAll.toFixed(2) + '</v></c>' +
                             '<c t="n" r="L' + rowIndex + '"><v>' + seatPaidAll.toFixed(2) + '</v></c>' +
                             '<c t="n" r="M' + rowIndex + '"><v>' + seatDueAll.toFixed(2) + '</v></c>' +
                             '</row>';

                         sheet.childNodes[0].childNodes[1].innerHTML += newRow;
                     }
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
                     filename: 'due_collection_report',
                     orientation: 'landscape', // ✅ correct spelling
                     pageSize: 'A4',
                     text: '<i class="fa fa-file-pdf-o"></i> PDF',
                     className: 'btn btn-success',
                     footer: true,
                     customize: function(doc) {
                         var api = oTable;

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

                         // Force table to full page width
                         var table = doc.content[doc.content.length - 1].table;
                         table.widths = Array(table.body[0].length).fill('*');

                         // === Totals for all pages ===
                         function parseValue(i) {
                             return typeof i === 'string' ?
                                 parseFloat(i.replace(/[^\d.-]/g, '')) || 0 :
                                 typeof i === 'number' ?
                                 i :
                                 0;
                         }

                         var seatChargeAll = api.column(7, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatServiceChargeAll = api.column(8, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatDiscountAll = api.column(9, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatPayableAll = api.column(10, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatPaidAll = api.column(11, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);
                         var seatDueAll = api.column(12, {
                                 page: 'all'
                             }).data()
                             .reduce(function(a, b) {
                                 return parseValue(a) + parseValue(b);
                             }, 0);

                         footerRow[7].text = seatChargeAll.toFixed(2);
                         footerRow[8].text = seatServiceChargeAll.toFixed(2);
                         footerRow[9].text = seatDiscountAll.toFixed(2);
                         footerRow[10].text = seatPayableAll.toFixed(2);
                         footerRow[11].text = seatPaidAll.toFixed(2);
                         footerRow[12].text = seatDueAll.toFixed(2);
                         footerRow[7].bold = true;
                         footerRow[8].bold = true;
                         footerRow[9].bold = true;
                         footerRow[10].bold = true;
                         footerRow[11].bold = true;
                         footerRow[12].bold = true;
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
                 var seatChargeAll = api.column(7, {
                         page: 'all'
                     }).data()
                     .reduce(function(a, b) {
                         return parseValue(a) + parseValue(b);
                     }, 0);
                 var seatServiceChargeAll = api.column(8, {
                         page: 'all'
                     }).data()
                     .reduce(function(a, b) {
                         return parseValue(a) + parseValue(b);
                     }, 0);
                 var seatDiscountAll = api.column(9, {
                         page: 'all'
                     }).data()
                     .reduce(function(a, b) {
                         return parseValue(a) + parseValue(b);
                     }, 0);
                 var seatPayableAll = api.column(10, {
                         page: 'all'
                     }).data()
                     .reduce(function(a, b) {
                         return parseValue(a) + parseValue(b);
                     }, 0);
                 var seatPaidAll = api.column(11, {
                         page: 'all'
                     }).data()
                     .reduce(function(a, b) {
                         return parseValue(a) + parseValue(b);
                     }, 0);
                 var seatDueAll = api.column(12, {
                         page: 'all'
                     }).data()
                     .reduce(function(a, b) {
                         return parseValue(a) + parseValue(b);
                     }, 0);


                 // Update footer cells
                 $(api.column(7).footer()).html(seatChargeAll.toFixed(2));
                 $(api.column(8).footer()).html(seatServiceChargeAll.toFixed(2));
                 $(api.column(9).footer()).html(seatDiscountAll.toFixed(2));
                 $(api.column(10).footer()).html(seatPayableAll.toFixed(2));
                 $(api.column(11).footer()).html(seatPaidAll.toFixed(2));
                 $(api.column(12).footer()).html(seatDueAll.toFixed(2));
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
