<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Juego;
use App\jugador;
use App\juegoJugador;
use App\jugada;
use App\Cartas;

class JuegoController extends Controller
{


    const JUGADOR    = 1;
    const MONSTRUO   = 2;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
    
       return view('juego/index',compact('juegos')); 
       // return view('juego_bons');
    }
   /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function crearJuego(Request $request)
    {

        $juego = new Juego;
        $jugador = new Jugador;
        $jugador_monstruo = new Jugador;
        $juego_jugador = new JuegoJugador;
        $juego_monstruo = new JuegoJugador;

        /*guardo el nuevo Juego*/
        $juego->save();
       
        /*guardo el nuevo jugador*/
        $jugador->nombre = $request->name;
        $jugador->tipo =  self::JUGADOR;
        $jugador->save();

        /*guardo el id_juego y id_jugador en Juego jugador*/
        $juego_jugador->juego()->associate($juego);
        $juego_jugador->jugador()->associate($jugador);
        $juego_jugador->save();

        /*guardo el nuevo Monstruo*/
        $jugador_monstruo->nombre = 'monstruo';
        $jugador_monstruo->tipo =  self::MONSTRUO;
        $jugador_monstruo->save();

        /*guardo el id_juego y id_jugador en Juego jugador Monstruo*/
        $juego_monstruo->juego()->associate($juego);
        $juego_monstruo->jugador()->associate($jugador_monstruo);
        $juego_monstruo->escudo = 10;
        $juego_monstruo->save();

        /*Reparto las cartas al jugador y las guardo*/
        for ($i=0; $i < 4; $i++ ){ 
            $carta_jugador = new Cartas;
            $carta_jugador->jugador()->associate($jugador);
            $carta_jugador->efecto = self::generar_carta()[0];
            $carta_jugador->valor= self::generar_carta()[1];
            $carta_jugador->save();            
        }

        /*Reparto las cartas al Monstruo y las guardo*/
        for ($i=0; $i < 4; $i++) { 
            $carta_monstruo = new Cartas;
            $carta_monstruo->jugador()->associate($jugador_monstruo);
            $carta_monstruo->efecto = self::generar_carta()[0];
            $carta_monstruo->valor= self::generar_carta()[1]; 
            $carta_monstruo->save();           
        }

        /*Muestro el turno, actual, pasados y restantes*/
        $turno = ($juego->contador_turno+1);
        $turnos_jugados= $juego->contador_turno;
        $turnos_restantes = (11 - $turnos_jugados);

        return view('juego.create', ['turno' => $turno, 'turnos_jugados' => $turnos_jugados, 'turnos_restantes' => $turnos_restantes, 'jugador' => $jugador, 'juego_jugador' => $juego_jugador, 'juego_monstruo' => $juego_monstruo]);
       
    }


    public function generar_carta(){
        $efectos = array('Sanación','Horror','Escudo','Daño');
        $valores = array(1,2,3,4,5,6,7,8,9);
        $efecto = array_rand($efectos);
        $valor = array_rand($valores, 1);
        $resultado = [$efectos[$efecto], $valores[$valor]];

        return $resultado;
    }

    public function Jugada(Request $request){

        /*Obtengo el id de la carta y guado el estado de la carga en el campo jugada*/
        $carta_id = (int)$request->carta_id;
        $carta = Cartas::find($carta_id);
        $carta->jugada = 1;
        $carta->save();

        /*Obtengo el registro de JuegoJugador del Jugador actual a partir del cual consigo el id del juego y modifico el contador de turno*/
        $juego_jugador = JuegoJugador::where('id_jugador', $carta->id_jugador)->first();
        $juego = $juego_jugador->juego;
        $juego->contador_turno++;
        $juego->save();

        /*A partir del juego Jugador, guardo en jugada la carta jugada*/
        $jugada =  new Jugada;
        $jugada->juego_jugador()->associate($juego_jugador);
        $jugada->efecto = $carta->efecto;
        $jugada->valor = $carta->valor;
        $jugada->turno = $juego->contador_turno;
        $jugada->save();

        /*A partir del registro de la carta, obtengo el jugador Monstruo */
        $juego_monstruo = $juego->juego_jugador->where('id_jugador', '!=', $carta->id_jugador)->first();

        /*Aplico les Efectos correspondientes a la carta seleccionada*/
        self::afectar($carta, $juego_jugador, $juego_monstruo);

        /*Genero una nueva carta para el jugador*/
        $carta_jugador = new Cartas;
        $carta_jugador->jugador()->associate($juego_jugador->jugador);
        $carta_jugador->efecto = self::generar_carta()[0];
        $carta_jugador->valor= self::generar_carta()[1];
        $carta_jugador->save();

        $carta_monstruo = $juego_monstruo->jugador->cartas->where('jugada', '!=', 1)->random();

        $turno = ($juego->contador_turno+1);
        $turnos_jugados= $juego->contador_turno;
        $turnos_restantes = (12 - $turnos_jugados);

        $juego_monstruo = self::juega_monstruo($carta_monstruo->id);

        $jugador = $juego_jugador->jugador;

        return view('juego.create', ['turno' => $turno, 'turnos_jugados' => $turnos_jugados, 'turnos_restantes' => $turnos_restantes, 'jugador' => $jugador, 'juego_jugador' => $juego_jugador,'juego_monstruo' => $juego_monstruo]);

    }

    public function juega_monstruo($carta_id){

        $carta = Cartas::find($carta_id);
        $carta->jugada = 1;
        $carta->save();

        $jugador = $carta->jugador;
        $juego = $jugador->juego_jugador->juego;
       
        /*Obtengo el registro de JuegoJugador del Jugador actual a partir del cual consigo el id del juego y modifico el contador de turno*/
        $juego_monstruo = JuegoJugador::where('id_jugador', $jugador->id)->first();
        //$juego->contador_turno;
        $juego->save();

        /*A partir del juego Jugador, guardo en jugada la carta jugada*/
        $jugada =  new Jugada;
        $jugada->juego_jugador()->associate($juego_monstruo);
        $jugada->efecto = $carta->efecto;
        $jugada->valor = $carta->valor;
        $jugada->turno = $juego->contador_turno;
        $jugada->save();

        /*A partir del registro de la carta, obtengo el jugador Monstruo */
        /*Aplico les Efectos correspondientes a la carta seleccionada*/
        $juego_jugador = $juego->juego_jugador->where('id_jugador', '!=', $carta->id_jugador)->first();
        self::afectar($carta, $juego_monstruo, $juego_jugador);

        /*Genero una nueva carta para el jugador*/
        $carta_monstruo = new Cartas;
        $carta_monstruo->jugador()->associate($juego_monstruo->jugador);
        $carta_monstruo->efecto = self::generar_carta()[0];
        $carta_monstruo->valor= self::generar_carta()[1];
        $carta_monstruo->save();

        
        $juego_monstruo = JuegoJugador::where('id_jugador', $jugador->id)->first();

        return $juego_monstruo;
    }
    /**
     * Aplica  los efectos al enemigo.
     *
     * @return \Illuminate\Http\Response
     */
    public function afectar($carta, $juego_jugador, $juego_contrario)
    {
        //nombre de la carpeta y nombre de la vist
         switch ($carta->efecto) {
            case 'Sanación':
                $juego_jugador->salud = ($juego_jugador->salud + $carta->valor);
                $juego_jugador->save();
                break;
            case 'Daño':
                if(empty($juego_contrario->escudo)){
                    $juego_contrario->salud = ($juego_contrario->salud - $carta->valor);
                    if ($juego_contrario->salud < 0) {
                        $juego_contrario = 0;
                    }
                }else{
                    $juego_contrario->escudo = ($juego_contrario->escudo - $carta->valor);
                    if($juego_contrario->escudo < 0) {
                         $juego_contrario->salud += $juego_contrario->escudo;
                         $juego_contrario->escudo = 0;
                    } 
                }
                $juego_contrario->save();
                break;
            case 'Escudo':
                $juego_jugador->escudo = ($juego_jugador->escudo + $carta->valor);
                $juego_jugador->save();
                break;
            case 'Horror':
                $juego_contrario->escudo = ($juego_contrario->escudo - $carta->valor);
                if($juego_contrario->escudo < 0) {
                         $juego_contrario->escudo = 0;
                    } 
                $juego_contrario->save();
                break;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $this->validate($request,[ 'nombre'=>'required', 'resumen'=>'required', 'npagina'=>'required', 'edicion'=>'required', 'autor'=>'required', 'npagina'=>'required', 'precio'=>'required']);
        // juego::create($request->all());
        // return redirect()->route('juego.index')->with('success','Registro creado satisfactoriamente');
        return 'Creating a new game';
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $juegos=Juego::find($id);
        return  view('juego.show',compact('juegos'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
        $juego=Juego::find($id);
        return view('juego.edit',compact('juego'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)    {
        //
        $this->validate($request,[ 'nombre'=>'required', 'resumen'=>'required', 'npagina'=>'required', 'edicion'=>'required', 'autor'=>'required', 'npagina'=>'required', 'precio'=>'required']);

        Juego::find($id)->update($request->all());
        return redirect()->route('juego.index')->with('success','Registro actualizado satisfactoriamente');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
         Juego::find($id)->delete();
        return redirect()->route('juego.index')->with('success','Registro eliminado satisfactoriamente');
    }


    /**
     * Ejemplo de método REST 
     *
     * @return \Illuminate\Http\Response
     */

    public function getjuegos(){
        $juegos=Juego::all();
        return response()->json($juegos);
    }
}