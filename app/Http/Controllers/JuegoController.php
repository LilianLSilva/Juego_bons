<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Juego;
use App\jugador;

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
// https://github.com/LilianLSilva/Juego_bons
        // // $this->validate($request,[ 'nombre'=>'required', 'resumen'=>'required', 'npagina'=>'required', 'edicion'=>'required', 'autor'=>'required', 'npagina'=>'required', 'precio'=>'required']);
        // juego::create($request->all());

        $juego = new Juego;
        $juego->save();
        $jugador = new Jugador;
        $jugador_monstruo = new Jugador;
        // print 'La carta que salió de la baraja fue: ' . $efectos[$efecto] . 
        //   ' de ' . $valores[$valor] ;

        $jugador->nombre = $request->name;
        $jugador->tipo =  self::JUGADOR;
        $jugador->save();
        $jugador_monstruo->nombre = 'monstruo';
        $jugador_monstruo->tipo =  self::MONSTRUO;
        $jugador_monstruo->save();

        return view('juego.create')->with('success','Registro creado satisfactoriamente');
        // echo $request;die();
    //     return $request;
    // return view('juego/create',compact('juegos')); 
    }


    private function generar_carta(){
        $efectos = array('Sanación','Moustruo','Escudo','Ataque');
        $valores = array(1,2,3,4,5,6,7,8,9);
        $efecto = array_rand($efectos, 1);
        $valor = array_rand($valores, 1);
        $resultado = ['efecto' => $efecto, 'valor' => $valor];
        return $resultado;
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