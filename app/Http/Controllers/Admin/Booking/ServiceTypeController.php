<?php

namespace App\Http\Controllers\Admin\Booking;

use App\Http\Controllers\Controller;
use App\Models\Admin\ServiceType;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ServiceTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $servicetypes = ServiceType::where([['delete', 0]])->get();
        return view('backend.blade.booking.service-type.index', compact('servicetypes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $data)
    {
        $rules = [];
        foreach ($data->all() as $key => $value) {
            $rules[$key] = 'required';
        }

        $data->validate($rules);

        $servicetype = new ServiceType();
        $servicetype->service_code = $data->service_code;
        $servicetype->service_type = $data->service_type;
        $servicetype->service_name = $data->service_name;
        $servicetype->room_type = $data->room_type;
        $servicetype->charge = $data->charge;
        $servicetype->save();

        return back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $servicetype = ServiceType::findOrFail($id);
        return response($servicetype);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $data, string $id)
    {
        $servicetype = ServiceType::findOrFail($data->service_id);
        $servicetype->service_code = $data->service_code;
        $servicetype->service_type = $data->service_type;
        $servicetype->service_name = $data->service_name;
        $servicetype->room_type = $data->room_type;
        $servicetype->charge = $data->charge;
        $servicetype->save();

        return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $servicetype = ServiceType::findOrFail($id);
        $servicetype->delete = 1;
        $servicetype->updated_at = Carbon::now();
        $servicetype->save();
        return response($servicetype);
    }

    public function updateStatus(Request $data)
    {
        $servicetype = ServiceType::findOrFail($data->id);
        $servicetype->status = $data->status;
        $servicetype->updated_at = Carbon::now();
        $servicetype->save();
        return response($servicetype);
    }
}
