<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Jugada extends Model
{
     protected $table = 'jugada';

    public function alta(Request $request) {
        // Validate the request...
        $jugada = new Jugada;
        $jugada->id_juego_jugador = $request->id_juego_jugador;
        $jugada->efecto = $request->efecto;
        $jugada->valor = $request->valor;
        $jugada->turno = $request->turno;
        $jugada->save();
    }



    public function modificacion(id $request) {
        // Validate the request...
        $jugador = new Jugada;
        $jugada->id_juego_jugador = $request->id_juego_jugador;
        $jugada->efecto = $request->efecto;
        $jugada->valor = $request->valor;
        $jugada->turno = $request->turno;
        $jugada->save();
    }
}
