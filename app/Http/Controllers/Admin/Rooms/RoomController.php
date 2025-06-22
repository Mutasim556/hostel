<?php

namespace App\Http\Controllers\Admin\Rooms;

use App\Http\Controllers\Controller;
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
}
