<?php

namespace Clases;

use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;

class Email
{

    public $email;
    public $nombre;
    public $token;

    public function __construct($email, $nombre, $token)
    {
        $this->email = $email;
        $this->nombre = $nombre;
        $this->token = $token;
    }

    private function setupMailer()
    {
        // crear una instancia de phpmailer
        $mail = new PHPMailer();

        //configurar SMTP
        $mail->isSMTP();
        $mail->Host = $_ENV["EMAIL_HOST"];
        $mail->SMTPAuth = true;
        $mail->Port = $_ENV["EMAIL_PORT"];
        $mail->Username = $_ENV["EMAIL_USERNAME"];
        $mail->Password = $_ENV["EMAIL_PASSWORD"];

        $mail->setFrom($_ENV["EMAIL_USERNAME"]);
        $mail->addAddress("$this->email");
        $mail->isHTML(true);
        $mail->CharSet = 'UTF-8';

        return $mail;
    }

    /**
     * @throws Exception
     */
    public function enviarEmail(): void
    {
        $mail = $this->setUpMailer();
        $mail->Subject = 'Confirma tu cuenta';

        $contenido = "<html>";
        $contenido .= "<head>";
        $contenido .= "<style>";
        $contenido .= "body {font-family: Arial, sans-serif;}";
        $contenido .= ".container {width: 80%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f6f6f6;}";
        $contenido .= ".message {font-size: 1.2em;}";
        $contenido .= ".button {background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;}";
        $contenido .= "</style>";
        $contenido .= "</head>";
        $contenido .= "<body>";
        $contenido .= "<div class='container'>";
        $contenido .= "<p class='message'> <strong> Hola {$this->nombre} </strong> Has creado tu cuenta en App Salon, solo debes confirmarla presionando el siguiente enlace</p>";
        $contenido .= "<a href='" . $_ENV['APP_URL'] . "/confirmar-cuenta?token={$this->token}' class='button'>Confirmar cuenta</a>";
        $contenido .= "<p> Si tu no has solicitado esta cuenta, ignora este mensaje </p>";
        $contenido .= "</div>";
        $contenido .= "</body>";
        $contenido .= "</html>";

        $mail->Body = $contenido;
        $mail->send();
    }

    public function restablecerContrasena(): void
    {
        $mail = $this->setUpMailer();
        $mail->Subject = 'Restablece tu contraseña';

        $contenido = "<html>";
        $contenido .= "<head>";
        $contenido .= "<style>";
        $contenido .= "body {font-family: Arial, sans-serif;}";
        $contenido .= ".container {width: 80%; margin: auto; padding: 20px; border: 1px solid #ddd; border-radius: 5px; background-color: #f6f6f6;}";
        $contenido .= ".message {font-size: 1.2em;}";
        $contenido .= ".button {background-color: #4CAF50; border: none; color: white; padding: 15px 32px; text-align: center; text-decoration: none; display: inline-block; font-size: 16px; margin: 4px 2px; cursor: pointer;}";
        $contenido .= "</style>";
        $contenido .= "</head>";
        $contenido .= "<body>";
        $contenido .= "<div class='container'>";
        $contenido .= "<p class='message'> <strong> Hola {$this->nombre} </strong> Has solicitado restablecer tu contraseña, solo debes seguir estos pasos presionando el siguiente enlace</p>";
        $contenido .= "<a href='" . $_ENV['APP_URL'] . "/recuperar?token={$this->token}' class='button'>Restablecer Contraseña</a>";
        $contenido .= "<p> Si tu no has solicitado esta cuenta, ignora este mensaje </p>";
        $contenido .= "</div>";
        $contenido .= "</body>";
        $contenido .= "</html>";
        
        $mail->Body = $contenido;
        $mail->send();
    }
}