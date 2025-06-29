<?php

namespace App\Models\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function building(){
        return $this->belongsTo(HostelBuilding::class,'building_id','id');
    }
    public function hostel(){
        return $this->belongsTo(Hostel::class,'hostel_id','id');
    }

    public function createdBy(){
        return $this->belongsTo(Admin::class,'created_by','id');
    }

    public function seats(){
        return $this->hasMany(Seat::class,'room_id','id')->where([['status',1],['delete',0]]);
    }
}
