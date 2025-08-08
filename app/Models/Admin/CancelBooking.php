<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class CancelBooking extends Model
{
    public function invoice(){
        return $this->belongsTo(BookingInvoice::class,'invoice_id','id');
    }
}
