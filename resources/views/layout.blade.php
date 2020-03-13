
<!DOCTYPE html>
<html>
    <head>
        <title>Juego Bons - @yield('title')</title>

		<link rel="stylesheet" href="css/estilo.css">	
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
		<script
		  src="https://code.jquery.com/jquery-3.4.1.min.js"
		  integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
		  crossorigin="anonymous"></script>
		
    </head>
    <body>

         @section('sidebar')
		<div class="row">
			<div class="col-md-6">
				<h2><strong>Juego Bons</strong> </h2>
			</div>
		</div>
        @show

        <div class="container">
            @yield('content')
        </div>
    </body>
</html>

