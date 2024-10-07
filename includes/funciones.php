<?php

function debuguear($variable) : string {
    echo "<pre>";
    var_dump($variable);
    echo "</pre>";
    exit;
}

// Escapa / Sanitizar el HTML
function s($html) : string {
    $s = htmlspecialchars($html);
    return $s;
}

//funcion para verificar si un SERVER es igual a un POST
function isPostBack() : bool
{
    return $_SERVER["REQUEST_METHOD"] == "POST";
    
}

//funcion para mostrar una alerta al usuario, y redirigirlo a una pagina
function redirectToWithMsg($url, $msg)
{
    echo '<script>alert("' . $msg . '");';
    echo ' window.location.assign("' . $url . '");</script>';
    die();
}

function esUltimo(string $actual,string $ultimo) : bool{

    if($actual != $ultimo){
        return true;
    }
}

//funcion para verificar si el usuario esta autenticado
function isUserAuth() : void{
    if(!isset($_SESSION["login"])){
        header("Location: /");
    }
}

function isAdmin(){
    if(!isset($_SESSION["admin"]))
    {
        header("Location: /");
    }
}


