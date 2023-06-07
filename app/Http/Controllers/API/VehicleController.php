<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\ShowVehicleRequest;
use App\Http\Requests\VehicleRequest;
use App\Http\Requests\VehicleSaleRequest;
use App\Http\Requests\VehicleSupplyRequest;
use App\Models\Car;
use App\Models\Motorcycle;
use App\Models\Vehicle;
use App\Models\VehicleSale;
use App\Models\VehicleSupply;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    public function store(VehicleRequest $request)
    {
        $data = $request->validated();

        Vehicle::create([
            'release_year' => $data['release_year'],
            'color' => $data['color'],
            'price' => $data['price']
        ]);

        $vehicle_id = Vehicle::where('release_year', $data['release_year'])->where('color', $data['color'])->where('price', $data['price'])->first()->value('id');
        
        if($data['vehicle'] == 'mobil'){
            Car::create([
                'vehicle_id' => $vehicle_id,
                'machine' => $data['machine'],
                'passenger_capacity' => $data['passenger_capacity'],
                'type' => $data['type']
            ]);
        }

        if($data['vehicle'] == 'motor'){
            Motorcycle::create([
                'vehicle_id' => $vehicle_id,
                'machine' => $data['machine'],
                'suspension_type' => $data['suspension_type'],
                'transmission_type' => $data['transmission_type']
            ]);
        }

        return response()->json([
            'message' => 'Successfully created vehicle data!',
            'code' => 200,
            'result' => $data
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(ShowVehicleRequest $request)
    {
        $data = $request->validated();
        $vehicle = vehicle::where('id', $data['vehicle_id'])->first(['release_year','color','price','stock']);

        return response()->json([
            'message' => 'Successfully show vehicle stock data!',
            'code' => 200,
            'result' => $vehicle
        ]);

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
    public function update(VehicleRequest $request, string $id)
    {
        $data = $request->validated();

        Vehicle::where('id', $id)->update([
            'release_year' => $data['release_year'],
            'color' => $data['color'],
            'price' => $data['price']
        ]);

        if($data['vehicle'] == 'mobil'){
            Car::where('vehicle_id', $id)->update([
                'machine' => $data['machine'],
                'passenger_capacity' => $data['passenger_capacity'],
                'type' => $data['type']
            ]);
        }

        if($data['vehicle'] == 'motor'){
            Motorcycle::where('vehicle_id', $id)->update([
                'machine' => $data['machine'],
                'suspension_type' => $data['suspension_type'],
                'transmission_type' => $data['transmission_type']
            ]);
        }

        return response()->json([
            'message' => 'Successfully updated vehicle data!',
            'code' => 200,
            'result' => $data,
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Vehicle::destroy($id);

        return response()->json([
            'message' => 'Successfully deleted vehicle data!',
            'code' => 200,
        ]);
    }

    public function sale(VehicleSaleRequest $request)
    {
        $data = $request->validated();
        
        VehicleSale::create($data);

        $vehicle = Vehicle::where('id', $data['vehicle_id']);
        $vehicle->decrement('stock', $data['quantity']);
        $data['stock'] = $vehicle->first()->value('stock');

        return response()->json([
            'message' => 'Successfully added vehicle sale!',
            'code' => 200,
            'result' => $data
        ]);        
    }

    public function supply(VehicleSupplyRequest $request)
    {
        $data = $request->validated();

        VehicleSupply::create($data);

        $vehicle = Vehicle::where('id', $data['vehicle_id']);
        $vehicle->increment('stock', $data['quantity']);
        $data['stock'] = $vehicle->first()->value('stock');

        return response()->json([
            'message' => 'Successfully added vehicle supply!',
            'code' => 200,
            'result' => $data,
        ]);
    }
}
