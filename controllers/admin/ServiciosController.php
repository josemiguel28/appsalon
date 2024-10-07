<?php

namespace Controller\admin;

use MVC\Router;
use Clases\Request;
use Model\Servicio;

class ServiciosController
{

    public static function index(Router $router)
    {

        $session = new Request();
        $session->startSession();

        isAdmin();

        $userName = $session->session("nombre");

        $servicios = Servicio::all();

        $router->render(
            "/admin/servicios/index",
            [
                "crrntUser" => $userName,
                "servicios" => $servicios
            ]
        );
    }

    public static function crearServicio(Router $router)
    {

        $session = new Request();
        $session->startSession();

        isAdmin();

        $userName = $session->session("nombre");
        $servicio = new Servicio();

        if (isPostBack()) {
            $servicio->sincronizar($_POST);
            $alertas = $servicio->validarCampos();

            if (empty($alertas)) {
                $servicio->guardar();
                redirectToWithMsg("/servicios", "Servicio creado correctamente");
            }
        }

        $router->render(
            "/admin/servicios/crear",
            [
                "crrntUser" => $userName,
                "servicio" => $servicio,
                "alertas" => $alertas
            ]
        );
    }

    public static function actualizarServicio(Router $router)
    {
        $session = new Request();
        $session->startSession();

        isAdmin();

        $userName = $session->session("nombre");
        $servicio = Servicio::find($_GET['id']);

        if (isPostBack()) {
            $servicio = new Servicio();

            $servicio->sincronizar($_POST);

            $alertas = $servicio->validarCampos();

            if (empty($alertas)) {
                $servicio->guardar();
                redirectToWithMsg("/servicios", "Servicio actualizado correctamente");
            }
        }
        $router->render(
            "/admin/servicios/actualizar",
            [
                "crrntUser" => $userName,
                "servicio" => $servicio,
                "alertas" => $alertas
            ]
        );
    }

    public static function eliminarServicio()
    {
        $session = new Request();
        $session->startSession();
        
        isAdmin();
        
        if (isPostBack()) {
            $servicio = new Servicio();
            $servicio = Servicio::find($_POST['id']);
            $servicio->eliminar();

            redirectToWithMsg("/servicios", "Servicio eliminado correctamente");
        }
    }
}
