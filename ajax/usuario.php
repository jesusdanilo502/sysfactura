<?php
require_once "../modelos/Usuario.php";


$usuario = new Usuario();


$idusuario=isset($_POST["idusuario"])? limpiarCadena($_POST["idusuario"]):"";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$tipo_documento=isset($_POST["tipo_documento"])? limpiarCadena($_POST["tipo_documento"]):"";
$num_documento=isset($_POST["num_documento"])? limpiarCadena($_POST["num_documento"]):"";
$direccion=isset($_POST["direccion"])? limpiarCadena($_POST["direccion"]):"";
$telefono=isset($_POST["telefono"])? limpiarCadena($_POST["telefono"]):"";
$email=isset($_POST["email"])? limpiarCadena($_POST["email"]):"";
$cargo=isset($_POST["cargo"])? limpiarCadena($_POST["cargo"]):"";
$login=isset($_POST["login"])? limpiarCadena($_POST["login"]):"";
$clave=isset($_POST["clave"])? limpiarCadena($_POST["clave"]):"";
$imagen=isset($_POST["imagen"])? limpiarCadena($_POST["imagen"]):"";

switch($_GET["op"]){
    case 'guardaryeditar':

    if (!file_exists($_FILES['imagen']['tmp_name']) || !is_uploaded_file($_FILES['imagen']['tmp_name']))
		{
			$imagen=$_POST["imagenactual"];
		}
		else 
		{
			$ext = explode(".", $_FILES["imagen"]["name"]);
			if ($_FILES['imagen']['type'] == "image/jpg" || $_FILES['imagen']['type'] == "image/jpeg" || $_FILES['imagen']['type'] == "image/png")
			{
				$imagen = round(microtime(true)) . '.' . end($ext);
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/usuarios/" . $imagen);
			}
        }
        
        //Hash SHA256 en la contraseña
         $clavehash=hash("SHA256",$clave);
    
        if (empty($idusuario)){

          $answer=$usuario->insertar($nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
          echo $answer ? "Usuario registrado" : "No se pudieron registrar todos los datos del usuario";
        }
        else {
          $answer=$usuario->editar($idusuario,$nombre,$tipo_documento,$num_documento,$direccion,$telefono,$email,$cargo,$login,$clavehash,$imagen,$_POST['permiso']);
          echo $answer ? "Usuario actualizado" : "Usuario no se pudo actualizar";
        }
        break;
    
        case 'desactivar':
          $answer= $usuario->desactivar($idusuario);
          echo $answer ? "usuario Desactivada" : "usuario no de pudo Desactivar";
        break;
        
        case 'activar':
        $answer= $usuario->activar($idusuario);
          echo $answer ? "usuario Activada" : "usuario no de pudo Activar";
        break;
        case 'mostrar':
         $answer = $usuario->mostrar($idusuario);
         //Codificar el resultado utilizando json
         echo json_encode($answer);
        break;
        case 'listar':
         $answer=$usuario->listar();
         // Vamos A declarar un array
         $data= Array();

         while ($reg=$answer->fetch_object()){
          $data[]=array(
            "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
              ' <button class="btn btn-danger" onclick="desactivar('.$reg->idusuario.')"><i class="fa fa-close"></i></button>':
              '<button class="btn btn-warning" onclick="mostrar('.$reg->idusuario.')"><i class="fa fa-pencil"></i></button>'.
              ' <button class="btn btn-primary" onclick="activar('.$reg->idusuario.')"><i class="fa fa-check"></i></button>',

          "1"=>$reg->nombre,
          "2"=>$reg->tipo_documento,
          "3"=>$reg->num_documento,
          "4"=>$reg->telefono,
          "5"=>$reg->email,
          "6"=>$reg->login,
          "7"=>"<img src='../files/usuarios/".$reg->imagen."' height='50px' width='50px' >",
          "8"=>($reg->condicion)?'<span class="label bg-green">Activado</span>':
          '<span class="label bg-red">Desactivado</span>'
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