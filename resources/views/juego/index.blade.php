@extends('layout')

@section('title')
    titulo
@endsection


@section('content')
<form action="juego" method="POST">
	  <div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<input id="name" name="name" type="text" placeholder="Ingrese su nombre">
				<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
			</div>
		</div>
	</div>
	 <div class="row">
		<div class="col-md-6">
			<div class="form-group">
				<button type="submit">INICIAR JUEGO</button>
			</div>
		</div>
	</div>
</form>
@endsection