<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cartas extends Model
{
     protected $table = 'cartas';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;


    public function jugador(){
    	return $this->belongsTo('App\Jugador', 'id_jugador');
    }
}
