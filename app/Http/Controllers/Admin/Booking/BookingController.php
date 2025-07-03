<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use App\Models\Admin\Booking;
use App\Models\Admin\BookingInvoice;
use App\Models\Admin\BookingPerson;
use App\Models\Admin\Room;
use App\Models\Admin\Seat;
use Barryvdh\DomPDF\Facade\Pdf;
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
        //
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
        // dd($data->all());
        $check = BookingPerson::where([['booking_phone_number',$data->booking_phone_number]])->first();
        if(!$check){
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

            if($data->booking_person_image){
                $files = $data->booking_person_image;
                $file = time().'bpimage.'.$files->getClientOriginalExtension();
                $file_name = 'public/admin/upload/person_image/'.$file;
                $manager = new ImageManager(new Driver);
                $manager->read($data->booking_person_image)->resize(300,300)->save('public/admin/upload/person_image/'.$file);
                $bookingP->booking_person_image=$file_name;
            }

            if($data->booking_person_nid){
                $file = $data->booking_person_nid;
                $fileName = "NID".time().'.'.$file->getClientOriginalExtension();
                $file->move('public/admin/upload/nid_image/',$fileName);
                $fileName ='public/admin/upload/nid_image/'.$fileName;
            }else{
                $fileName = null;
            }

            $bookingP->booking_person_nid=$file_name;


            $bookingP->save();
        }else{
            $bookingP = BookingPerson::where('booking_phone_number',$data->booking_phone_number)->firstOrFail();
            $bookingP->booking_phone_number = $data->booking_phone_number;
            $bookingP->booking_person_email = $data->booking_person_email;
            $bookingP->booking_person_name = $data->booking_person_name;
            $bookingP->booking_person_gender = $data->booking_person_gender;
            $bookingP->booking_person_dob = $data->booking_person_dob;
            $bookingP->booking_nid_number = $data->booking_nid_number;
            $bookingP->booking_person_address = $data->booking_person_address;
            $bookingP->booking_service_id = $data->booking_service_id;
            $bookingP->booking_person_workplace_address = $data->booking_person_workplace_address;

            if($data->booking_person_image){
                $files = $data->booking_person_image;
                $file = time().'bpimage.'.$files->getClientOriginalExtension();
                $file_name = 'public/admin/upload/person_image/'.$file;
                $manager = new ImageManager(new Driver);
                $manager->read($data->booking_person_image)->resize(300,300)->save('public/admin/upload/person_image/'.$file);
                $bookingP->booking_person_image=$file_name;
            }else{
                $bookingP->booking_person_image=$bookingP->booking_person_image;
            }

            if($data->booking_person_nid){
                $file = $data->booking_person_nid;
                $fileName = "NID".time().'.'.$file->getClientOriginalExtension();
                $file->move('public/admin/upload/nid_image/',$fileName);
                $fileName ='public/admin/upload/nid_image/'.$fileName;
            }else{
                $fileName = $bookingP->booking_person_image;
            }

            $bookingP->booking_person_nid=$file_name;


            $bookingP->save();
        }
        $bookingP = BookingPerson::where([['booking_phone_number',$data->booking_phone_number]])->first();

        $bookingI = new BookingInvoice();
        $bookingI->booking_person = $bookingP->id;
        $bookingI->booking_start_date = date('Y-m-d',strtotime($data->booking_start_date));
        $bookingI->booking_end_date = date('Y-m-d',strtotime($data->booking_end_date));
        $bookingI->seat_price = $data->booking_total_price;
        $bookingI->seat_service_charge = $data->booking_total_service_charge;
        $bookingI->discount = $data->booking_total_discount;
        $bookingI->discount_price = $data->booking_total_payable;
        $bookingI->total_payable = $data->booking_total_payable;
        $bookingI->total_paid = $data->booking_total_paid;
        $bookingI->total_due = $data->booking_total_due;
        $bookingI->payment_status = $data->booking_total_payable==0?0:($data->booking_total_payable==$data->booking_total_paid?1:2);
        $bookingI->created_by = Auth::guard('admin')->user()->id;
        $bookingI->status = 1;
        $bookingI->delete = 0;

        $bookingI->save();


        foreach($data->booking_seat_number as $key=>$value){
            $booking = new Booking();
            $booking->invoice_id  = $bookingI->id;
            $booking->hostel_id = $data->h_hostel[$key];
            $booking->building_id = $data->h_building[$key];
            $booking->floor = $data->h_floor[$key];
            $booking->room_id = $data->h_room_id[$key];
            $booking->seat_id = $data->h_seat_id[$key];
            $booking->booking_person = $bookingP->id;
            $booking->booking_start_date = date('Y-m-d',strtotime($data->booking_start_date));
            $booking->booking_end_date = date('Y-m-d',strtotime($data->booking_end_date));
            $booking->status = 1;
            $booking->delete = 0;
            $booking->save();

            $seat = Seat::where([['id',$data->h_seat_id[$key]]])->firstOrFail();
            $seat->last_booking_start_date =date('Y-m-d',strtotime($data->booking_start_date));
            $seat->last_booking_end_date = date('Y-m-d',strtotime($data->booking_end_date));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function getAvailableSeats(Request $data){
        if($data->booking_type=='day'){
            $rooms = Room::where([
                        ['hostel_id', $data->hostel],
                        ['building_id', $data->building],
                        ['floor', $data->floor],
                    ])
                    ->get();

           foreach($rooms as $key=>$room){
                $seats1 = Seat::where([
                    ['hostel_id', $data->hostel],
                    ['building_id', $data->building],
                    ['floor', $data->floor],
                    ['room_id',$room->id]
                ])->whereDate('last_booking_end_date','<',$data->start_date)->get();
                $seats2 = Seat::where([
                    ['hostel_id', $data->hostel],
                    ['building_id', $data->building],
                    ['floor', $data->floor],
                    ['room_id',$room->id]
                ])->where('last_booking_end_date',null)->get();

                $rooms[$key]->seats = $seats1->merge($seats2);
           }


//             $seats = Seat::where([
//     ['seats.hostel_id', $data->hostel],
//     ['seats.building_id', $data->building],
//     ['seats.floor', $data->floor]
// ])
// ->join('rooms', 'seats.room_id', '=', 'rooms.id')
// ->select(
//     'seats.seat_number',
//     'seats.id as seat_id',
//     'rooms.id as room_id',
//     'rooms.room_number',
//     'rooms.block'
// )
// ->groupBy(
//     'seats.seat_number',
//     'seats.id',
//     'rooms.id',
//     'rooms.room_number',
//     'rooms.block'
// )
// ->get();

            // dd($seats);


            return $rooms;
        }

    }

    public function getBookingInvoices(string $id){
        $bookingI = BookingInvoice::with('booking','bookingperson')->where('id',$id)->first();
        $data = [
            'bookingI'=>$bookingI,
        ];
        $pdf = Pdf::loadView('backend.blade.booking.pdf.booking', $data);
        return $pdf->stream('invoice.pdf');
    }
}
