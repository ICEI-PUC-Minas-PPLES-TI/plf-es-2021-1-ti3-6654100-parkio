<?php

namespace App\Services;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Complain;
use App\Models\Vehicle;


class ComplainService
{

    public function create($description, $plate, int $vehicleId, int $userId,  int $gateId)
    {
        $message = "Veículo reportado com sucesso";
        $created = false;
        $v = Vehicle::find($vehicleId);
        if(!empty($v)) {

                if($gateId != $v->gate_id) { // Cars can't leave on different gates
                    $message = "Vehicle can't go out on this gate!";
                }
                else if(!empty($v->left_at)) { // Cars can't leave if they already left
                    $message = "Vehicle already left";
                }
                else{
                        $v->score = "B";
                        $v->user_out_id = $userId;
                        $v->left_at = date("Y-m-d H:i:s");
                        $v->save();
                    
                        $c = new Complain();
                        $c->description = strtoupper($description);
                        $c->plate = strtoupper($plate);
                        $c->vehicle_id =  $vehicleId;
                        $c->user_id = $userId;
                        $c->save();

                        $created = true;
                    }

         }else {
            $message = "Veiculo não encontrado";
        }

        return [
            'message' => $message,
            'created' => $created
        ];
        
    }


    public function delete(int $id){    
        $complain = Complain::find($id);
        
        if(!empty($complain)){

            $complain->delete();

        }else {

            throw new \Exception("Complain Not Found!", 404);

        }

        return [  'deleted' => true  ];
    }

    public function getAll($plate = null){
        $c = new Complain();

        //Vehicle plate filter
        if(!empty($plate)){
        $c = $c->where('plate','like', '%'.$plate.'%');
        }
            
        return $c
            ->orderByDesc('created_at')
            ->paginate();
    }




}
