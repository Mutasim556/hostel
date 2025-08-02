<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Seat extends Model
{
    public function bookings(){
        return $this->hasMany(Booking::class,'seat_id','id');
    }
}
