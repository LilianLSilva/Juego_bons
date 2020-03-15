<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class JuegoJugador extends Model
{
        protected $table = 'juego_jugador';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $attributes = [
        'salud' => 20,
        'escudo' => 0
    ];

    public function jugador(){
    	return $this->belongsTo('App\Jugador', 'id_jugador');
    }

    public function juego(){
    	return $this->belongsTo('App\Juego', 'id_juego');
    }

   }
