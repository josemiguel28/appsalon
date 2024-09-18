<?php

namespace Controller\auth;

use Clases\Email;
use Clases\Request;
use JetBrains\PhpStorm\NoReturn;
use Model\ActiveRecord;
use Model\Usuario;
use MVC\Router;
use PHPMailer\PHPMailer\Exception;

class LoginController extends ActiveRecord
{
    public static function login(Router $router): void
    {
        $auth = new Usuario();
        $alertas = [];

        if (isPostBack()) {
            $auth->sincronizar($_POST);
            $alertas = $auth->validarLoginInputs();

            if (empty($alertas)) {
                if (self::attemptLogin($auth)) {
                    return; // Redirige al usuario y termina el método
                }
            }
        }

        $alertas = Usuario::getAlertas();
        $router->render("auth/login", [
            "alertas" => $alertas,
            "auth" => $auth
        ]);
    }

    private static function attemptLogin(Usuario $auth): bool
    {
        $usuario = Usuario::where("email", $auth->email);

        if ($usuario && $usuario->comprobarPasswordAndVerificado($auth->password)) {
            self::authenticateUser($usuario);
            return true;
        }

        Usuario::setAlerta('error', 'El usuario no existe o la contraseña es incorrecta');
        return false;
    }

    private static function authenticateUser(Usuario $user): void
    {
        session_start();

        $request = new Request();
        $request->session('id', $user->id);
        $request->session('nombre', $user->nombre . " " . $user->apellido);
        $request->session('email', $user->email);
        $request->session('loggedAt', date('Y-m-d H:i:s'));
        $request->session('login', true);

        // Redirección según el rol del usuario
        $redirectUrl = ($user->admin === '1') ? '/admin' : '/cita';
        $request->session('admin', $user->admin ?? null);
        header("Location: $redirectUrl");
        exit; // Termina el script después de la redirección
    }


    #[NoReturn] public static function logout(): void
    {
        session_start();

        $_SESSION = [];

        session_destroy();

        header("Location: /");
        exit;
    }
}