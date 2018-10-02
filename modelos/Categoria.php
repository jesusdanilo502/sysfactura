<?php
require "../config/Conexion.php";

class Categoria 
{
    public function __construct()
    {

    }
    // implementamos un metodo para insertar registros

    public function insertar($nombre,$descripcion)
    {
        $sql= "INSERT INTO categoria (nombre,descripcion,condicion) VALUES ('$nombre','$descripcion','1')";
        return ejecutarConsulta($sql);
    }
    // Implementamos un mètodo para editar categoria

public function editar($idcategoria,$nombre,$descripcion)
 {
   $sqldos= "UPDATE categoria SET nombre='$nombre',descripcion='$descripcion' WHERE idcategoria='$idcategoria'"; 
   return ejecutarConsulta($sqldos);
 }
 //implementamos mètodos para desactivar categorias

public function desactivar ($idcategoria)
{
    $sqltres= "UPDATE categoria SET condicion='0' WHERE idcategoria='$idcategoria'";
    return ejecutarConsulta($sqltres);

}
// metodo para volver activar categoria
public function activar ($idcategoria)
{
    $sqltres= "UPDATE categoria SET condicion='1' WHERE idcategoria='$idcategoria'";
    return ejecutarConsulta($sqltres);

}
// metodo para mostrar los datos en un registro a modificar
public function mostrar($idcategoria)
{
    $sqlcuat= "SELECT * FROM categoria where idcategoria='$idcategoria'";
    return ejecutarConsultaSimpleFila($sqlcuat);

}
// metodo para listar registros
public function listar()
{
    $sqlcinco = "SELECT * FROM categoria";
    return ejecutarConsulta($sqlcinco);
}
//Implemetar un mètodo para listar los registros y mostrar en un select
public function select()
{
    $sqlsix = "SELECT * FROM categoria where condicion=1";
    ;
    return ejecutarConsulta($sqlsix);
}
}



?>