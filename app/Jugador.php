<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jugador extends Model
{
     protected $table = 'jugador';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function cartas(){
    	return $this->hasMany('App\Cartas', 'id_jugador');
    }
}
