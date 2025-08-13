<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booking;
use App\Models\Admin\BookingInvoice;
use App\Models\Admin\BookingPayment;
use App\Models\Admin\BookingPerson;
use App\Models\Admin\CancelBooking;
use App\Models\Admin\CancelPolicy;
use App\Models\Admin\Checkout;
use App\Models\Admin\Otp;
use App\Models\Admin\Room;
use App\Models\Admin\Seat;
use App\Models\Admin\ServiceType;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use PhpParser\Node\Expr\Cast\String_;

class BookingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $start_date = NULL;
        $end_date = NULL;
        $invoice_id = NULL;
        $phone_number = NULL;
        if (isset(request()->start_date)) {
            $start_date = request()->start_date;
        }
        if (isset(request()->end_date)) {
            $end_date = request()->end_date;
        }

        if (isset(request()->invoice_id)) {
            $invoice_id = ltrim(request()->invoice_id,'0');
        }
        if (isset(request()->phone_number)) {
            $phone_number = request()->phone_number;
        }

        $bookings  = BookingInvoice::with('bookingperson', 'rooms')
            ->where([['cancel_status', 0], ['checkeout_status', 0]])
            ->when($start_date!=NULL,function($query)use($start_date){
                return $query->whereDate('created_at', '>=', $start_date);
            })
            ->when($end_date!=NULL,function($query)use($end_date){
                return $query->whereDate('created_at', '<=', $end_date);
            })
            ->when($invoice_id!=NULL,function($query)use($invoice_id){
                return $query->where('id', $invoice_id);
            })
            ->when($phone_number!=NULL,function($query)use($phone_number){
                return $query->whereHas('bookingperson',function($q) use($phone_number){
                        $q->where('booking_phone_number',$phone_number);
                });
            })
            ->when(($start_date==NULL &&  $end_date==NULL && $invoice_id==NULL && $phone_number==NULL),function($query){
                return $query->limit(50);
            })
            ->orderBy('id', 'DESC')->get();
        return view('backend.blade.booking.index', compact('bookings'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //  dd(date('n'));
        return view('backend.blade.booking.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $data)
    {
        $data->validate([
            'booking_total_paid' => 'required',
            'booking_service_type' => 'required',
            'booking_phone_number' => 'required',
            'booking_person_name' => 'required',
            'booking_person_address' => 'required',
        ],[
            'booking_service_type.required'=>__('admin_local.Service type required')
        ]);
        $check = BookingPerson::where([['booking_phone_number', $data->booking_phone_number]])->first();
        if (!$check) {
            $bookingP = new BookingPerson();
            $bookingP->booking_phone_number = $data->booking_phone_number;
            $bookingP->booking_person_email = $data->booking_person_email;
            $bookingP->booking_person_name = $data->booking_person_name;
            $bookingP->booking_person_gender = $data->booking_person_gender;
            $bookingP->booking_person_dob = $data->booking_person_dob;
            $bookingP->booking_nid_number = $data->booking_nid_number;
            $bookingP->booking_person_address = $data->booking_person_address;
            $bookingP->booking_service_id = $data->booking_service_id;
            $bookingP->booking_person_workplace_address = $data->booking_person_workplace_address;

            if ($data->booking_person_image) {
                $files = $data->booking_person_image;
                $file = time() . 'bpimage.' . $files->getClientOriginalExtension();
                $file_name = 'public/admin/upload/person_image/' . $file;
                $manager = new ImageManager(new Driver);
                $manager->read($data->booking_person_image)->resize(300, 300)->save('public/admin/upload/person_image/' . $file);
                $bookingP->booking_person_image = $file_name;
            }

            $fileName = null;
            if ($data->booking_person_nid) {
                $file = $data->booking_person_nid;
                $fileName = "NID" . time() . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/upload/nid_image/', $fileName);
                $fileName = 'public/admin/upload/nid_image/' . $fileName;
            } else {
                $fileName = null;
            }

            $bookingP->booking_person_nid = $fileName;


            $bookingP->save();
        } else {
            $bookingP = BookingPerson::where('booking_phone_number', $data->booking_phone_number)->firstOrFail();
            $bookingP->booking_phone_number = $data->booking_phone_number;
            $bookingP->booking_person_email = $data->booking_person_email;
            $bookingP->booking_person_name = $data->booking_person_name;
            $bookingP->booking_person_gender = $data->booking_person_gender;
            $bookingP->booking_person_dob = $data->booking_person_dob;
            $bookingP->booking_nid_number = $data->booking_nid_number;
            $bookingP->booking_person_address = $data->booking_person_address;
            $bookingP->booking_service_id = $data->booking_service_id;
            $bookingP->booking_person_workplace_address = $data->booking_person_workplace_address;

            if ($data->booking_person_image) {
                $files = $data->booking_person_image;
                $file = time() . 'bpimage.' . $files->getClientOriginalExtension();
                $file_name = 'public/admin/upload/person_image/' . $file;
                $manager = new ImageManager(new Driver);
                $manager->read($data->booking_person_image)->resize(300, 300)->save('public/admin/upload/person_image/' . $file);
                $bookingP->booking_person_image = $file_name;
            } else {
                $bookingP->booking_person_image = $bookingP->booking_person_image;
            }

            if ($data->booking_person_nid) {
                $file = $data->booking_person_nid;
                $fileName = "NID" . time() . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/upload/nid_image/', $fileName);
                $fileName = 'public/admin/upload/nid_image/' . $fileName;
            } else {
                $fileName = $bookingP->booking_person_image;
            }

            $bookingP->booking_person_nid = $fileName;


            $bookingP->save();
        }
        $bookingP = BookingPerson::where([['booking_phone_number', $data->booking_phone_number]])->first();

        $bookingI = new BookingInvoice();
        $bookingI->booking_person = $bookingP->id;
        $bookingI->service_id = $data->booking_service_type;
        $bookingI->booking_start_date = date('Y-m-d', strtotime($data->booking_start_date));
        $bookingI->booking_end_date = date('Y-m-d', strtotime($data->booking_end_date));
        $bookingI->seat_price = $data->booking_total_price;
        $bookingI->seat_service_charge = $data->booking_total_service_charge;
        $bookingI->discount = $data->booking_total_discount;
        $bookingI->discount_price = $data->booking_total_payable;
        $bookingI->total_payable = $data->booking_total_payable;
        $bookingI->total_paid = $data->booking_total_paid;
        $bookingI->total_due = $data->booking_total_due;
        $bookingI->payment_status = $data->booking_total_payable == 0 ? 0 : ($data->booking_total_payable == $data->booking_total_paid ? 1 : 2);
        $bookingI->created_by = Auth::guard('admin')->user()->id;
        $bookingI->status = 1;
        $bookingI->delete = 0;

        $bookingI->save();

        $bookingPay = new BookingPayment();
        $bookingPay->invoice_id = $bookingI->id;
        $bookingPay->payment_date = Carbon::now();
        $bookingPay->payable_amount = $bookingI->total_payable;
        $bookingPay->pay_amount = $bookingI->total_paid;
        $bookingPay->due_amount = $bookingI->total_due;
        $bookingPay->payment_method = 'CASH';
        $bookingPay->note = 'Initial Payment';
        $bookingPay->invoice_status = $bookingI->payment_status;
        $bookingPay->created_by = Auth::guard('admin')->user()->id;
        $bookingPay->save();

        foreach ($data->booking_seat_number as $key => $value) {
            $booking = new Booking();
            $booking->invoice_id  = $bookingI->id;
            $booking->hostel_id = $data->h_hostel[$key];
            $booking->building_id = $data->h_building[$key];
            $booking->floor = $data->h_floor[$key];
            $booking->room_id = $data->h_room_id[$key];
            $booking->seat_id = $data->h_seat_id[$key];
            $booking->booking_person = $bookingP->id;
            $booking->booking_start_date = date('Y-m-d', strtotime($data->booking_start_date));
            $booking->booking_end_date = date('Y-m-d', strtotime($data->booking_end_date));
            $booking->status = 1;
            $booking->delete = 0;
            $booking->save();

            $seat = Seat::where([['id', $data->h_seat_id[$key]]])->firstOrFail();
            $seat->last_booking_start_date = date('Y-m-d', strtotime($data->booking_start_date));
            $seat->last_booking_end_date = date('Y-m-d', strtotime($data->booking_end_date));
            $seat->last_booking_status = 1;
            $seat->save();
        }


        return response([
            'bookingI' => $bookingI,
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Booking create successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
        ], 200);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $invoice = BookingInvoice::with('bookingperson', 'bookings.seat', 'bookings.room')->where([['id', $id]])->first();
        // dd($invoice);
        $services = ServiceType::where([['room_type', $invoice->bookings[0]->room->room_type]])->get();
        return view('backend.blade.booking.edit', compact('invoice', 'services'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $id)
    {
        $data->validate([
            'booking_total_paid' => 'required',
            'booking_service_type' => 'required',
        ]);
        $check = BookingPerson::where([['booking_phone_number', $data->booking_phone_number]])->first();
        if (!$check) {
            $bookingP = new BookingPerson();
            $bookingP->booking_phone_number = $data->booking_phone_number;
            $bookingP->booking_person_email = $data->booking_person_email;
            $bookingP->booking_person_name = $data->booking_person_name;
            $bookingP->booking_person_gender = $data->booking_person_gender;
            $bookingP->booking_person_dob = $data->booking_person_dob;
            $bookingP->booking_nid_number = $data->booking_nid_number;
            $bookingP->booking_person_address = $data->booking_person_address;
            $bookingP->booking_service_id = $data->booking_service_id;
            $bookingP->booking_person_workplace_address = $data->booking_person_workplace_address;

            if ($data->booking_person_image) {
                $files = $data->booking_person_image;
                $file = time() . 'bpimage.' . $files->getClientOriginalExtension();
                $file_name = 'public/admin/upload/person_image/' . $file;
                $manager = new ImageManager(new Driver);
                $manager->read($data->booking_person_image)->resize(300, 300)->save('public/admin/upload/person_image/' . $file);
                $bookingP->booking_person_image = $file_name;
            }

            $fileName = null;
            if ($data->booking_person_nid) {
                $file = $data->booking_person_nid;
                $fileName = "NID" . time() . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/upload/nid_image/', $fileName);
                $fileName = 'public/admin/upload/nid_image/' . $fileName;
            } else {
                $fileName = null;
            }

            $bookingP->booking_person_nid = $file_name;


            $bookingP->save();
        } else {
            $bookingP = BookingPerson::where('booking_phone_number', $data->booking_phone_number)->firstOrFail();
            $bookingP->booking_phone_number = $data->booking_phone_number;
            $bookingP->booking_person_email = $data->booking_person_email;
            $bookingP->booking_person_name = $data->booking_person_name;
            $bookingP->booking_person_gender = $data->booking_person_gender;
            $bookingP->booking_person_dob = $data->booking_person_dob;
            $bookingP->booking_nid_number = $data->booking_nid_number;
            $bookingP->booking_person_address = $data->booking_person_address;
            $bookingP->booking_service_id = $data->booking_service_id;
            $bookingP->booking_person_workplace_address = $data->booking_person_workplace_address;

            if ($data->booking_person_image) {
                $files = $data->booking_person_image;
                $file = time() . 'bpimage.' . $files->getClientOriginalExtension();
                $file_name = 'public/admin/upload/person_image/' . $file;
                $manager = new ImageManager(new Driver);
                $manager->read($data->booking_person_image)->resize(300, 300)->save('public/admin/upload/person_image/' . $file);
                $bookingP->booking_person_image = $file_name;
            } else {
                $bookingP->booking_person_image = $bookingP->booking_person_image;
            }

            if ($data->booking_person_nid) {
                $file = $data->booking_person_nid;
                $fileName = "NID" . time() . '.' . $file->getClientOriginalExtension();
                $file->move('public/admin/upload/nid_image/', $fileName);
                $fileName = 'public/admin/upload/nid_image/' . $fileName;
            } else {
                $fileName = $bookingP->booking_person_image;
            }

            $bookingP->booking_person_nid = $fileName;


            $bookingP->save();
        }
        $bookingP = BookingPerson::where([['booking_phone_number', $data->booking_phone_number]])->first();

        $bookingI = BookingInvoice::findOrFail($id);
        $bookingI->booking_person = $bookingP->id;
        $bookingI->service_id = $data->booking_service_type;
        $bookingI->booking_start_date = date('Y-m-d', strtotime($data->booking_start_date));
        $bookingI->booking_end_date = date('Y-m-d', strtotime($data->booking_end_date));
        $bookingI->seat_price = $data->booking_total_price;
        $bookingI->seat_service_charge = $data->booking_total_service_charge;
        $bookingI->discount = $data->booking_total_discount;
        $bookingI->discount_price = $data->booking_total_payable;

        $payable_diff = $bookingI->total_payable - $data->booking_total_payable;



        $bookingI->total_payable = $data->booking_total_payable;
        $bookingI->total_paid = $data->booking_total_paid;
        $bookingI->total_due = $data->booking_total_due;
        $bookingI->payment_status = $data->booking_total_payable == 0 ? 0 : ($data->booking_total_payable == $data->booking_total_paid ? 1 : 2);
        // $bookingI->created_by = Auth::guard('admin')->user()->id;
        $bookingI->updated_by = Auth::guard('admin')->user()->id;
        $bookingI->status = 1;
        $bookingI->delete = 0;

        $bookingI->save();
        $prev_due = '';
        foreach (BookingPayment::where([['invoice_id', $id]])->orderBy('id', 'ASC')->get() as $key => $payment) {

            if ($key == 0) {
                $bookingPay = BookingPayment::where([['id', $payment->id]])->firstOrFail();
                $bookingPay->payable_amount = $bookingI->total_payable;
                // $bookingPay->pay_amount = $bookingI->total_paid;
                $bookingPay->due_amount = $bookingI->total_payable - $bookingPay->pay_amount;
                $bookingPay->payment_method = 'CASH';
                $bookingPay->note = 'Initial Payment';
                $bookingPay->invoice_status = $bookingI->payment_status;
                $bookingPay->created_by = Auth::guard('admin')->user()->id;
                $bookingPay->save();
            } else {
                $bookingPay = BookingPayment::where([['id', $payment->id]])->firstOrFail();
                $bookingPay->payable_amount = $prev_due;
                $bookingPay->due_amount = $prev_due - $bookingPay->pay_amount;
                $bookingPay->payment_method = 'CASH';
                $bookingPay->note = 'Initial Payment';
                $bookingPay->invoice_status = $bookingI->payment_status;
                $bookingPay->created_by = Auth::guard('admin')->user()->id;
                // dd( $bookingPay);
                $bookingPay->save();
            }
            $prev_due = $bookingPay->due_amount;
        }

        return back()->with('success', 1);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAvailableSeats(Request $data)
    {
        if ($data->booking_type == 'day') {
            $rooms = Room::when(isset($data->hostel), function ($q) use ($data) {
                return $q->where('hostel_id', $data->hostel);
            })
                ->when(isset($data->building), function ($q) use ($data) {
                    return $q->where('building_id', $data->building);
                })
                ->when(isset($data->floor), function ($q) use ($data) {
                    return $q->where('floor', $data->floor);
                })
                ->when(isset($data->room), function ($q) use ($data) {
                    return $q->whereIn('id', $data->room);
                })
                ->get();

            foreach ($rooms as $key => $room) {
                $seats1 = Seat::when(isset($data->hostel), function ($q) use ($data) {
                    return $q->where('hostel_id', $data->hostel);
                })
                ->when(isset($data->building), function ($q) use ($data) {
                    return $q->where('building_id', $data->building);
                })
                ->when(isset($data->floor), function ($q) use ($data) {
                    return $q->where('floor', $data->floor);
                })
                ->when(isset($room->id), function ($q) use ($room) {
                    return $q->where('room_id', $room->id);
                })
                ->whereDoesntHave('bookings', function($query) use ($data) {
                    $query->whereDate('booking_start_date', '<=', $data->end_date)
                        ->whereDate('booking_end_date', '>', $data->start_date)
                        ->whereDoesntHave('invoice',function($q){
                            $q->where('cancel_status',1);
                        });
                })
                ->get();

                // $seats2 = Seat::when(isset($data->hostel), function ($q) use ($data) {
                //     return $q->where('hostel_id', $data->hostel);
                // })
                // ->when(isset($data->building), function ($q) use ($data) {
                //     return $q->where('building_id', $data->building);
                // })
                // ->when(isset($data->floor), function ($q) use ($data) {
                //     return $q->where('floor', $data->floor);
                // })
                // ->when(isset($room->id), function ($q) use ($room) {
                //     return $q->where('room_id', $room->id);
                // })
                // ->where('last_booking_end_date', null)->get();

                $rooms[$key]->seats = $seats1;
            }
            return $rooms;
        }
    }
    public function getBookingCustomer(string $phone)
    {
        $Vcus = [];
        $customer = BookingPerson::where([['booking_phone_number', 'like', '%' . $phone . '%'], ['delete', 0], ['status', 1]])->first();
        if($customer){
            $Vcus =$customer;
        }
        return $Vcus;
    }
    public function getBookingInvoices(string $id)
    {
        // $booking
        $bookingI = BookingInvoice::with('bookings', 'bookingperson', 'service','canceled','checkout')->where('id', $id)->first();
        $data = [
            'bookingI' => $bookingI,
        ];
        // dd($bookingI);
        $pdf = Pdf::loadView('backend.blade.booking.pdf.booking', $data);
        return $pdf->stream('booking.pdf');
    }


    public function getBookingPayments(string $id)
    {
        $payments = BookingPayment::with('createdBy', 'invoice')->where([['invoice_id', $id], ['delete', 0]])->orderBy('id', 'DESC')->get();
        return $payments;
    }

    public function getBookingPaymentReceipt(string $id)
    {
        $receipt = BookingPayment::with('bookings.hostel', 'createdBy', 'invoice.bookingperson')->where([['id', $id], ['delete', 0]])->first();
        return $receipt;
    }

    public function makeBookingPayments(Request $data)
    {

        $data->merge([
            'paying_amount' => (int) $data->input('paying_amount'),
        ]);
        // dd($data);
        $data->validate([
            'paying_amount' => 'required|integer|min:1',
        ], [
            'paying_amount.min' => __('admin_local.Paying amount is required')
        ]);
        $invoice = BookingInvoice::where('id', $data->payment_invoice_id)->firstOrFail();
        $invoice->total_paid = $invoice->total_paid + $data->paying_amount;
        $invoice->total_due = $invoice->total_due - $data->paying_amount;
        $invoice->payment_status = $invoice->total_due == 0 ? 1 : 2;
        $invoice->save();


        $bookingPay = new BookingPayment();
        $bookingPay->invoice_id = $invoice->id;
        $bookingPay->payment_date = Carbon::now();
        $bookingPay->payable_amount = $data->payable_amount;
        $bookingPay->pay_amount = $data->paying_amount;
        $bookingPay->due_amount = $data->remaining_due;
        $bookingPay->payment_method = $data->payment_method;
        $bookingPay->note = 'PAYMENT';
        $bookingPay->invoice_status = $invoice->payment_status;
        $bookingPay->created_by = Auth::guard('admin')->user()->id;
        $bookingPay->save();

        return response([
            'payment' => BookingPayment::with('createdBy', 'invoice')->findOrFail($bookingPay->id),
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Payment successfully done'),
            'confirmButtonText' => __('admin_local.Ok'),
        ]);
        // dd($invoice);
    }

    public function getBookingPaymentDelete(string $id)
    {
        $payment = BookingPayment::findOrFail($id);
        $payments = BookingPayment::where([['invoice_id', $payment->invoice_id], ['id', '>', $id]])->get();
        foreach ($payments as $key => $value) {
            $update = BookingPayment::findOrFail($value->id);
            $update->payable_amount = $update->payable_amount + $payment->pay_amount;
            $update->due_amount = $update->due_amount + $payment->pay_amount;
            $update->updated_by = Auth::guard('admin')->user()->id;
            $update->save();
        }

        $invoice = BookingInvoice::findOrFail($payment->invoice_id);
        $invoice->total_paid = $invoice->total_paid - $payment->pay_amount;
        $invoice->total_due = $invoice->total_due + $payment->pay_amount;
        $invoice->save();

        $payment->delete = 1;
        $payment->updated_by = Auth::guard('admin')->user()->id;
        $payment->save();
        return response([
            'invoice' => $invoice,
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Payment deleted successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
        ]);
    }

    public function getBookingCancelData(string $id)
    {
        $invoice = BookingInvoice::select('id', 'seat_service_charge', 'total_payable', 'total_paid', 'booking_start_date', 'booking_end_date')->findOrFail($id);
        $total_payable = $invoice->total_payable;
        $total_paid = $invoice->total_paid;
        $seat_service_charge = $invoice->seat_service_charge;
        // $total_payable = $invoice->total_payable;

        $policies = CancelPolicy::first();

        $refund_type = '';

        if ($invoice->booking_start_date > date('Y-m-d')) {
            $refund_type = 'before';
        } else {
            $refund_type = 'after';
        }
        $refund_amount = 0;
        $refund_sc_amount = 0;
        // dd($refund_type);
        if ($refund_type == 'before') {
            $date1 = new DateTime(date('Y-m-d', strtotime($invoice->booking_start_date)));
            $date2 = new DateTime(date('Y-m-d'));

            $diff = $date1->diff($date2);
            // dd($diff->days);
            if ($diff->days == 1 && $policies->has_policy_before_one_day == 1) {
                /** Payable deduction */
                $ref_net_amount =  $total_payable - $seat_service_charge;
                $ref_pay_ded_amount = $ref_net_amount * ($policies->one_day_deduction / 100);

                /** Service charge deduction */
                $ref_sc_ded_amount = $seat_service_charge * ($policies->one_day_service_charge_deduction / 100);



                $total_deduction = $ref_pay_ded_amount + $ref_sc_ded_amount;
                //  dd($total_deduction);
                $refund_sc_amount = $seat_service_charge - $ref_sc_ded_amount;
                $refund_amount = $total_paid - $total_deduction;

                if ($refund_amount > 0 && $policies->one_day_maximum_refund > 0) {
                    $refund_amount = $refund_amount < $policies->one_day_maximum_refund ? $refund_amount : $policies->one_day_maximum_refund;
                }
            } else if ($diff->days == 2 && $policies->has_policy_before_two_day == 1) {
                /** Payable deduction */
                $ref_net_amount =  $total_payable - $seat_service_charge;
                $ref_pay_ded_amount = $ref_net_amount * ($policies->two_day_deduction / 100);

                /** Service charge deduction */
                $ref_sc_ded_amount = $seat_service_charge * ($policies->two_day_service_charge_deduction / 100);



                $total_deduction = $ref_pay_ded_amount + $ref_sc_ded_amount;
                //  dd($total_deduction);
                $refund_sc_amount = $seat_service_charge - $ref_sc_ded_amount;
                $refund_amount = $total_paid - $total_deduction;

                if ($refund_amount > 0 && $policies->two_day_maximum_refund > 0) {
                    $refund_amount = $refund_amount < $policies->two_day_maximum_refund ? $refund_amount : $policies->two_day_maximum_refund;
                }
            } else if ($diff->days == 3 && $policies->has_policy_before_three_day == 1) {
                /** Payable deduction */
                $ref_net_amount =  $total_payable - $seat_service_charge;
                $ref_pay_ded_amount = $ref_net_amount * ($policies->three_day_deduction / 100);

                /** Service charge deduction */
                $ref_sc_ded_amount = $seat_service_charge * ($policies->three_day_service_charge_deduction / 100);



                $total_deduction = $ref_pay_ded_amount + $ref_sc_ded_amount;
                //  dd($total_deduction);
                $refund_sc_amount = $seat_service_charge - $ref_sc_ded_amount;
                $refund_amount = $total_paid - $total_deduction;

                if ($refund_amount > 0 && $policies->three_day_maximum_refund > 0) {
                    $refund_amount = $refund_amount < $policies->three_day_maximum_refund ? $refund_amount : $policies->three_day_maximum_refund;
                }
            } else if ($diff->days > 3 && $diff->days <= 5 && $policies->has_policy_before_five_day == 1) {
                /** Payable deduction */
                $ref_net_amount =  $total_payable - $seat_service_charge;
                $ref_pay_ded_amount = $ref_net_amount * ($policies->five_day_deduction / 100);

                /** Service charge deduction */
                $ref_sc_ded_amount = $seat_service_charge * ($policies->five_day_service_charge_deduction / 100);



                $total_deduction = $ref_pay_ded_amount + $ref_sc_ded_amount;
                //  dd($total_deduction);
                $refund_sc_amount = $seat_service_charge - $ref_sc_ded_amount;
                $refund_amount = $total_paid - $total_deduction;

                if ($refund_amount > 0 && $policies->five_day_maximum_refund > 0) {
                    $refund_amount = $refund_amount < $policies->five_day_maximum_refund ? $refund_amount : $policies->five_day_maximum_refund;
                }
            } else if ($diff->days > 5 && $diff->days <= 7 && $policies->has_policy_before_seven_day == 1) {
                /** Payable deduction */
                $ref_net_amount =  $total_payable - $seat_service_charge;
                $ref_pay_ded_amount = $ref_net_amount * ($policies->seven_day_deduction / 100);

                /** Service charge deduction */
                $ref_sc_ded_amount = $seat_service_charge * ($policies->seven_day_service_charge_deduction / 100);



                $total_deduction = $ref_pay_ded_amount + $ref_sc_ded_amount;
                //  dd($total_deduction);
                $refund_sc_amount = $seat_service_charge - $ref_sc_ded_amount;
                $refund_amount = $total_paid - $total_deduction;

                if ($refund_amount > 0 && $policies->seven_day_maximum_refund > 0) {
                    $refund_amount = $refund_amount < $policies->seven_day_maximum_refund ? $refund_amount : $policies->seven_day_maximum_refund;
                }
            } else if ($diff->days > 7 && $policies->has_policy_before_eight_day == 1) {
                /** Payable deduction */
                $ref_net_amount =  $total_payable - $seat_service_charge;
                $ref_pay_ded_amount = $ref_net_amount * ($policies->eight_day_deduction / 100);

                /** Service charge deduction */
                $ref_sc_ded_amount = $seat_service_charge * ($policies->eight_day_service_charge_deduction / 100);



                $total_deduction = $ref_pay_ded_amount + $ref_sc_ded_amount;
                //  dd($total_deduction);
                $refund_sc_amount = $seat_service_charge - $ref_sc_ded_amount;
                $refund_amount = $total_paid - $total_deduction;

                if ($refund_amount > 0 && $policies->eight_day_maximum_refund > 0) {
                    $refund_amount = $refund_amount < $policies->eight_day_maximum_refund ? $refund_amount : $policies->eight_day_maximum_refund;
                }
            }
        } elseif ($refund_type == 'after') {
            if ($policies->has_policy_after_booking_started == 1) {
                /** Payable deduction */

                $ref_net_amount =  $total_payable - $seat_service_charge;
                $ref_pay_ded_amount = $ref_net_amount * ($policies->started_deduction / 100);
                //  dd($ref_pay_ded_amount);
                /** Service charge deduction */
                $ref_sc_ded_amount = $policies->started_service_charge_deduction>0?$seat_service_charge * ($policies->started_service_charge_deduction / 100):0;



                $total_deduction = $ref_pay_ded_amount + $ref_sc_ded_amount;
                //  dd($total_deduction);
                $refund_sc_amount = $seat_service_charge - $ref_sc_ded_amount;
                $refund_amount = $total_paid - $total_deduction;

                if ($refund_amount > 0 && $policies->started_maximum_refund > 0) {
                    $refund_amount = $refund_amount < $policies->started_maximum_refund ? $refund_amount : $policies->started_maximum_refund;
                }
            }
        }


        return response([
            'invoice' => $invoice,
            'refund_type' => $refund_type,
            'refund_sc_amount' => ceil($refund_sc_amount),
            'refund_amount' => ceil($refund_amount),
        ]);
    }
    public function getBookingCancel(Request $data, string $id)
    {
        // dd($data->all());
        $data->validate([
            'cancel_otp' => 'required',
        ]);
        $invoice = BookingInvoice::with('bookingperson')->where('id', $id)->first();
        $check = Otp::where([['otp_type', 'booking_cancellation'], ['receiver_number', $invoice->bookingperson->booking_phone_number], ['otp_end_time', '>', Carbon::now()], ['otp', $data->cancel_otp]])->first();
        if ($check) {
            if ($data->refund_amount < 0) {
                $data->merge([
                    'paying_amount' => (int) $data->input('paying_amount'),
                ]);
                $data->validate([
                    'paying_amount' => 'required|integer|min:1',
                ], [
                    'paying_amount.min' => __('admin_local.Paying amount is required')
                ]);
                $invoice = BookingInvoice::where('id', $id)->firstOrFail();
                $invoice->total_paid = $invoice->total_paid + $data->paying_amount;
                $invoice->total_due = $invoice->total_due - $data->paying_amount;
                $invoice->payment_status = $invoice->total_due == 0 ? 1 : 2;
                $invoice->save();


                $bookingPay = new BookingPayment();
                $bookingPay->invoice_id = $invoice->id;
                $bookingPay->payment_date = Carbon::now();
                $bookingPay->payable_amount = $data->payable_amount;
                $bookingPay->pay_amount = $data->paying_amount;
                $bookingPay->due_amount = $invoice->total_due;
                $bookingPay->payment_method = $data->payment_method;
                $bookingPay->note = 'CANCEL_PAYMENT';
                $bookingPay->invoice_status = $invoice->payment_status;
                $bookingPay->created_by = Auth::guard('admin')->user()->id;
                $bookingPay->save();
            }

            $invoice = BookingInvoice::where('id', $id)->firstOrFail();
            $invoice->cancel_status = 1;
            $invoice->save();

            $cancel = new CancelBooking();
            $cancel->invoice_id = $invoice->id;
            $cancel->total_payable = $invoice->total_payable;
            $cancel->total_paid = $invoice->total_paid;
            $cancel->total_service_charge = $invoice->seat_service_charge;
            $cancel->service_charge_refund = $data->refund_service_charge > 0 ? $data->refund_service_charge : 0;
            $cancel->refund_amount = $data->refund_amount > 0 ? $data->refund_amount : 0;
            $cancel->refund_otp = $data->cancel_otp;
            $cancel->paying_amount = $data->refund_amount <= 0 ? $data->paying_amount : 0;
            $cancel->payment_method = $data->refund_amount <= 0 ? $data->payment_method : 0;
            $cancel->type = $data->refund_amount < 0 ? 'IN' : ($data->refund_amount == 0 ? 'NUTTRAL' : 'OUT');

            $cancel->save();
            return response([
                'title' => __('admin_local.Congratulations !'),
                'text' => __('admin_local.Invoice canceled successfully.'),
                'confirmButtonText' => __('admin_local.Ok'),
            ]);
        } else {
            return response([
                'message' => __('admin_local.Invalid OTP')
            ], 401);
        }
    }


    public function getCanceledBooking()
    {
        $start_date = NULL;
        $end_date = NULL;
        $invoice_id = NULL;
        $phone_number = NULL;
        if (isset(request()->start_date)) {
            $start_date = request()->start_date;
        }
        if (isset(request()->end_date)) {
            $end_date = request()->end_date;
        }

        if (isset(request()->invoice_id)) {
            $invoice_id = ltrim(request()->invoice_id,'0');
        }
        if (isset(request()->phone_number)) {
            $phone_number = request()->phone_number;
        }


        $bookings  = BookingInvoice::with('bookingperson', 'rooms','canceled')
            ->where([['cancel_status', 1], ['checkeout_status', 0]])
            ->when($start_date!=NULL,function($query)use($start_date){
                return $query->whereDate('cancel_date', '>=', $start_date);
            })
            ->when($end_date!=NULL,function($query)use($end_date){
                return $query->whereDate('cancel_date', '<=', $end_date);
            })
            ->when($invoice_id!=NULL,function($query)use($invoice_id){
                return $query->where('id', $invoice_id);
            })
            ->when($phone_number!=NULL,function($query)use($phone_number){
                return $query->whereHas('bookingperson',function($q) use($phone_number){
                        $q->where('booking_phone_number',$phone_number);
                });
            })
            ->when(($start_date==NULL &&  $end_date==NULL && $invoice_id==NULL && $phone_number==NULL),function($query){
                return $query->limit(50);
            })
            ->orderBy('id', 'DESC')->get();

        return view('backend.blade.booking.canceled', compact('bookings'));
    }

    /** Checkout Methods START*/

    public function getBookingCheckoutData(string $id)
    {
        $invoice = BookingInvoice::where('id', $id)->select('id', 'total_payable','total_due','total_paid')->first();
        return $invoice;
    }


    public function getBookingCheckout(Request $data,string $id){
        $invoice = BookingInvoice::where('id', $id)->firstOrFail();
        $invoice->total_paid = $data->paid_amount+$data->due_amount;
        $invoice->total_due = 0;
        $invoice->payment_status =  $invoice->total_due==0?1:2;
        $invoice->checkeout_status =  1;
        $invoice->checkout_date =  Carbon::now();
        $invoice->save();
        if($data->paying_amount>0){
            $bookingPay = new BookingPayment();
            $bookingPay->invoice_id = $invoice->id;
            $bookingPay->payment_date = Carbon::now();
            $bookingPay->payable_amount = $data->payable_amount;
            $bookingPay->pay_amount = $data->paying_amount;
            $bookingPay->due_amount = 0;
            $bookingPay->payment_method = $data->payment_method;
            $bookingPay->note = 'CHECKOUT_PAYMENT';
            $bookingPay->invoice_status = $invoice->payment_status;
            $bookingPay->created_by = Auth::guard('admin')->user()->id;
            $bookingPay->save();
        }

        $invoice = BookingInvoice::with('bookingperson')->where('id', $id)->firstOrFail();
        $checkout = new Checkout();
        $checkout->invoice_id = $invoice->id;
        $checkout->booking_person = $invoice->bookingperson->id;
        $checkout->booking_person_name = $invoice->bookingperson->booking_person_name;
        $checkout->booking_phone_number = $invoice->bookingperson->booking_phone_number;
        $checkout->booking_person_email = $invoice->bookingperson->booking_person_email;
        $checkout->total_service_charge = $invoice->seat_service_charge;
        $checkout->total_payable = $data->payable_amount;
        $checkout->total_paid = $data->paid_amount;
        $checkout->total_due = $data->due_amount;
        $checkout->total_penalty = $data->penalty_amount;
        $checkout->paying_amount = $data->paying_amount;
        $checkout->paying_method = $data->payment_method;
        $checkout->customer_review = $data->checkout_note;

        $checkout->save();


        return response([
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Checkout successfully done.'),
            'confirmButtonText' => __('admin_local.Ok'),
        ]);
    }

    public function getCheckedoutBooking(){
        $start_date = NULL;
        $end_date = NULL;
        $invoice_id = NULL;
        $phone_number = NULL;
        if (isset(request()->start_date)) {
            $start_date = request()->start_date;
        }
        if (isset(request()->end_date)) {
            $end_date = request()->end_date;
        }

        if (isset(request()->invoice_id)) {
            $invoice_id = ltrim(request()->invoice_id,'0');
        }
        if (isset(request()->phone_number)) {
            $phone_number = request()->phone_number;
        }


        $bookings  = BookingInvoice::with('bookingperson', 'rooms')
            ->where([['cancel_status', 0], ['checkeout_status', 1]])
            ->when($start_date!=NULL,function($query)use($start_date){
                return $query->whereDate('checkout_date', '>=', $start_date);
            })
            ->when($end_date!=NULL,function($query)use($end_date){
                return $query->whereDate('checkout_date', '<=', $end_date);
            })
            ->when($invoice_id!=NULL,function($query)use($invoice_id){
                return $query->where('id', $invoice_id);
            })
            ->when($phone_number!=NULL,function($query)use($phone_number){
                return $query->whereHas('bookingperson',function($q) use($phone_number){
                        $q->where('booking_phone_number',$phone_number);
                });
            })
            ->when(($start_date==NULL &&  $end_date==NULL && $invoice_id==NULL && $phone_number==NULL),function($query){
                return $query->limit(50);
            })
            ->orderBy('id', 'DESC')->get();
        return view('backend.blade.booking.checkedout', compact('bookings'));
    }


    /** Checkout Methods END */
}
