<?php include_once __DIR__ . '/../templates/userLogInfo.php'; ?>

<h1 class="nombre-pagina">Panel de administrador</h1>

<h2>Buscar Citas</h2>
<div class="busqueda">
	<form action="" class="formulario">
		<div class="campo">
			<label for="fecha">Fecha</label>
			<input type="date"
				id="fecha"
				name="fecha">
		</div>
	</form>
</div>

<div class="mostrar-citas">
	<ul class="citas">
		<?php
		$idCita = 0;
		$totalPagar = 0; // Inicializa el total a pagar

		foreach ($citas as $cita) {
			// Evita repetir los datos de la cita
			if ($idCita !== $cita->id) {
				// Muestra el total a pagar de la cita anterior, si no es la primera
				if ($idCita !== 0) {
					echo '<h4>Total a pagar: <span id="total-' . $idCita . '">' . number_format($totalPagar, 2) . '</span> L</h4>';
				}

				// Reinicia el total a pagar para la nueva cita
				$totalPagar = 0;
		?>

				<li>
					<p>ID: <span><?php echo htmlspecialchars($cita->id); ?></span></p>
					<p>Hora: <span><?php echo htmlspecialchars($cita->hora); ?></span></p>
					<p>Cliente: <span><?php echo htmlspecialchars($cita->cliente); ?></span></p>
					<p>E-mail: <span><?php echo htmlspecialchars($cita->email); ?></span></p>
					<p>Teléfono: <span><?php echo htmlspecialchars($cita->telefono); ?></span></p>
					<h3>Servicios</h3>
			<?php
			}

			// Muestra el servicio y actualiza el total a pagar
			echo '<p class="servicio">' . htmlspecialchars($cita->servicio) . ' ' . number_format($cita->precio, 2) . ' L</p>';
			$totalPagar += $cita->precio;

			// Actualiza el ID de la cita
			$idCita = $cita->id;
		}

		// Muestra el total a pagar para la última cita
		if (isset($totalPagar)) {
			echo 'h5>Total a pagar: <span id="total-' . $idCita . '">' . number_format($totalPagar, 2) . '</span> L</h5>';
		}
			?>
				</li>
	</ul>
</div>