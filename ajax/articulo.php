<?php
require_once "../modelos/Articulo.php";


$article = new Articulo();

$idarticulo= isset($_POST["idarticulo"])? limpiarCadena($_POST["idarticulo"]): "";
$idcategoria= isset($_POST["idcategoria"])? limpiarCadena($_POST["idcategoria"]): "";
$codigo= isset($_POST["codigo"])? limpiarCadena($_POST["codigo"]): "";
$nombre=isset($_POST["nombre"])? limpiarCadena($_POST["nombre"]):"";
$stock=isset($_POST["stock"])? limpiarCadena($_POST["stock"]):"";
$description=isset($_POST["descripcion"])? limpiarCadena($_POST["descripcion"]):"";
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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
			}
        }
        
         if (empty($idarticulo)) {
             $answer= $article->insertar($idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
             echo $answer ? "Articulo Registrado":"Articulo no se pudo Registrar";

         }else{
            
                $answer= $article->editar($idarticulo,$idcategoria,$codigo,$nombre,$stock,$descripcion,$imagen);
                echo $answer ? "Articulo Actualizado":"Articulo no se pudo Actualizar";
         }
        break;
    
        case 'desactivar':
          $answer= $article->desactivar($idarticulo);
          echo $answer ? "Articuloidarticulo Desactivada" : "Articuloidarticulo no de pudo Desactivar";
        break;
        
        case 'activar':
        $answer= $article->activar($idarticulo);
          echo $answer ? "Articuloidarticulo Activada" : "Articuloidarticulo no de pudo Activar";
        break;
        case 'mostrar':
         $answer = $article->mostrar($idarticulo);
         //Codificar el resultado utilizando json
         echo json_encode($answer);
        break;
        case 'listar':
         $answer=$article->listar();
         // Vamos A declarar un array
         $data= Array();

         while ($reg=$answer->fetch_object()){
 			   $data[]=array(
          "0"=>($reg->condicion)?'<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
          ' <button class="btn btn-danger" onclick="desactivar('.$reg->idarticulo.')"><i class="fa fa-close"></i></button>':
          '<button class="btn btn-warning" onclick="mostrar('.$reg->idarticulo.')"><i class="fa fa-pencil"></i></button>'.
          ' <button class="btn btn-primary" onclick="activar('.$reg->idarticulo.')"><i class="fa fa-check"></i></button>',

             "1"=>$reg->nombre,
             "2"=>$reg->categoria,
             "3"=>$reg->codigo,
             "4"=>$reg->stock,
             "5"=>"<img src='../file/articulos/".$reg->imagen."' height='50px' width='50px'>",
             "6"=>$reg->condicion?'<span class="label bg-green">Activado</span>':'<span class="label bg-red">Desactivado</span>'
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