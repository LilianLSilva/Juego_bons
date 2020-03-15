@extends('layout')

@section('title')
    titulo
@endsection
@section('content')
<div class="container">
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-2">
			<label class="control-label">Turno</label>
			<span class="form-control" disabled>{{$turno}}</span>
		</div>
		<div class="col-md-2">
			<label class="control-label">Turnos Jugados</label>
			<span class="form-control" disabled>{{$turnos_jugados}}</span>
		</div>

		<div class="col-md-2">
			<label class="control-label">Turnos restantes</label>
			<span class="form-control" disabled>{{$turnos_restantes}}</span>
		</div>
	</div>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-2">
			<div class="page-header header-half menos_top">
				<h4><i class="fa fa-puzzle-piece icon-tit" aria-hidden="true"></i> <small>{{$jugador->nombre}}</small></h4>
			</div>
		</div>
		<div class="col-md-2">
			<label class="control-label">Salud</label>
			<span class="form-control" disabled>{{$juego_jugador->salud}}</span>
		</div>
		  <div class="col-md-2">
		    <label class="control-label">Escudo</label>
		    <span class="form-control" disabled>{{$juego_jugador->escudo}}</span>
		  </div>
	</div>
	<div class="row">
		<div class="col-md-2"></div>
		<div class="col-md-2">
			<div class="page-header header-half menos_top">
				<h4><i class="fa fa-puzzle-piece icon-tit" aria-hidden="true"></i> <small> Monstruo</small></h4>
			</div>
		</div>
		<div class="col-md-2">
			<label class="control-label">Salud</label>
			<span class="form-control" disabled>{{$juego_monstruo->salud}}</span>
		</div>
		  <div class="col-md-2">
		    <label class="control-label">Escudo</label>
		    <span class="form-control" disabled>{{$juego_monstruo->escudo}}</span>
		  </div>
	</div>
	<br>
	<div class="row">
		<div class="col-md-1"></div>
		<div class="col-md-2">
			<div class="page-header header-half menos_top">
				<h4><i class="fa fa-puzzle-piece icon-tit" aria-hidden="true"></i> <small> CARTAS</small></h4>
			</div>
		</div>
		<form action="jugada" class="form-group" method="POST">
			<input type="hidden" name="carta_id" id="carta"></input>
			<input type="hidden" name="_token" value="{{ csrf_token() }}"></input>
		@foreach($jugador->cartas as $carta)
			<div class="col-md-2">
				<label class="control-label">{{$carta->efecto}}</label>
				@switch($carta->efecto)
				    @case('Sanación')
				       <button type="button" id="{{$carta->id}}" class="btn btn-success">{{$carta->valor}}</button>
				        @break
				    @case('Escudo')
				       <button type="button" id="{{$carta->id}}" class="btn btn-secondary">{{$carta->valor}}</button>
				        @break
				     @case('Daño')
				       <button type="button" id="{{$carta->id}}" class="btn btn-danger">{{$carta->valor}}</button>
				        @break
				         @case('Horror')
				       <button type="button"  id="{{$carta->id}}" class="btn btn-dark">{{$carta->valor}}</button>
				        @break

				@endswitch
			</div>
		@endforeach
		</form>
	</div>
</div>
@endsection
@section('script')
$('button').click(function(){
	$('#carta').val(this.id);
	$('form').submit();
})
@endsection