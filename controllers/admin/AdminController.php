<?php

namespace Controller\admin;

use Clases\Request;
use Controller\api\admin\AppointmentAPI;
use MVC\models\AdminCita;
use MVC\Router;

class AdminController
{
    public static function index(Router $router): void
    {
        $session = new Request();
        $session->startSession();

        //verifica si el admin esta loggeado para proteger la url
        isAdmin();

        $userName = $session->session('nombre');

        date_default_timezone_set('America/Mexico_City');
        $fechaActual = date("Y-m-d");

        // Obtener el filtro de fecha de la petición GET
        $get = new Request();
        $filterDate = $get->get("filtro-fecha");

        // Determinar qué método llamar según la presencia del filtro de fecha
        if (isset($filterDate) && !empty($filterDate)) {
            $citas = AppointmentAPI::filterDate();
            $fechaActual = $filterDate;
        } else {
            $citas = self::getTodayAppointments($fechaActual);
        }

        $noAppointment = self::handleNoAppointmentToday($citas);

        $alertas = AdminCita::getAlertas();

        // Renderizar la vista
        $router->render(
            'admin/index',
            [
                "crrntUser" => $userName,
                "citas" => $citas,
                "fechaActual" => $fechaActual,
                "noAppointment" => $noAppointment,
                "alertas" => $alertas
            ]
        );
    }

    public static function getTodayAppointments($date)
    {
        // Consultar la bd
        $admin = new AdminCita();
        $citas = $admin->getAllCitasFromToday($date);
        return $citas;
    }

    private static function handleNoAppointmentToday($citas)
    {
        // Retorna true si no hay citas; false si hay citas
        return empty($citas);
    }


    private static function appointmentFilterDate()
    {
        $get = new Request();
        $filterDate = $get->get("filtro-fecha");

        if (isset($filterDate)) {
            $filterDateArray = explode("-", $filterDate);
            $checkFilterDate = checkdate($filterDateArray[1], $filterDateArray[2], $filterDateArray[0]);

            if (!$checkFilterDate) {
                AdminCita::setAlerta("error", "Fecha no valida");
                return null;
            }

            // Convertir el array de nuevo a una cadena de fecha
            $filterDate = implode("-", $filterDateArray);
        } else {
            return null;
        }

        echo json_encode(self::getTodayAppointments($filterDate));
    }
}
