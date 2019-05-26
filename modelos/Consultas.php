<?php
//Incluímos inicialmente la conexión a la base de datos
require "../config/Conexion.php";

Class Consultas
{
    //Implementamos nuestro constructor
    public function __construct()
    {

    }

    public function comprasfecha($fecha_inicio,$fecha_fin)
    {
        $sql="SELECT DATE(i.fecha_hora) as fecha,u.nombre as usuario, p.nombre as proveedor,i.tipo_comprobante,i.serie_comprobante,i.num_comprobante,i.total_compra,i.impuesto,i.estado 
        FROM ingreso i 
        INNER JOIN persona p ON i.idproveedor=p.idpersona 
        INNER JOIN usuario u ON i.idusuario=u.idusuario 
        WHERE DATE(i.fecha_hora)>='$fecha_inicio' AND DATE(i.fecha_hora)<='$fecha_fin'";
        return ejecutarConsulta($sql);
    }

    public function ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente)
    {
        $sql="SELECT DATE(v.fecha_hora) as fecha,u.nombre as usuario, p.nombre as cliente,v.tipo_comprobante,v.serie_comprobante,v.num_comprobante,v.total_venta,v.impuesto,v.estado 
        FROM venta v 
        INNER JOIN persona p ON v.idcliente=p.idpersona 
        INNER JOIN usuario u ON v.idusuario=u.idusuario 
        WHERE DATE(v.fecha_hora)>='$fecha_inicio' AND DATE(v.fecha_hora)<='$fecha_fin' or v.idcliente='$idcliente'";// se quita sentencia AND por OR para no buscar por cliente
        return ejecutarConsulta($sql);
    }
    // compras que se ha echos diarias
    public function totalcomprahoy()
    {
        $sql="SELECT IFNULL(SUM(total_compra),0) as total_compra 
        FROM ingreso 
        WHERE DATE(fecha_hora)=curdate()";
        return ejecutarConsulta($sql);
    }
   // consulta utilidades mes a mes
    public function utilidades(){

        $util = "SELECT DATE_FORMAT(fecha,\"%Y\") as año, DATE_FORMAT(fecha,\"%b\") as mes,
        sum(precio_compra * cantidad) as suma_compras, sum(precio_venta * cantidad) as suma_ventas
        FROM detalle_venta
        GROUP BY MONTH(fecha)";
        return ejecutarConsulta($util);
    }

    // consulta utilidad mes actual
    public function utilidad_mes(){

        $util_mes = "select  sum(precio_compra * cantidad) as compras,sum(precio_venta *cantidad ) as ventas
        from detalle_venta  
        where month(fecha) = MONTH(CURRENT_DATE())";
        return ejecutarConsulta($util_mes);
    }

    public function totalventahoy()
    {
        $sql="SELECT IFNULL(SUM(total_venta),0) as total_venta 
        FROM venta WHERE DATE(fecha_hora)=curdate()";
        return ejecutarConsulta($sql);
    }

    public function comprasultimos_10dias()
    {
        $sql="SELECT CONCAT(DAY(fecha_hora),'-',MONTH(fecha_hora)) as fecha,SUM(total_compra) as total 
        FROM ingreso GROUP by fecha_hora ORDER BY fecha_hora DESC limit 0,10";
        return ejecutarConsulta($sql);
    }

    public function ventasultimos_12meses()
    {
        $sql="SELECT DATE_FORMAT(fecha_hora,'%d') as fecha,SUM(total_venta) as total 
        FROM venta GROUP by DAY(fecha_hora) ORDER BY fecha_hora DESC limit 0,7";
        return ejecutarConsulta($sql);
    }

    public function  mas_vendidos()
    {
       $total_vendidos= "select articulo, cantidades from
        (
        select a.nombre as articulo,sum(dv.cantidad) as cantidades
        from detalle_venta as dv inner join articulo a on a.idarticulo=dv.idarticulo
        group by a.idarticulo) as v
	    group by articulo 
        order by cantidades desc limit 0,5";
        return ejecutarConsulta($total_vendidos);
    }
}

?>