<?php
require_once "../modelos/Permiso.php";


$permiso = new Permiso();




switch($_GET["op"]){
    
        case 'listar':
         $answer=$permiso->listar();
         // Vamos A declarar un array
         $data= Array();

         while ($reg=$answer->fetch_object()){
 			   $data[]=array(
         
             "0"=>$reg->nombre
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