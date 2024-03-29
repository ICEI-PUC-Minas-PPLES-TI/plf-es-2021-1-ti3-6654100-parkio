<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\DestinationService;

class DestinationController extends Controller
{
    public function getAll(Request $request){
        try {
            $d = new DestinationService();
            return $d->getAll($request->input('search'));
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $this->treatCodeError($e));
        }
    }

    public function create(Request $request){
        //validate essencials fields
        $this->validate($request, [
            'block' => 'required|min:1|max:20',
            'apt' => 'required|min:1|max:20'
        ]);
        try {
            $d = new DestinationService();
            return response()->json(
                $d->create($request->input('block'), $request->input('apt'))
            );
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $this->treatCodeError($e));
        }
    }

    public function update(Request $request, int $id)
    {
        if(!empty($id)){
            $this->validate($request, [
                'block' => 'required|min:1|max:20',
                'apt'   => 'required|min:1|max:20'
            ]);

            try {
                //calls the service and the function create passing datas
                    $d = new DestinationService();
                    return response()->json(
                        $d->update($id, $request->input('block'), $request->input('apt'))
                    );
            }
            catch (\Exception $e) {
                    return response()->json([
                        'error' => $e->getMessage()
                    ], $this->treatCodeError($e));
            }

        }else{
            return response()->json(['error' => 'missing id' ]);
        }
    }

    public function delete(Request $request, int $id){
        if(!empty($id)){
            try {
                $d = new DestinationService();
                return response()->json(
                    $d->delete($id)
                );
            } catch (\Exception $e) {
                return response()->json([
                    'error' => $e->getMessage()
                ], $this->treatCodeError($e));
            }

        }else return response()->json([
            'error' => 'missing id'
        ]);

    }




    //
}
