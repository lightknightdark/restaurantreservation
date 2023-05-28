<?php

namespace App\Http\Controllers\Admin;

use App\Enums\TableStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\ReservationStoreRequest;
use App\Models\Reservations;
use App\Models\Table;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservations::all();
        return view('admin.reservations.index',compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $table = Table::where('status',TableStatus::Avaliable)->get();
        return view('admin.reservations.create',compact('tables'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ReservationStoreRequest $request)
    {
        $table = Table::findOrFail($request->table_id);
        if($request->guest_number > $table->guest_number){
            return back()->with('warning','Please choose table base on guest');
        }
        $request_data  = Carbon::parse($request->res_date);
        foreach($table->reservations as $res){
            if($res->res_date->format('Y-m-d') == $request_data->format('Y-m-d')){
                return back()->with('warning','this table is reserved for this day');
            }

        }
        Reservations::create($request->validated());

        return to_route('admin.reservation.index')->with('success','reservation create successfully');
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
    public function edit(Reservations $reservation)
    {
        $table = Table::where('status',TableStatus::Avaliable)->get();
        return view('admin.reservations.edit', compact('reservation','tables'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ReservationStoreRequest $request, Reservations $reservation)
    {
        $table = Table::findOrFail($request->table_id);
        if($request->guest_number > $table->guest_number){
            return back()->with('warning','Please choose table base on guest');
        }
        $request_data  = Carbon::parse($request->res_date);
        $reservations = $table->reservations()->where('id','!=',$reservation->id);
        foreach($reservations as $res){
            if($res->res_date->format('Y-m-d') == $request_data->format('Y-m-d')){
                return back()->with('warning','this table is reserved for this day');
            }

        }
        $reservation->update($request->validated());
        return to_route('admin.reservations.index')->with('success','reservation update successfully');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservations $reservation)
    {
        $reservation->delete();
        return to_route('admin.reservations`.index')->with('danger','reservation delete successfully');
    }
}
