<?php

namespace Model;

class Servicio extends ActiveRecord
{
    //base de datos 
    protected static $tabla = 'servicios';
    protected static $columnasDB = ['id', 'nombre', 'precio'];

    public $id;
    public $nombre;
    public $precio;

    public function __construct($args = [])
    {
        $this->id = $args['id'] ?? null; 
        $this->nombre = $args['nombre'] ?? ''; 
        $this->precio = $args['precio'] ?? ''; 
    }

    public function validarCampos()
    {
        if (empty($this->nombre)) {
            self::$alertas[] = "El campo nombre es requerido";
        }
        if (empty($this->precio)) {
            self::$alertas[] = "El campo precio es requerido";
        }

        return self::$alertas;
    }
}