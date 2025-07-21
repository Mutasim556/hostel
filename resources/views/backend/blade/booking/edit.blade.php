 @extends('backend.shared.layouts.admin')
 @push('title')
     {{ __('admin_local.Edit Booking') }}
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
     <div class="container-fluid">
         <div class="row">
             <!-- Column -->
             <div class="col-lg-12 mx-auto">
                 <div class="card">
                     <div class="card-header py-3" style="border-bottom: 2px dashed gray">
                         <h3 class="card-title mb-0 text-center">{{ __('admin_local.Edit Booking') }}
                             {{ __('admin_local.Invoice') }} : #{{ str_pad($invoice->id, 8, '0', STR_PAD_LEFT) }}</h3>
                     </div>

                     <div class="card-body">
                        @if(session()->has('success'))
                         <div class="alert alert-success dark alert-dismissible fade show" role="alert"><i
                                 data-feather="thumbs-up"></i>
                             <p> {{ __('admin_local.Booking updated successfully') }}</p>
                             <button class="btn-close" type="button" data-bs-dismiss="alert" aria-label="Close"></button>
                         </div>
                         @endif
                         <form method="POST" action="{{ route('admin.booking.update', $invoice->id) }}"
                             id="add_booking_form" enctype="multipart/form-data">
                             @csrf
                             @method('PUT')
                             <div class="row">
                                 <div id="append_hidden_inputs">
                                     @foreach ($invoice->bookings as $booking)
                                         <input type="hidden" id="h_hostel" name="h_hostel[]"
                                             value="{{ $booking->hostel_id }}">
                                         <input type="hidden" id="h_building" name="h_building[]"
                                             value="{{ $booking->building_id }}">
                                         <input type="hidden" id="h_floor" name="h_floor[]"
                                             value="{{ $booking->floor }}">
                                         <input type="hidden" id="h_room_id" name="h_room_id[]"
                                             value="{{ $booking->room_id }}">
                                         <input type="hidden" id="h_seat_id" name="h_seat_id[]"
                                             value="{{ $booking->seat_id }}">
                                     @endforeach
                                 </div>
                                 <div class="row" id="append_booking_seats">
                                     @foreach ($invoice->bookings as $booking)
                                         <div class="col-lg-3 mt-2">
                                             <input type="text" name="booking_seat_number[]" class="form-control"
                                                 value="{{ $booking->seat->seat_number }}" readonly>
                                         </div>
                                     @endforeach
                                 </div>
                                 <div class="row mt-4">
                                     <u>
                                         <h5>{{ __('admin_local.Booking Informations') }}</h5>
                                     </u>
                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Booking Start Date') }}</label>
                                         <input type="date" name="booking_start_date" id="booking_start_date"
                                             class="form-control" value="{{ $booking->booking_start_date }}" readonly>
                                     </div>
                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Booking End Date') }}</label>
                                         <input type="date" name="booking_end_date" id="booking_end_date"
                                             class="form-control" value="{{ $booking->booking_end_date }}" readonly>
                                     </div>
                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Service Type') }}</label>
                                         <select name="booking_service_type" id="booking_service_type" class="form-control">

                                             @foreach ($services as $service)
                                                 <option value="{{ $service->id }}"
                                                     {{ $service->id == $invoice->service_id ? 'selected' : '' }}>
                                                     {{ $service->service_type }}-{{ $service->service_code }}</option>
                                             @endforeach
                                         </select>
                                     </div>
                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Booking Total Days') }}</label>
                                         <input type="number" name="booking_total_days" id="booking_total_days"
                                             class="form-control"
                                             value="{{ \Carbon\Carbon::parse($invoice->booking_start_date)->diffInDays(\Carbon\Carbon::parse($invoice->booking_end_date)) }}"
                                             readonly>
                                     </div>

                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Total Price') }}</label>
                                         <input type="text" name="booking_total_price" id="booking_total_price"
                                             class="form-control" value="{{ $invoice->seat_price }}" readonly>
                                     </div>
                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Total Service Charge') }}</label>
                                         <input type="text" name="booking_total_service_charge"
                                             id="booking_total_service_charge" class="form-control"
                                             value="{{ $invoice->seat_service_charge }}" readonly>
                                     </div>
                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Total Discount') }}</label>
                                         <input type="text" name="booking_total_discount" id="booking_total_discount"
                                             class="form-control" value="{{ $invoice->discount }}" readonly>
                                     </div>
                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Total Payable') }}</label>
                                         <input type="text" name="booking_total_payable" id="booking_total_payable"
                                             class="form-control" value="{{ $invoice->total_payable }}" readonly>
                                     </div>
                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Total Paid') }}</label>
                                         <input type="text" name="booking_total_paid" id="booking_total_paid"
                                             class="form-control" value="{{ $invoice->total_paid }}" readonly>
                                     </div>
                                     <div class="col-md-3 mb-3">
                                         <label for="">{{ __('admin_local.Total Due') }}</label>
                                         <input type="text" name="booking_total_due" id="booking_total_due"
                                             class="form-control" value="{{ $invoice->total_due }}" readonly>
                                     </div>
                                 </div>
                                 <div class="row mt-4">

                                     <u>
                                         <h5>{{ __('admin_local.Booking Person Informations') }}</h5>
                                     </u>
                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.Phone Number') }}</label>
                                         <input type="text" name="booking_phone_number" id="booking_phone_number"
                                             class="form-control"
                                             value="{{ $invoice->bookingperson->booking_phone_number }}">
                                     </div>
                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.Person Email') }}</label>
                                         <input type="text" name="booking_person_email" id="booking_person_email"
                                             class="form-control"
                                             value="{{ $invoice->bookingperson->booking_person_email }}">
                                     </div>
                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.Person Name') }}</label>
                                         <input type="text" name="booking_person_name" id="booking_person_name"
                                             class="form-control"
                                             value="{{ $invoice->bookingperson->booking_person_name }}">
                                     </div>
                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.Gender') }}</label><br>
                                         <input type="radio" name="booking_person_gender" id="gender_male"
                                             value="Male"
                                             {{ $invoice->bookingperson->booking_person_gender == 'Male' ? 'checked' : '' }}>
                                         {{ __('admin_local.Male') }} &nbsp; &nbsp;
                                         <input type="radio" name="booking_person_gender" id="gender_female"
                                             value="Female"
                                             {{ $invoice->bookingperson->booking_person_gender == 'Female' ? 'checked' : '' }}>
                                         {{ __('admin_local.Female') }}
                                     </div>
                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.Date Of Birth') }}</label>
                                         <input type="date" name="booking_person_dob" id="booking_person_dob"
                                             class="form-control"
                                             value="{{ $invoice->bookingperson->booking_person_dob }}">
                                     </div>

                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.NID Number') }}</label>
                                         <input type="text" name="booking_nid_number" id="booking_nid_number"
                                             class="form-control"
                                             value="{{ $invoice->bookingperson->booking_nid_number }}">
                                     </div>
                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.Address') }}</label>
                                         <textarea class="form-control" name="booking_person_address" id="booking_person_address"
                                             placeholder="Division,District,Thana,Village/Street/Road No">{{ $invoice->bookingperson->booking_person_address }}</textarea>
                                     </div>

                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.Service ID') }}</label>
                                         <input type="text" name="booking_service_id" id="booking_service_id"
                                             class="form-control"
                                             value="{{ $invoice->bookingperson->booking_service_id }}">
                                     </div>
                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.Workplace Address') }}</label>
                                         <textarea class="form-control" name="booking_person_workplace_address" id="booking_person_workplace_address">{{ $invoice->bookingperson->booking_person_workplace_address }}</textarea>
                                     </div>
                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.Image') }}</label>
                                         <input type="file" name="booking_person_image" id="booking_person_image"
                                             class="form-control">
                                     </div>
                                     <div class="col-md-4 mb-3">
                                         <label for="">{{ __('admin_local.NID') }}</label>
                                         <input type="file" name="booking_person_nid" id="booking_person_nid"
                                             class="form-control">
                                     </div>
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
         var base_url = `{{ baseUrl() }}`;
         var total_booking_rooms = parseInt(`{{ count($invoice->bookings) }}`);
     </script>
     <script src="{{ asset('public/admin/custom/booking/edit_booking.js') }}"></script>
 @endpush
