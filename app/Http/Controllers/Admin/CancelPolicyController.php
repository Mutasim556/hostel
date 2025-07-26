<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CancelPolicy;
use Illuminate\Http\Request;

class CancelPolicyController extends Controller
{
    function index(){
        $rpolicies = CancelPolicy::first();
        if($rpolicies){
            $create = new CancelPolicy();
            $create->save();
        }
        $rpolicies = CancelPolicy::first();
        return view('backend.blade.booking.cancel_policies.index',compact('rpolicies'));
    }

    function store(Request $data){
        dd($data->all());
    }
}
