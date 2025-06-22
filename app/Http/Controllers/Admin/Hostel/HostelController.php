<?php

namespace App\Http\Controllers\Admin\Hostel;

use App\Http\Controllers\Controller;
use App\Models\Admin\Hostel;
use App\Models\Admin\Language;
use App\Models\Admin\Translation;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HostelController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $hosteles = Hostel::where([['status',1],['delete',0]])->get();
        return view('backend.blade.hostel.index',compact('hosteles'));
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
        $data->validate([
            'hostel_name'=>'required',
            'hostel_type'=>'required',
            'hostel_phone'=>'required',
            'hostel_email'=>'email|max:40',
            'concern_person_name'=>'required',
            'concern_person_phone'=>'required',
        ],[
            'hostel_name.required'=>__('admin_local.Hostel name is required'),
            'hostel_type.required'=>__('admin_local.Hostel type is required'),
            'hostel_phone.required'=>__('admin_local.Hostel phone is required'),
            'hostel_email.max'=>__('admin_local.Hostel email should be less then 40 charecters'),
            'hostel_email.email'=>__('admin_local.Invalid email'),
            'concern_person_name.required'=>__('admin_local.Concern person name is required'),
            'concern_person_phone.required'=>__('admin_local.Concern person phone is required'),
        ]);

        $hostel = new Hostel();
        $hostel->hostel_name = $data->hostel_name;
        $hostel->hostel_type = $data->hostel_type;
        $hostel->hostel_phone = $data->hostel_phone;
        $hostel->hostel_email = $data->hostel_email;
        $hostel->hostel_address = $data->hostel_address;
        $hostel->concern_person_name = $data->concern_person_name;
        $hostel->concern_person_phone = $data->concern_person_phone;
        $hostel->concern_person_email = $data->concern_person_email;

        $hostel->save();
        $languages =  Language::where([['status',1],['delete',0]])->get();
        $hostelData = [];
        foreach($languages as $lang){
            $hostel_name = $lang->lang!='en'?'hostel_name_'.$lang->lang:'hostel_name';
            if($data->$hostel_name==null){
                continue;
            }else{
                array_push($hostelData, array(
                    'translationable_type'  => 'App\Models\Admin\Hostel',
                    'translationable_id'    => $hostel->id,
                    'locale'                => $lang->lang,
                    'key'                   => 'hostel_name',
                    'value'                 =>$data->$hostel_name,
                    'created_at'            => Carbon::now(),
                ));
            }

        }
        Translation::insert($hostelData);
        return response([
            'hostel' => Hostel::findOrFail($hostel->id),
            'title' => __('admin_local.Congratulations !'),
            'text' => __('admin_local.Hostel create successfully.'),
            'confirmButtonText' => __('admin_local.Ok'),
            'hasAnyPermission' => hasPermission(['Hostel-update', 'Hostel-delete']),
            'hasEditPermission' => hasPermission(['Hostel-update']),
            'hasDeletePermission' => hasPermission(['Hostel-delete']),
        ], 200);
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
