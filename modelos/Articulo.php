<?php
require "../config/Conexion.php";

class Articulo 
{
    public function __construct()
    {

    }
    // implementamos un metodo para insertar registros

    public function insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
    {
        $sql= "INSERT INTO articulo (idcategoria,codigo,nombre,stock,descripcion,condicion) VALUES ('$idcategoria','$codigo','$nombre','$stock','$descripcion','$imagen','1')";
        return ejecutarConsulta($sql);
    }
    // Implementamos un mètodo para editar categoria

public function editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen)
 {
   $sqldos= "UPDATE articulo SET idcategoria='$idcategoria',codigo='$codigo',nombre=$nombre,stock=$stock,descripcion=$descripcion,imagen=$imagen  WHERE idarticulo='$idarticulo'"; 
   return ejecutarConsulta($sqldos);
 }
 //implementamos mètodos para desactivar categorias

public function desactivar ($idarticulo)
{
    $sqltres= "UPDATE articulo SET condicion='0' WHERE idarticulo='$idarticulo'";
    return ejecutarConsulta($sqltres);

}
// metodo para volver activar categoria
public function activar ($idarticulo)
{
    $sqltres= "UPDATE articulo SET condicion='1' WHERE idarticulo='$idarticulo'";
    return ejecutarConsulta($sqltres);

}
// metodo para mostrar los datos en un registro a modificar
public function mostrar($idarticulo)
{
    $sqlcuat= "SELECT * FROM articulo where idarticulo='$idarticulo'";
    return ejecutarConsultaSimpleFila($sqlcuat);

}
// metodo para listar registros
public function listar()
{
    $sqlcinco = "SELECT a.idarticulo,a.idcategoria,c.nombre as categoria,a.codigo,a.nombre,a.stock,a.descripcion,a.imagen,a.condicion FROM articulo a INNER JOIN  categoria c ON a.idcategoria=c.idcategoria";
    return ejecutarConsulta($sqlcinco);
}
}



?>