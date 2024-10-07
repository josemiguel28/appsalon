<?php

require_once __DIR__ . '/../includes/app.php';

use Controller\auth\ConfirmarCuenta;
use Controller\auth\CreateAccount;
use Controller\auth\PasswordResetController;
use Controller\auth\PasswordResetRequestController;
use Controller\auth\LoginController;

use Controller\admin\AdminController;
use Controller\admin\ServiciosController;

use Controller\citas\CitaController;

use Controller\api\APIController;
use Controller\api\admin\AppointmentAPI;

use MVC\Router;

$router = new Router();

//iniciar sesion
$router->get("/", [LoginController::class, 'login']);
$router->post("/", [LoginController::class, 'login']);
$router->get("/logout", [LoginController::class, 'logout']);

//recuperar password
$router->get("/olvide", [PasswordResetRequestController::class, 'requestReset']);
$router->post("/olvide", [PasswordResetRequestController::class, 'requestReset']);
$router->get("/recuperar", [PasswordResetController::class, 'changePassword']);
$router->post("/recuperar", [PasswordResetController::class, 'changePassword']);

//crear cuenta
$router->get("/crear-cuenta", [CreateAccount::class, 'crearCuenta']);
$router->post("/crear-cuenta", [CreateAccount::class, 'crearCuenta']);
$router->post("/logout", [LoginController::class, 'logout']);

//confirmar cuenta
$router->get("/confirmar-cuenta", [ConfirmarCuenta::class, 'confirmarCuenta']);
$router->get("/mensaje", [ConfirmarCuenta::class, 'mensaje']);

//area privada
$router->get("/cita",[CitaController::class,'index']);
$router->get("/admin",[AdminController::class,'index']);

//api de citas
$router->get("/api/servicios",[APIController::class,'index']);
$router->post("/api/citas",[APIController::class,'guardarCita']);
$router->get("/api/citas",[APIController::class,'guardarCita']);

//CRUD de servicios
$router->get("/servicios", [ServiciosController::class, 'index']);
$router->get("/servicios/crear", [ServiciosController::class, 'crearServicio']);
$router->post("/servicios/crear", [ServiciosController::class, 'crearServicio']);
$router->get("/servicios/actualizar", [ServiciosController::class, 'actualizarServicio']);
$router->post("/servicios/actualizar", [ServiciosController::class, 'actualizarServicio']);
$router->post("/servicios/eliminar", [ServiciosController::class, 'eliminarServicio']);

//api para filtrar las citas (admin panel)
$router->get("/api/admin/appointment",[AppointmentAPI::class,'filterDate']);


// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();