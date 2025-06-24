<?php

namespace App\Http\Controllers\Admin\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Admin\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class RoomController extends Controller
{
    public function __construct()
    {
         $this->middleware('permission:room-index,admin')->only('index');
    }
    public function index(){
        $rooms = Room::with('createdBy:id,name','hostel:id,hostel_name')->where([['status',1],['delete',0]])->get();
        // dd($rooms);
        return view('backend.blade.room.index',compact('rooms'));
    }

    public function create(){
        return view('backend.blade.room.create');
    }

    public function store(Request $data){

        $data->validate([
            'hostel'=>'required',
            'floor'=>'required',
            'room_number'=>['required',Rule::unique('rooms')->where(function($q)use($data){
                if($data->has_multiple_block){
                    return $q->where([['room_number',$data->room_number],['block',$data->block],['floor',$data->floor],['hostel_id',$data->hostel],['status',1],['delete',0]]);
                }else{
                    return $q->where([['room_number',$data->room_number],['block','N/A'],['floor',$data->floor],['hostel_id',$data->hostel],['status',1],['delete',0]]);
                }
             })],
            'room_type'=>'required',
            'block'=>'required_if:has_multiple_block,on',
            'room_max_price'=>'required_if:is_full_room_bookable,on',
            'room_min_price'=>'required_if:is_full_room_bookable,on',
            'total_window'=>'required',
            'total_fan'=>'required',
            'total_light'=>'required',
        ],[
            'hostel.required'=>__('admin_local.Please select hostel'),
            'floor.required'=>__('admin_local.Please select floor'),
            'room_number.required'=>__('admin_local.Please enter room number'),
            'room_number.unique'=>__('admin_local.This room number already used'),
            'room_type.required'=>__('admin_local.Please select room type'),
            'block.required_if'=>__('admin_local.Block is required'),
            'room_max_price.required_if'=>__('admin_local.Room price required'),
            'room_min_price.required_if'=>__('admin_local.Room minimum price required'),
            'total_window.required'=>__('admin_local.Total window is required'),
            'total_fan.required'=>__('admin_local.Total fan is required'),
            'total_light.required'=>__('admin_local.Total light is required'),
        ]);

        $room = new Room();
        $room->hostel_id = $data->hostel;
        $room->room_type = $data->room_type;
        $room->floor = $data->floor;
        $room->block = $data->block??'N/A';
        $room->room_number = $data->room_number;
        $room->room_dimension = $data->room_dimension;
        $room->is_full_bookable = $data->is_full_room_bookable?1:0;
        $room->full_room_max_price = $data->room_max_price;
        $room->full_room_min_price = $data->room_min_price;
        $room->has_attached_bath_room = $data->has_attached_bathroom?1:0;
        $room->has_attached_balcony = $data->has_attached_balcony?1:0;
        $room->is_smoking_allowed = $data->is_smoking_allowed?1:0;
        $room->total_window = $data->total_window;
        $room->total_fan = $data->total_fan;
        $room->total_light = $data->total_light;
        $room->has_seats = $data->has_seats?1:0;
        $room->created_by = Auth::guard('admin')->user()->id;

        $room->save();
        return [
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Room created successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ];
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

    public function edit(string $id){
        $room = Room::with('hostel:id,hostel_name')->where([['id',$id],['status',1],['delete',0]])->first();
        return view('backend.blade.room.edit',compact('room'));
    }

    public function update(Request $data,string $id){
        $data->validate([
            'room_number'=>['required',Rule::unique('rooms')->where(function($q)use($data){
                if($data->has_multiple_block){
                    return $q->where([['room_number',$data->room_number],['block',$data->block],['floor',$data->floor],['hostel_id',$data->hostel],['status',1],['delete',0]]);
                }else{
                    return $q->where([['room_number',$data->room_number],['block','N/A'],['floor',$data->floor],['hostel_id',$data->hostel],['status',1],['delete',0]]);
                }
             })->ignore($data->room_id)],
            'room_type'=>'required',
            'block'=>'required_if:has_multiple_block,on',
            'room_max_price'=>'required_if:is_full_room_bookable,on',
            'room_min_price'=>'required_if:is_full_room_bookable,on',
            'total_window'=>'required',
            'total_fan'=>'required',
            'total_light'=>'required',
        ],[
            'hostel.required'=>__('admin_local.Please select hostel'),
            'floor.required'=>__('admin_local.Please select floor'),
            'room_number.required'=>__('admin_local.Please enter room number'),
            'room_number.unique'=>__('admin_local.This room number already used'),
            'room_type.required'=>__('admin_local.Please select room type'),
            'block.required_if'=>__('admin_local.Block is required'),
            'room_max_price.required_if'=>__('admin_local.Room price required'),
            'room_min_price.required_if'=>__('admin_local.Room minimum price required'),
            'total_window.required'=>__('admin_local.Total window is required'),
            'total_fan.required'=>__('admin_local.Total fan is required'),
            'total_light.required'=>__('admin_local.Total light is required'),
        ]);

        $room = Room::findOrFail($id);
        $room->room_type = $data->room_type;
        $room->room_number = $data->room_number;
        $room->room_dimension = $data->room_dimension;
        $room->is_full_bookable = $data->is_full_room_bookable?1:0;
        $room->full_room_max_price = $data->room_max_price;
        $room->full_room_min_price = $data->room_min_price;
        $room->has_attached_bath_room = $data->has_attached_bathroom?1:0;
        $room->has_attached_balcony = $data->has_attached_balcony?1:0;
        $room->is_smoking_allowed = $data->is_smoking_allowed?1:0;
        $room->total_window = $data->total_window;
        $room->total_fan = $data->total_fan;
        $room->total_light = $data->total_light;
        $room->has_seats = $data->has_seats?1:0;

        $room->save();
        return [
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.Room updated successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ];
    }

    public function destroy(string $id) : Response
    {
       $room = Room::findOrFail($id);
        // $room->delete=0;
        $room->delete=1;
        $room->save();
        return response([
            'title'=>__('admin_local.Congratulations !'),
            'text'=>__('admin_local.room deleted successfully.'),
            'confirmButtonText'=>__('admin_local.Ok'),
        ]);
    }

    public function updateStatus(Request $data){
        $room = Room::findOrFail($data->id);
        $room->status=$data->status;
        $room->updated_at=Carbon::now();
        $room->save();
        return response($room);
    }
}
