<?php

namespace Controller\auth;

use Clases\Request;
use Model\Usuario;
use MVC\Router;

class ConfirmarCuenta
{

    public static function mensaje(Router $router): void
    {
        $router->render('auth/mensaje');
    }

    /**
     * Valida el token proporcionado en la URL.
     *
     * @return Usuario|null Retorna el usuario correspondiente si el token es válido, o null si no lo es.
     */
    private static function validarToken(): ?Usuario
    {
        $request = new Request();
        $tokenFromURL = $request->get("token");

        $usuario = Usuario::where('token', $tokenFromURL);

        if (!$usuario || empty($usuario->token)) {
            return null; // Token inválido
        }

        return $usuario; // Token válido
    }

    /**
     * Confirma la cuenta del usuario utilizando el token proporcionado.
     *
     * @param Router $router Instancia del router para renderizar la vista.
     * @return void
     */
    public static function confirmarCuenta(Router $router): void
    {
        $alertas = [];

        $usuario = self::validarToken();

        if (!$usuario) {
            Usuario::setAlerta('error', "Error, token no válido");
        } else {
            // Confirmar la cuenta y limpiar el token
            $usuario->confirmado = "1";
            $usuario->token = '';
            $usuario->guardar();

            Usuario::setAlerta('exito', "Cuenta confirmada correctamente");
        }

        $alertas = Usuario::getAlertas();

        $router->render(
            'auth/confirmar-cuenta',
            [
                'alertas' => $alertas
            ]
        );
    }
}