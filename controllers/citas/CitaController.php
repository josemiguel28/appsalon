<?php

namespace Controller\citas;

use Clases\Request;
use MVC\Router;

class CitaController
{
    public static function index(Router $router): void
    {
        $request = new Request();
        $request->startSession();
        
        //verifica si el usuario esta autenticado
        isUserAuth();
        
        $userName = $request->session('nombre');
        $idUsuario = $request->session('id');

        date_default_timezone_set('America/Mexico_City');

        $fechaActual = date("Y-m-d");
        
        $router->render('cita/index',
        [
            "crrntUser" => $userName,
            "idUsuario" => $idUsuario,
            "fechaActual" => $fechaActual
        ]);

    }

}
