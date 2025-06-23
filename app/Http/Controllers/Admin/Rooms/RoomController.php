<?php

namespace App\Http\Controllers\Admin\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Admin\Room;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:room-index,admin')->only('index');
    }
    public function index(){
        return view('backend.blade.room.index');
    }

    public function create(){
        return view('backend.blade.room.create');
    }

    public function store(){

    }

    public function getFloorDetails(Request $data){
        $room = Room::where([['delete',0],['status',1]]);
        $floor = explode('-',$data->floor);
        if($data->hostel_id){
            $room = $room->where('hostel_id',$data->hostel_id);
        }
        if($data->floor){
            $room = $room->where('floor',$floor[0]);
        }
        if($data->block){
            $room = $room->where('block',$data->block);
        }
        $room = $room->get();

        $room_number = ($floor[1]).(str_pad(count($room)>0?count($room):1, 2, '0', STR_PAD_LEFT));
        if($data->block){
            $room_number = $room_number."-".$data->block;
        }
        return $room_number;
    }
}
