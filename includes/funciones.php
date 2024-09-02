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

function isPostBack() : bool
{
    return $_SERVER["REQUEST_METHOD"] == "POST";
    
}

function redirectToWithMsg($url, $msg)
{
    echo '<script>alert("' . $msg . '");';
    echo ' window.location.assign("' . $url . '");</script>';
    die();
}