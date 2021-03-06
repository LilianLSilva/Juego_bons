<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jugada extends Model
{
     protected $table = 'jugada';
     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    public function juego_jugador(){
    	return $this->belongsTo('App\JuegoJugador', 'id_juego_jugador');
    }
}