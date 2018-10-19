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
				move_uploaded_file($_FILES["imagen"]["tmp_name"], "../files/articulos/" . $imagen);
			}
        }
        
         if (empty($idusuario)) {
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
             "5"=>"<img src='../files/articulos/".$reg->imagen."' height='50px' width='50px'>",
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
        case "selectCategoria":
        require_once "../modelos/Categoria.php";
        $categoria = new Categoria();
    
        $rspta = $categoria->select();
    
        while ($reg = $rspta->fetch_object())
            {
              echo '<option value=' . $reg->idcategoria . '>' . $reg->nombre . '</option>';
            }
      break;
}