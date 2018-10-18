<?php
require_once "../modelos/Persona.php";


$persona = new Persona();

$idpersona=isset($_POST["idpersona"])? limpiarCadena($_POST["idpersona"]):"";
$tipo_persona=isset($_POST["tipo_persona"])? limpiarCadena($_POST["tipo_persona"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";


switch($_GET["op"]){
    case 'guardaryeditar':
         if (empty($idpersona)) {
             $answer= $persona->insertar($tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);
             echo $answer ? "Persona Registrada":"Persona no se pudo Registrar";

         }else{
            
                $answer= $persona->editar($idpersona,$tipo_persona,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email);
                echo $answer ? "Persona Actualizada":"Persona no se pudo Actualizar";
         }
        break;
    
        case 'eliminar':
          $answer= $persona->desactivar($idpersona);
          echo $answer ? "Persona Eliminada" : "Persona no de pudo Eliminar";
        break;
        
        
        case 'mostrar':
         $answer = $persona->mostrar($idpersona);
         //Codificar el resultado utilizando json
         echo json_encode($answer);
        break;
        case 'listarp':
         $answer=$persona->listarp();
         // Vamos A declarar un array
         $data= Array();

         while ($reg=$answer->fetch_object()){
            $data[]=array(
                "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
                    ' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
                "1"=>$reg->nombre,
                "2"=>$reg->tipo_documento,
                "3"=>$reg->num_documento,
                "4"=>$reg->telefono,
                "5"=>$reg->email
                );
        }
         $result = array(
          "sEcho"=>1,  //Informaciòn para el datatables
          "iTotalRecord"=>count($data), //enviamos el total registros al datatable
          "iTotalDisplayRecords"=>count($data), //enviamos el total registro a visualizar
          "aaData"=>$data);
          echo json_encode($result);
         
        break;
        case 'listarc':
        $answer=$persona->listarc();
        // Vamos A declarar un array
        $data= Array();

        while ($reg=$answer->fetch_object()){
           $data[]=array(
               "0"=>'<button class="btn btn-warning" onclick="mostrar('.$reg->idpersona.')"><i class="fa fa-pencil"></i></button>'.
                   ' <button class="btn btn-danger" onclick="eliminar('.$reg->idpersona.')"><i class="fa fa-trash"></i></button>',
               "1"=>$reg->nombre,
               "2"=>$reg->tipo_documento,
               "3"=>$reg->num_documento,
               "4"=>$reg->telefono,
               "5"=>$reg->email
               );
       }
        $result = array(
         "sEcho"=>1,  //Informaciòn para el datatables
         "iTotalRecord"=>count($data), //enviamos el total registros al datatable
         "iTotalDisplayRecords"=>count($data), //enviamos el total registro a visualizar
         "aaData"=>$data);
         echo json_encode($result);
        
       break;
}