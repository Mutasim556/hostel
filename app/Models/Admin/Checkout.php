<?php

namespace App\Models\Admin;

use App\Models\Admin;
use Illuminate\Database\Eloquent\Model;

class Checkout extends Model
{
    public function createdUser(){
        return $this->belongsTo(Admin::class,'created_by','id');
    }
}
