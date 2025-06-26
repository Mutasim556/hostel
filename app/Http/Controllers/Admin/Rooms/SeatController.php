<?php

namespace App\Http\Controllers\Admin\Rooms;

use App\Http\Controllers\Controller;
use App\Models\Admin\Hostel;
use Illuminate\Http\Request;

class SeatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('backend.blade.seats.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $hostels = Hostel::where([['status',1],['delete',0]])->get();
        return view('backend.blade.seats.create',compact('hostels'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
