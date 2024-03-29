<?php

namespace App\Services;

use App\Models\Destination;
use Illuminate\Support\Facades\DB;


class DestinationService
{

  /**
   * Search for all gates (with pagination)
   *
   * @param String $search Search filter string to find in blocks and/or apartments
   * @return Collection
   */
  public function getAll($search = null){
    $d = new Destination();

    if(!empty($search))
      $d = $d->where(DB::raw("CONCAT(block,' ',apartament)"), 'LIKE' , '%'.$search.'%');

    return $d->orderByRaw('block, apartament')
              ->paginate();
  }

  public function create($block, $apartament){
    $destination = new Destination();
    $destination->block = strtoupper($block);
    $destination->apartament = $apartament;
    $destination->deleted_at = null;
    $destination->save();

    return ['id'=>$destination->id];
  }

  public function update(int $id, $block, $apartament){
    $message = 'Destino editado com sucesso';

    $destination = $this->search($id);

    $destination->block = strtoupper($block);
    $destination->apartament = $apartament;
    $destination->update();
    return [
        'message' => $message,
        'updated' => true
    ];


}

  public function delete(int $id)
  {
      $message = 'Destino removido com sucesso';
      $this->search($id)->delete();
      return [
          'message' => $message,
          'deleted' => true
      ];


  }


  public function search(int $id)
  {
      $destination = Destination::find($id);

      if(!empty($destination)){

          return $destination;

      }else {
          throw new \Exception("Destination Not Found", 404);
      }

  }

}
