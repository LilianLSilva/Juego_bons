@extends('layout')

@section('title')
    titulo
@endsection

@section('content')
<form action="juego" method="POST">
	  <div class="row">
		  <div class="input-group col-md-6">
		  <div class="input-group-prepend">
		    <span class="input-group-text" id="basic-addon1">Nombre Jugador</span>
		  </div>
		  <input type="text" class="form-control" placeholder="Ingrese su nombre" aria-label="Username" name="name" aria-describedby="basic-addon1">
		  	<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
		</div>
	</div>
	<br>
	 <div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<button type="submit" class="btn btn-primary">INICIAR JUEGO</button>
			</div>
		</div>
	</div>
</form>
@endsection