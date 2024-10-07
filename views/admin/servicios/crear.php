<h1 class="nombre-pagina">Crear Servicio</h1>
<p class="descripcion-pagina">Llena los campos para añadir un servicio</p>

<?php include_once(__DIR__ . "../../../templates/userLogInfo.php"); ?>
<?php include_once(__DIR__ . "../../../templates/alertas.php"); ?>


<form action="/servicios/crear" method="post" class="formulario">
    <?php include_once __DIR__ . "/formulario.php"; ?>

<input type="submit" class="boton" value="Guardar Servicio">
</form>