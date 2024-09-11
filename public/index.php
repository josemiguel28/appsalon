<?php

require_once __DIR__ . '/../includes/app.php';

use Controller\AdminController;
use Controller\APIController;
use Controller\CitaController;
use Controller\CreateAccount;
use Controller\RecoveryController;
use MVC\Router;
use Controller\LoginController;

$router = new Router();

//iniciar sesion
$router->get("/", [LoginController::class, 'login']);
$router->post("/", [LoginController::class, 'login']);
$router->get("/logout", [LoginController::class, 'logout']);

//recuperar password
$router->get("/olvide", [RecoveryController::class, 'olvidePassword']);
$router->post("/olvide", [RecoveryController::class, 'olvidePassword']);
$router->get("/recuperar", [RecoveryController::class, 'recuperarPassword']);
$router->post("/recuperar", [RecoveryController::class, 'recuperarPassword']);

//crear cuenta
$router->get("/crear-cuenta", [CreateAccount::class, 'crearCuenta']);
$router->post("/crear-cuenta", [CreateAccount::class, 'crearCuenta']);
$router->post("/logout", [LoginController::class, 'logout']);

//confirmar cuenta
$router->get("/confirmar-cuenta", [LoginController::class, 'confirmar']);
$router->get("/mensaje", [LoginController::class, 'mensaje']);

//area privada
$router->get("/cita",[CitaController::class,'index']);
$router->get("/admin",[AdminController::class,'index']);

//api de citas
$router->get("/api/servicios",[APIController::class,'index']);
$router->post("/api/citas",[APIController::class,'guardarCita']);
$router->get("/api/citas",[APIController::class,'guardarCita']);

// Comprueba y valida las rutas, que existan y les asigna las funciones del Controlador
$router->comprobarRutas();