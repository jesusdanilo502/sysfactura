<?php
require "../config/Conexion.php";

class Permiso 
{
    public function __construct()
    {

    }
    // implementamos un metodo para insertar registros

   
public function listar()
{
    $sqlcinco = "SELECT * FROM permiso";
    return ejecutarConsulta($sqlcinco);
}

}



?>