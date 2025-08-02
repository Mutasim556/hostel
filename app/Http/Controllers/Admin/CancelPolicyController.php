<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CancelPolicy;
use Carbon\Carbon;
use Illuminate\Http\Request;

class CancelPolicyController extends Controller
{
    function index(){
        $rpolicies = CancelPolicy::first();
        // dd($rpolicies);
        if(!$rpolicies){
            $create = new CancelPolicy();
            // $create->create_at = Carbon::now();
            $create->save();
        }
        $rpolicies = CancelPolicy::first();
        return view('backend.blade.booking.cancel_policies.index',compact('rpolicies'));
    }

    function store(Request $data){
        $update = CancelPolicy::find(1);

        $update->has_policy_after_booking_started = $data->has_policy_after_booking_started?1:0;
        $update->started_deduction = $data->started_deduction??0;
        $update->started_service_charge_deduction = $data->started_service_charge_deduction??0;
        $update->started_maximum_refund = $data->started_maximum_refund??0;

        $update->has_policy_before_one_day = $data->has_policy_before_one_day?1:0;
        $update->one_day_deduction = $data->one_day_deduction??0;
        $update->one_day_service_charge_deduction = $data->one_day_service_charge_deduction??0;
        $update->one_day_maximum_refund = $data->one_day_maximum_refund??0;

        $update->has_policy_before_two_day = $data->has_policy_before_two_day?1:0;
        $update->two_day_deduction = $data->two_day_deduction??0;
        $update->two_day_service_charge_deduction = $data->two_day_service_charge_deduction??0;
        $update->two_day_maximum_refund = $data->two_day_maximum_refund??0;

        $update->has_policy_before_three_day = $data->has_policy_before_three_day?1:0;
        $update->three_day_deduction = $data->three_day_deduction??0;
        $update->three_day_service_charge_deduction = $data->three_day_service_charge_deduction??0;
        $update->three_day_maximum_refund = $data->three_day_maximum_refund??0;

        $update->has_policy_before_five_day = $data->has_policy_before_five_day?1:0;
        $update->five_day_deduction = $data->five_day_deduction??0;
        $update->five_day_service_charge_deduction = $data->five_day_service_charge_deduction??0;
        $update->five_day_maximum_refund = $data->five_day_maximum_refund??0;

        $update->has_policy_before_seven_day = $data->has_policy_before_seven_day?1:0;
        $update->seven_day_deduction = $data->seven_day_deduction??0;
        $update->seven_day_service_charge_deduction = $data->seven_day_service_charge_deduction??0;
        $update->seven_day_maximum_refund = $data->seven_day_maximum_refund??0;

        $update->has_policy_before_eight_day = $data->has_policy_before_eight_day?1:0;
        $update->eight_day_deduction = $data->eight_day_deduction??0;
        $update->eight_day_service_charge_deduction = $data->eight_day_service_charge_deduction??0;
        $update->eight_day_maximum_refund = $data->eight_day_maximum_refund??0;

        $update->save();

        return back();
    }
}
