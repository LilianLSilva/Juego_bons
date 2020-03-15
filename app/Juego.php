<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Juego extends Model
{
     protected $table = 'juego';

     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = false;

    protected $attributes = [
        'contador_turno' => 0
    ];

    public function juego_jugador(){
        return $this->hasMany('App\JuegoJugador', 'id_juego');
    }

}
