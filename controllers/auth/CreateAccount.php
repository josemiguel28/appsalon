<?php

namespace Controller\auth;

use Clases\Email;
use Model\ActiveRecord;
use Model\Usuario;
use MVC\Router;

class CreateAccount extends ActiveRecord
{
    public static function crearCuenta(Router $router): void
    {
        $usuario = new Usuario();
        $alertas = [];

        if (isPostBack()) {
            $usuario->sincronizar($_POST);
            $alertas = $usuario->validarDatosNuevaCuenta();

            if (empty($alertas)) {
                if (self::procesarUsuario($usuario)) {
                    header('Location: /mensaje');
                    exit;
                } else {
                    $alertas = Usuario::getAlertas();
                }
            }
        }

        $router->render('auth/crearCuenta', [
            "usuario" => $usuario,
            "alertas" => $alertas
        ]);
    }

    private static function procesarUsuario(Usuario $usuario)
    {
        if ($usuario->isUserRegistered()) {
            return false;
        }

        $usuario->hashPassword();
        $usuario->createToken();
        self::enviarEmail($usuario);
        return $usuario->guardar();
    }

    private static function enviarEmail(Usuario $usuario): void
    {
        $email = new Email($usuario->email, $usuario->nombre, $usuario->token);
        $email->enviarEmail();
    }
}