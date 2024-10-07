<div class="barra">

	<div class="user-name">
		<h4>Hola 👋, <span> <?php echo $crrntUser ?? '' ?> </span></h4>
	</div>

	<div class="log-out">
		<a href="/logout">
			<svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24">
				<path fill="none" stroke="#cccccc" stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
					d="M14 3.095A10 10 0 0 0 12.6 3C7.298 3 3 7.03 3 12s4.298 9 9.6 9q.714 0 1.4-.095M21 12H11m10 0c0-.7-1.994-2.008-2.5-2.5M21 12c0 .7-1.994 2.008-2.5 2.5"
					color="#cccccc" />
			</svg>
		</a>
	</div>
</div>

<?php if ($_SESSION["admin"]): ?>

<div class="barra-servicios">
	<a href="/admin" class="boton">Ver citas</a>
	<a href="/servicios" class="boton">Ver servicios</a>
	<a href="/servicios/crear" class="boton">Nuevo servicio</a>
</div>

<?php endif; ?>