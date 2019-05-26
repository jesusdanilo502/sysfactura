<?php
require_once "../modelos/Consultas.php";

$consulta=new Consultas();


switch ($_GET["op"]){
    case 'comprasfecha':
        //delcaramos variables para recibir de mi ajax dos parametros
        $fecha_inicio=$_REQUEST["fecha_inicio"];
        $fecha_fin=$_REQUEST["fecha_fin"];

        $rspta=$consulta->comprasfecha($fecha_inicio,$fecha_fin);
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->usuario,
                "2"=>$reg->proveedor,
                "3"=>$reg->tipo_comprobante,
                "4"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                "5"=>$reg->total_compra,
                "6"=>$reg->impuesto,
                "7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
                    '<span class="label bg-red">Anulado</span>'
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;


    case 'ventasfechacliente':
        $fecha_inicio=$_REQUEST["fecha_inicio"];
        $fecha_fin=$_REQUEST["fecha_fin"];
        $idcliente=$_REQUEST["idcliente"];

        $rspta=$consulta->ventasfechacliente($fecha_inicio,$fecha_fin,$idcliente);
        //Vamos a declarar un array
        $data= Array();

        while ($reg=$rspta->fetch_object()){
            $data[]=array(
                "0"=>$reg->fecha,
                "1"=>$reg->usuario,
                "2"=>$reg->cliente,
                "3"=>$reg->tipo_comprobante,
                "4"=>$reg->serie_comprobante.' '.$reg->num_comprobante,
                "5"=>$reg->total_venta,
                "6"=>$reg->impuesto,
                "7"=>($reg->estado=='Aceptado')?'<span class="label bg-green">Aceptado</span>':
                    '<span class="label bg-red">Anulado</span>'
            );
        }
        $results = array(
            "sEcho"=>1, //Información para el datatables
            "iTotalRecords"=>count($data), //enviamos el total registros al datatable
            "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
            "aaData"=>$data);
        echo json_encode($results);

        break;

        case 'utilidad':

            $rspta=$consulta->utilidades();
            //Vamos a declarar un array
            $data= Array();

            while ($reg=$rspta->fetch_object()){
                $data[]=array(
                    "0"=>$reg->año,
                    "1"=>$reg->mes,
                    "2"=>'$ '.number_format($reg->suma_compras),
                    "3"=>'$ '.number_format($reg->suma_ventas),
                    "4"=>'$ '.number_format($reg->suma_ventas - $reg->suma_compras)
                );
            }
            $results = array(
                "sEcho"=>1, //Información para el datatables
                "iTotalRecords"=>count($data), //enviamos el total registros al datatable
                "iTotalDisplayRecords"=>count($data), //enviamos el total registros a visualizar
                "aaData"=>$data);
            echo json_encode($results);

            break;
}
?>