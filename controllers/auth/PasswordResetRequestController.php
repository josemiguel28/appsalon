<?php

namespace Controller\auth;

use Clases\Email;
use Clases\Request;
use Model\ActiveRecord;
use Model\Usuario;
use MVC\Router;

class PasswordResetRequestController extends ActiveRecord
{
    public static function requestReset(Router $router): void
    {
        $alertas = [];

        if (isPostBack()){

        $auth = new Usuario($_POST);

        $alertas = self::validarEmail($auth);

        if (empty($alertas)) {
            $user = self::findRegisteredUser('email', $auth->email);

            if (!$user) {
                $alertas = Usuario::getAlertas();
                $router->render('auth/olvidePassword', ["alertas" => $alertas]);
                return;
            }

            self::processRequest($user);
        }
            $alertas = Usuario::getAlertas();
            $router->render('auth/olvidePassword', ["alertas" => $alertas]);
        } else {
            $router->render('auth/olvidePassword', ["alertas" => $alertas]);
        }
    }
    

    private static function validarEmail(Usuario $auth): array
    {
        return $auth->validarEmail();
    }

    public static function findRegisteredUser($column, $value)
    {
        //verificar que el usuario exista
        $usuario = Usuario::where($column, $value);

        if ($usuario && $usuario->confirmado === '1') {
            return $usuario;
        }

        Usuario::setAlerta('error', 'La cuenta no existe o no está confirmada');
        return null;
    }

    private static function processRequest(Usuario $user): bool
    {
        try {
            $user->createToken();
            $user->guardar();
            self::sendEmail($user);
            Usuario::setAlerta('exito', 'Revisa tu correo para restablecer tu contraseña');
            return true;
        } catch (\Exception $e) {
            Usuario::setAlerta('error', 'Ocurrió un error al procesar tu solicitud. Inténtalo de nuevo más tarde.');
            return false;
        }
    }

    private static function sendEmail(Usuario $user): void
    {
        $email = new Email($user->email, $user->nombre, $user->token);
        $email->restablecerContrasena();
    }
}

