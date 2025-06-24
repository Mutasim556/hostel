<?php

namespace App\Models\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function hostel(){
        return $this->belongsTo(Hostel::class,'hostel_id','id');
    }

    public function createdBy(){
        return $this->belongsTo(Admin::class,'created_by','id');
    }
}
