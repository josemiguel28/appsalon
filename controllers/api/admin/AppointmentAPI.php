<?php

namespace Controller\api\admin;

use Controller\admin\AdminController;
use Clases\Request;
use MVC\models\AdminCita;

class AppointmentAPI
{

    public static function filterDate()
    {
        $get = new Request();
        $filterDate = $get->get("filtro-fecha");

        if (isset($filterDate)) {
            echo json_encode(AdminController::getTodayAppointments($filterDate));
        } else {
            return null;
        }

    }
}
