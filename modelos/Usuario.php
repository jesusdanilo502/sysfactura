<?php
require "../config/Conexion.php";

class Usuario 
{
    public function __construct()
    {

    }
    // implementamos un metodo para insertar registros

    public function insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen)
    {
        $sql="INSERT INTO usuario (nombre,tipo_documento,num_documento,direccion,telefono,email,cargo,login,clave,imagen,condicion)
		VALUES ('$nombre','$tipo_documento','$num_documento','$direccion','$telefono','$email','$cargo','$login','$clave','$imagen','1')";
		return ejecutarConsulta($sql);
    }
    // Implementamos un mètodo para editar categoria

public function editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clave,$imagen)
 {
    $sql="UPDATE usuario SET nombre='$nombre',tipo_documento='$tipo_documento',num_documento='$num_documento',direccion='$direccion',telefono='$telefono',email='$email',cargo='$cargo',login='$login',clave='$clave',imagen='$imagen' WHERE idusuario='$idusuario'";
    ejecutarConsulta($sql);
 }
 //implementamos mètodos para desactivar categorias

public function desactivar ($idusuario)
{
    $sqltres= "UPDATE usuario SET condicion='0' WHERE idusuario='$idusuario'";
    return ejecutarConsulta($sqltres);

}
// metodo para volver activar categoria
public function activar ($idusuario)
{
    $sqltres= "UPDATE usuario SET condicion='1' WHERE idusuario='$idusuario'";
    return ejecutarConsulta($sqltres);

}
// metodo para mostrar los datos en un registro a modificar
public function mostrar($idusuario)
{
    $sqlcuat= "SELECT * FROM usuario where idusuario='$idusuario'";
    return ejecutarConsultaSimpleFila($sqlcuat);

}
// metodo para listar registros
public function listar()
{
    $sqlcinco = "SELECT * FROM usuario";
    return ejecutarConsulta($sqlcinco);
}


}



?>