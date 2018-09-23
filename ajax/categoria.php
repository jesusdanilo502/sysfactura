<?php
require_once "../modelos/Categoria.php";


$category = new Categoria();

$idcategory= isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]): "";
$name=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$description=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";


switch($_GET["op"]){
    case 'guardaryeditar':
         if (empty($idcategory)) {
             $answer= $category->insertar($name,$description);
             echo $answer ? "Categoria Registrada":"Categorria no se pudo Registrar";

         }else{
            
                $answer= $category->editar($idcategory,$name,$description);
                echo $answer ? "Categoria Actualizada":"Categorria no se pudo Actualizar";
         }
        break;
    
        case 'desactivar':
          $answer= $category->desactivar($idcategory);
          echo $answer ? "Categoria Desactivada" : "Categoria no de pudo Desactivar";
        break;
        
        case 'activar':
        $answer= $category->activar($idcategory);
          echo $answer ? "Categoria Activada" : "Categoria no de pudo Activar";
        break;
        case 'mostrar':
         $answer = $category->mostrar($idcategory);
         //Codificar el resultado utilizando json
         echo json_encode($answer);
        break;
        case 'listar':
         $answer=$category->listar();
         // Vamos A declarar un array
         $data= Array();

         while ($reg=$answer->fetch_object()){
 			   $data[]=array(
          "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
          ' <button class="btn btn-danger" onclick="desactivar('.$reg->idcategoria.')"><i class="fa fa-close"></i></button>':
          '<button class="btn btn-warning" onclick="mostrar('.$reg->idcategoria.')"><i class="fa fa-pencil"></i></button>'.
          ' <button class="btn btn-primary" onclick="activar('.$reg->idcategoria.')"><i class="fa fa-check"></i></button>',

             "1"=>$reg->nombre,
             "2"=>$reg->descripcion,
             "3"=>$reg->condicion?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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