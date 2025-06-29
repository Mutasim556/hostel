<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use App\Models\Admin\Room;
use App\Models\Admin\Seat;
use Illuminate\Http\Request;

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
    public function store(Request $request)
    {
        //
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
}
