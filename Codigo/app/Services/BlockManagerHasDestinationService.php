<?php

namespace App\Services;

use App\Models\BlockManagerHasDestination;
use App\Models\Destination;
use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;


class BlockManagerHasDestinationService
{

  public function getAll($userId){
    $mhd = BlockManagerHasDestination::select(DB::raw("distinct block"))
        ->join('destination', 'destination_id','id')
        ->where('user_id',$userId)
        ->whereNull('destination.deleted_at')
        ->get();
    return $mhd;
  }

  public function link($block, $userId){
    $d = Destination::where('block', $block)->pluck('id');
    $v = [];
    foreach ($d as $value) {
      array_push($v, [
        'destination_id'=> $value,
        'user_id' => $userId
      ]);
    }
    try {
      BlockManagerHasDestination::insert($v);
    }catch(QueryException $e){
      BlockManagerHasDestination::where('user_id', $userId)->whereIn('destination_id', $d)->delete();
      $this->link($block,$userId);
    }
    return [ 'message' => "Bloco vinculado com sucesso!" ];
  }

  public function unlink($block, $userId){
    $d = Destination::where('block', $block)->pluck('id');
    BlockManagerHasDestination::where('user_id', $userId)->whereIn('destination_id', $d)->delete();
    return [ 'message' => "Bloco desvinculado com sucesso!" ];
  }

}
