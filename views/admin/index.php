<?php include_once __DIR__ . '/../templates/userLogInfo.php'; ?><h1 class="nombre-pagina">Panel de administrador</h1><h2>Buscar Citas</h2><div class="busqueda">		<form action="" class="formulario">				<div class="campo">						<label for="fecha">Fecha</label>						<input type="date"						       id="fecha"						       name="fecha"						>				</div>		</form></div><div class="mostrar-citas">		<ul class="citas">        <?php				$idCita = 0; 				        foreach ($citas as $cita) {            if ($idCita !== $cita->id) {        ?>								<li>								<p>ID: <span><?php echo $cita->id; ?></span></p>								<p>Hora: <span><?php echo $cita->hora; ?></span></p>								<p>Cliente: <span><?php echo $cita->cliente; ?></span></p>								<p>Email: <span><?php echo $cita->email; ?></span></p>								<p>Teléfono: <span><?php echo $cita->telefono; ?></span></p>		            		            <h3>Servicios</h3>                        <?php $idCita = $cita->id; } //fin if ?> 				        				        <p class="servicio"> <?php echo $cita->servicio . " " .$cita->precio . " L"; ?> </p>						</li>        <?php } //fin foreach?>		</ul></div>