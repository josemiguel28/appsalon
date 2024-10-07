<?php include_once __DIR__ . '/../templates/userLogInfo.php'; ?>

<h1 class="nombre-pagina">Panel de administrador</h1>

<h2>Buscar Citas</h2>
<div class="busqueda">

	<?php include_once __DIR__ . '/../templates/alertas.php'; ?>

	<form action="" class="formulario" method="get">
		<div class="campo">
			<label for="fecha">Fecha</label>
			<input type="date"
				id="fecha"
				name="fecha"
				value="<?php echo $fechaActual ?>">
		</div>
	</form>
</div>

<div class="mostrar-citas">

	<?php if ($noAppointment) { ?>
		<p class="no-citas">
			<svg xmlns="http://www.w3.org/2000/svg" width="34" height="34" viewBox="0 0 24 24">
				<path fill="none" stroke="#cccccc" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 21H6a2 2 0 0 1-2-2V7a2 2 0 0 1 2-2h12a2 2 0 0 1 2 2v6.5M16 3v4M8 3v4m-4 4h16m2 11l-5-5m0 5l5-5" />
			</svg>
			<span>No hay citas para este día</span>
		</p>

	<?php } else { ?>

		<ul class="citas">
			<?php
			$idCita = 0;
			$totalPagar = 0;

			foreach ($citas as $cita) {

				// Evita repetir los datos de la cita
				if ($idCita !== $cita->id) {
					if ($idCita !== 0) {
						echo '<h3 class="total__pagar">Total a pagar <span id="total">' . number_format($totalPagar, 2) . " L" . '</span></h3>';
					}

					$totalPagar = 0;
			?>

					<li>
						<p>ID: <span><?php echo htmlspecialchars($cita->id); ?></span></p>
						<p>Hora: <span><?php echo htmlspecialchars($cita->hora); ?></span></p>
						<p>Fecha: <span><?php echo htmlspecialchars($cita->fecha); ?></span></p>
						<p>Cliente: <span><?php echo htmlspecialchars($cita->cliente); ?></span></p>
						<p>E-mail: <span><?php echo htmlspecialchars($cita->email); ?></span></p>
						<p>Teléfono: <span><?php echo htmlspecialchars($cita->telefono); ?></span></p>
						<h3>Servicios</h3>
				<?php
				}

				echo '<p class="servicio"> &#10003; ' . htmlspecialchars($cita->servicio) . ' ' . number_format($cita->precio, 2) . ' L</p>';
				$totalPagar += $cita->precio;

				$idCita = $cita->id;
			}

			if ($totalPagar > 0) {
				echo '<h3 class="total__pagar">Total a pagar <span id="total">' . number_format($totalPagar, 2) . " L" . '</span></h3>';
			}
				?>
					</li>
		</ul>
	<?php } ?>
</div>

<?php
$script = "<script type='module' src='build/js/admin/panel/filter-appointments.js'></script>";
?>