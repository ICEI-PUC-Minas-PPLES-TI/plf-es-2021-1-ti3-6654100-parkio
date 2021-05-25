<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Services\DestinationService;
use App\Services\VisitorCategoryService;
use App\Models\Vehicle;
use App\Models\User;
use App\Models\Complain;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class VehicleService
{
    /**
     * Search for all visitors vehicles
     *
     * @param String|null $plate Vehicle's Plate Filter
     * @return Collection
     */
    public function getAll($plate = null, $model = null, $gate = null, $user = null, $inside = null, $color = null, $driverName = null, $inTime=null, $outTime=null){
        $v = new Vehicle();
        // Filters Begin

        // Vehicle Plate Filter
        if(!empty($plate))
            $v = $v->where('plate','like','%'.$plate.'%');
        // Gate Filter
        if(!empty($gate))
            $v = $v->where('gate_id',$gate);
        // User in and Out Filter
        if(!empty($user)) {
            $v = $v->where(function ($v) use($user) {
                $v->where('user_in_id', $user)
                    ->orWhere('user_out_id', $user);
            });
        }
        //Color Filter

        if(!empty($color))
            $v = $v->where('color',$color);
        //Model Filter
        if(!empty($model))
            $v = $v->where('model','LIKE','%'.$model.'%');
        //Driver Filter
        if(!empty($driverName))
            $v = $v->where('driver_name','LIKE','%'.$driverName.'%');
        //Created at filter
        if(!empty($inTime))
            $v = $v->where('created_at','>=', $inTime);
        //Left at filter
        if(!empty($outTime))
            $v = $v->where('left_at','<=', $outTime.' 23:59:59');
        // Inside Vehicles Filter
        if(!empty($inside)) {
            if($inside)
                $v = $v->whereNull('left_at');
        }

        // End Filters


        return $v
                ->with(['gate:id,description','userIn:id,name','userOut:id,name', 'destination'])
                ->orderByDesc('created_at')
                ->paginate();
    }

    public function create($driverName, $plate, int $time,int $destinationId,int $visitorCategoryId, int $gateId, int $userId, $color=null, $model=null, $cpf=null){

        $vPlate = Vehicle::where('plate', trim(strtoupper($plate)))
                            ->whereNull('left_at')
                            ->first();
        if(!empty($vPlate))
            throw new \Exception("Vehicle already inside");


        $vehicle = new Vehicle();

        $vehicle->driver_name = strtoupper($driverName);
        $vehicle->plate = trim(strtoupper($plate));
        $vehicle->time = $time;
        $vehicle->destination_id = $destinationId;
        $vehicle->visitor_category_id = $visitorCategoryId;
        $vehicle->gate_id = $gateId;
        $vehicle->user_in_id = $userId;
        $vehicle->color = (!empty($color)) ? $color : null;
        $vehicle->model = (!empty($model)) ? $model : null;
        $vehicle->cpf = (!empty($cpf)) ? preg_replace('/[^0-9]/', '', $cpf) : null;
        $vehicle->save();

        return [
            'message' => 'success',
            'created' => true
        ];
    }

    public function search($plate){
        $filtro = strtoupper($plate);
        $complaints = Complain::where('plate', $filtro)->limit(3)->get();
        $vehicle =Vehicle::where('plate','like', "%".$filtro."%")
                    ->orderByDesc('created_at')
                    ->first(['id','plate','model','color','created_at','left_at']);
    
        $vehicle->complaints = $complaints;
        return $vehicle;
    }

    public function get($id){
        try {
            $vehicle = Vehicle::findOrFail($id, ['id','plate','model','color','created_at','left_at','updated_at']);
            return $vehicle;
        } catch (ModelNotFoundException $e){
            throw new ModelNotFoundException("Vehicle not found", 404);
        }
    }

    /**
     * Edit Vehicle Entry
     *
     * @param integer $vehicleId Vehicle ID
     * @param String $score G - Good, B- Bad
     * @param integer $gateId Gate ID
     * @param String $plate Vehicle Registration Plate
     * @param String $model Car Model
     * @param String $color Car Color
     * @return array
     */
    public function edit(int $vehicleId, int $userId,String $score = null, int $gateId = null, String $plate = null, String $model = null, String $color = null){
        $v = Vehicle::find($vehicleId);
        if(!empty($v)) {
            // We will need to refactor this code when auth middleware is done.
            if(!empty($score) && !empty($gateId)) { // Code for doorman's visitor leave function
                if($gateId != $v->gate_id) { // Cars can't leave on different gates
                    throw new \Exception("Vehicle can't go out on this gate!", 405);
                } else if(!empty($v->left_at)) { // Cars can't leave if they already left
                    throw new \Exception("Vehicle already left", 405);
                } else {
                    $v->score = $score;
                    $v->user_out_id = $userId;
                    $v->left_at = date("Y-m-d H:i:s");
                    if($v->save()) {
                        return ['updated' => true];
                    } else {
                        throw new \Exception("Update error!", 500);
                    }
                }
            } else if(!empty($plate) || !empty($model) || !empty($color)){
                $user = User::find($userId);
                if($user->type == 'A' || $user->type == 'R'){

                    $v->plate = (!empty($plate)) ? $plate : $v->plate;
                    $v->color = (!empty($color)) ? $color : $v->color;
                    $v->model = (!empty($model)) ? $model : $v->model;
                    if($v->save()) {
                        return ['updated' => true];
                    } else {
                        throw new \Exception("Update error!", 500);
                    }

                }else{
                    throw new \Exception("Forbidden!", 403);
                }

            } else {
                throw new \Exception("No Action Done", 405);
            }
        } else {
            throw new \Exception("Vehicle Not Found", 404);
        }
    }






}
