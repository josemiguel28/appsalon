<?phpnamespace Controller;use Clases\Email;use Clases\Request;use JetBrains\PhpStorm\NoReturn;use Model\ActiveRecord;use Model\Usuario;use MVC\Router;use PHPMailer\PHPMailer\Exception;class LoginController extends ActiveRecord{    public static function crearCuenta(Router $router): void    {        $usuario = new Usuario;        $alertas = [];        if (isPostBack()) {            $usuario->sincronizar($_POST);            $alertas = $usuario->validarDatosNuevaCuenta();            if (empty($alertas)) {                //verificar que el usuario no este registrado                $isUserRegistered = $usuario->isUserRegistered();                //si el usuario está registrado muestra error                if ($isUserRegistered) {                    $alertas = Usuario::getAlertas();                } else {                    $usuario->hashPassword();                    $usuario->createToken();                    //enviar el token al email                    $email = new Email($usuario->email, $usuario->nombre, $usuario->token);                    $email->enviarEmail();                    //crear el usuario                    $resultado = $usuario->guardar();                    if ($resultado) {                        //redirigir a login                        header('Location: /mensaje');                    }                }            }        }        $router->render('auth/crearCuenta',            [                "usuario" => $usuario,                "alertas" => $alertas            ]);    }    public static function login(Router $router): void    {        $auth = new Usuario();        $alertas = [];        if (isPostBack()) {            $auth = new Usuario($_POST);            $alertas = $auth->validarLogin();            if (empty($alertas)) {                $usuario = Usuario::where("email", $auth->email);                //verificar que la cuenta exista                if ($usuario) {                    if ($usuario->comprobarPasswordAndVerificado($auth->password)) {                        //autentitcar al usuario                        session_start();                        $request = new Request();                        $request->session('id', $usuario->id);                        $request->session('nombre', $usuario->nombre . " " . $usuario->apellido);                        $request->session('email', $usuario->email);                        $request->session('loggedAt', date('Y-m-d H:i:s'));                        $request->session('login', true);                        //redireccionamiento                        if ($usuario->admin === '1') {                            $request->session('admin', $usuario->admin ?? null);                            header('Location: /admin');                        } else {                            header('Location: /cita');                        }                    }                } else {                    Usuario::setAlerta('error', 'El usuario no existe');                }            }        }        $alertas = Usuario::getAlertas();        $router->render("auth/login",            [                "alertas" => $alertas,                "auth" => $auth            ]);    }    #[NoReturn] public static function logout(): void    {        session_start();        $_SESSION = [];        session_destroy();        header("Location: /");        exit;    }    public static function mensaje(Router $router): void    {        $router->render('auth/mensaje');    }    public static function confirmar(Router $router): void    {        $alertas = [];        $token = '';        $request = new Request();        $token = $request->get("token");        $usuario = Usuario::where('token', $token);        if (empty($usuario) || $usuario->token === '') {            Usuario::setAlerta('error', "Error, token no valido");        } else {            $usuario->confirmado = "1";            $usuario->token = '';            $usuario->guardar();            Usuario::setAlerta('exito', "Cuenta confirmada correctamente");        }        //pasa las alertas para renderizarlas        $alertas = Usuario::getAlertas();        $router->render(            'auth/confirmar-cuenta',            [                'alertas' => $alertas            ]);    }}