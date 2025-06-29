<?php

namespace App\Http\Controllers\Admin\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Admin\Hostel;
use App\Models\Admin\HostelBuilding;
use App\Models\Admin\Room;
use App\Models\Admin\Seat;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.blade.seats.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hostels = Hostel::where([['status',1],['delete',0]])->get();
        return view('backend.blade.seats.create',compact('hostels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $data)
    {
        $data->validate([
            'hostel'=>'required',
            'floor'=>'required',
            'room'=>'required',
            'seat_number'=>'required',
            'seat_maximum_price'=>'required',
            'seat_minimum_price'=>'required',
            'price_for'=>'required',
        ]);
        // dd($data->room);
        $room = Room::findOrFail($data->room);
        $seat = new Seat();
        $seat->hostel_id = $data->hostel;
        $seat->building_id = $data->building;
        $seat->floor = $data->floor;
        $seat->block = $data->block;
        $seat->room_id = $data->room;
        $seat->room_number = $room->room_number;
        $seat->room_type = $room->room_type;
        $seat->seat_number = $data->seat_number;
        $seat->seat_maximum_price = $data->seat_maximum_price;
        $seat->seat_minimum_price = $data->seat_minimum_price;
        $seat->price_for = $data->price_for;
        $seat->has_any_service_charge = $data->has_any_service_charge?1:0;
        $seat->service_charge = $data->service_charge??0;
        $seat->save();

        return [
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Seat created successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ];

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = explode('-',$id);
        if($data[1]=='hostel'){
            $floors = Room::where('hostel_id',$data[0])->select('floor')->distinct()->get();
            $buildings = HostelBuilding::where('hostel_id',$data[0])->get();
            return [
                'floors'=>$floors,
                'buildings'=>$buildings,
            ];
        }elseif($data[1]=='building'){
            $floors = Room::where('building_id',$data[0])->select('floor')->distinct()->get();
            return [
                'floors'=>$floors,
            ];
        }elseif($data[1]=='floor'){
            // dd($data);
            $blocks = Room::where([['hostel_id',$data[2]],['floor',$data[0]]])->when($data[3]!=null,function($q)use($data){
                return $q->where('building_id',$data[3]);
            })->select('block')->distinct()->get();

            return [
                'blocks'=>$blocks,
            ];
        }elseif($data[1]=='block'){
            $rooms = Room::where([['hostel_id',$data[2]],['building_id',$data[3]],['floor',$data[4]]])->select('id','room_number','block')->get();
            return [
                'rooms'=>$rooms,
            ];
        }
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
}
