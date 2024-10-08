<?php

namespace Controller\api;

use Model\ActiveRecord;
use Model\Cita;
use Model\Servicio;
use Clases\Request;
use MVC\models\CitaServicio;

class APIController {
    public static function index(): void
    {
        //obtiene los servicios desde la bd y los convierte en json para consumirlo en el front
        $servicios = Servicio::all();
        echo json_encode($servicios);
    }
    
    public static function guardarCita(): void
    {
        $request = new Request();
        
        //guarda la cita y devuelve el resultado
        $cita = new Cita($_POST);
        $resultado = $cita->guardar();
        $citaId = $resultado['id'];
        
        //guarda los servicios en la bd
        $requestServiciosId = $request->post('serviciosId');
        $serviciosId = explode(',',$requestServiciosId);
        
        foreach($serviciosId as $servicioId){
            $args = [
                "citaId" => $citaId,
                "servicioId" => $servicioId
            ];
            
            $citaServicio = new CitaServicio($args);
            $citaServicio->guardar();
        }
        
        echo json_encode($resultado);
    }
}
