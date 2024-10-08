
<?php include_once __DIR__ . '/../templates/userLogInfo.php'; ?>

<h1 class="nombre-pagina">Crear nueva cita</h1>

<p class="descripcion-pagina">Elige tus servicios y coloca tus datos</p>


<div id="app">

		<nav class="tabs">
				<button class="actual" type="button" data-paso="1">Servicios</button>
				<button type="button" data-paso="2">Informacion cita</button>
				<button type="button" data-paso="3">Resumen</button>
		</nav>

		<div id="paso-1" class="seccion">
				<h2>Servicios</h2>
				<p class="text-center">Elige tus servicios a continuación</p>
				<div id="servicios" class="lista-servicios"></div>
		</div>

		<div id="paso-2" class="seccion">
				<h2>Tus datos y cita</h2>
				<p class="text-center">Coloca tus datos y fecha de tu cita</p>

				<form class="formulario">
						<div class="campo">
								<label for="nombre">Nombre</label>
								<input type="text"
								       id="nombre"
								       placeholder="Tu nombre"
								       value="<?php echo $crrntUser; ?>"
								       disabled
								>
						</div>

						<div class="campo">
								<label for="fecha">Fecha</label>
								<input type="date"
								       id="fecha"
								       min="<?php echo $fechaActual ?>"
								>
						</div>

						<div class="campo">
								<label for="hora">Hora</label>
								<input type="time"
								       id="hora"
								>
						</div>

						<input id="idCliente"
						       value="<?php echo $idUsuario; ?>"
						       hidden="hidden"
						>
				</form>
		</div>

		<div id="paso-3" class="seccion mostrar-resumen">
				<h2>Resumen</h2>
				<p class="text-center">Verifica que la información sea correcta</p>
		</div>

		<div class="paginacion">
				<button id="anterior" class="boton">&laquo; Anterior</button>
				<button id="siguiente" class="boton">Siguiente &raquo;</button>
		</div>

</div>

<?php

$script = "<script type='module' src='build/js/app.js'></script>
		<!--sweet alert cdn-->
		<script src='https://cdn.jsdelivr.net/npm/sweetalert2@11'></script>
";
?>
