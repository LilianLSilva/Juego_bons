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
        //$juegos = Juego::all();
        // $juegos=Juego::orderBy('id','DESC')->paginate(3);
      // return view('juego.index',compact('juegos')); 
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
        //var_dump($jugador);die();
        $jugador->save();
//var_export($jugador);die();
        /*guardo el id_juego y id_jugador en Juego jugador*/
        $juego_jugador->juego()->associate($juego);
        $juego_jugador->jugador()->associate($jugador);
        $juego_jugador->save();

        /*guardo el nuevo Monstru0*/
        $jugador_monstruo->nombre = 'monstruo';
        $jugador_monstruo->tipo =  self::MONSTRUO;
        $jugador_monstruo->save();

        /*guardo el id_juego y id_jugador en Juego jugador Monstruo*/
        $juego_monstruo->juego()->associate($juego);
        $juego_monstruo->jugador()->associate($jugador_monstruo);
        $juego_monstruo->escudo = 10;
        $juego_monstruo->save();

        for ($i=0; $i < 4; $i++ ){ 
            $carta_jugador = new Cartas;
            $carta_jugador->jugador()->associate($jugador);
            $carta_jugador->efecto = self::generar_carta()[0];
            $carta_jugador->valor= self::generar_carta()[1];
            $carta_jugador->save();            
        }


        for ($i=0; $i < 4; $i++) { 
            $carta_monstruo = new Cartas;
            $carta_monstruo->jugador()->associate($jugador_monstruo);
            $carta_monstruo->efecto = self::generar_carta()[0];
            $carta_monstruo->valor= self::generar_carta()[1]; 
            $carta_monstruo->save();           
        }

        $turno = ($juego->contador_turno+1);
        $turnos_jugados= $juego->contador_turno;
        $turnos_restantes = (12 - $turnos_jugados);

        return view('juego.create', ['turno' => $turno, 'turnos_jugados' => $turnos_jugados, 'turnos_restantes' => $turnos_restantes, 'jugador' => $jugador, 'juego_jugador' => $juego_jugador, 'juego_monstruo' => $juego_monstruo]);
        // echo $request;die();
    //     return $request;
    // return view('juego/create',compact('juegos')); 
    }


    private function generar_carta(){
        $efectos = array('Sanación','Horror','Escudo','Daño');
        $valores = array(1,2,3,4,5,6,7,8,9);
        $efecto = array_rand($efectos);
        $valor = array_rand($valores, 1);
        $resultado = [$efectos[$efecto], $valores[$valor]];
       // var_dump($resultado);die();
        return $resultado;
    }

    public function Jugada(Request $request){
        $carta_id = (int)$request->carta_id;
        $carta = Cartas::find($carta_id);
        $carta->jugada = 1;
        $carta->save();

        $juego_jugador = JuegoJugador::where('id_jugador', $carta->id_jugador)->first();
        $juego = $juego_jugador->juego;
        $juego->contador_turno++;

        $jugador = $juego_jugador->jugador;
        $monstruo = $juego->juego_jugador;
        var_dump($monstruo);


        $jugada =  new Jugada;
        $jugada->juego_jugador()->associate($juego_jugador);
        $jugada->efecto = $carta->efecto;
        $jugada->valor = $carta->valor;
        $jugada->turno = $juego->contador_turno;
        $jugada->save();

        $Jugador = Jugador::find($carta->id_jugador);
        switch ($carta->efecto) {
            case 'Sanación':
                
                break;
            case 'Daño':
                # code...
                break;
            case 'Escudo':
                # code...
                break;
            case 'Horror':
                # code...
                break;
        }
        $turno = ($juego->contador_turno+1);
        $turnos_jugados= $juego->contador_turno;
        $turnos_restantes = (12 - $turnos_jugados);

        return view('juego.create', ['turno' => $turno, 'turnos_jugados' => $turnos_jugados, 'turnos_restantes' => $turnos_restantes, 'jugador' => $jugador, 'juego_jugador' => $juego_jugador, 'juego_monstruo' => $juego_monstruo]);

    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //nombre de la carpeta y nombre de la vista
        return view('juego/create');
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