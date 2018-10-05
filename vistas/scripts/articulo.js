var table;

//funcion que se ejecuta inicio

function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })
    // cargamos los item al select  de mi vista categoria
    $.post("../ajax/articulo.php?op=selectCategoria", function(r){
        $("#idcategoria").html(r);
        $('#idcategoria').selectpicker('refresh');

    

});
$("#imagenmuestra").hide();

}
// funcion limpiar
function limpiar() {
    
	$("#codigo").val("");
	$("#nombre").val("");
	$("#descripcion").val("");
	$("#stock").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#print").hide();
	$("#idarticulo").val("");
}
// funcion mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnGuardar").prop("disabled", true);
    }
}
// funciòn cancelar form

function cancelarform() {
    limpiar();
    mostrarform(false);
}
// funciòn listar
function listar() {
    table = $('#tbllistado').dataTable({
        "aProcessing": true, //Activamos el procesamiento de datatables
        "aServerSide": true, // Paginaciòn y filtrado realizados por el servidor
        dom: 'Bfrtip', // definimos los elementos del control de tabla
        buttons: [
            'copyHtml5',
            'excelHtml5',
            'csvHtml5',
            'pdf'
        ],
        "ajax": {
            url: '../ajax/articulo.php?op=listar',
            type: "get",
            dataType: "json",
            error: function (e) {
                console.log(e.responseText);
            }
        },
        "bDestroy": true,
        "iDisplayLength": 5, // paginaciòn
        "order": [
            [0, "asc"]
        ] // ordenar (columna,orden)
    }).DataTable();

}

function guardaryeditar(e) {
    e.preventDefault(); //No se activará la acción predeterminada del evento
    $("#btnGuardar").prop("disabled", true);
    var formData = new FormData($("#formulario")[0]);

    $.ajax({
        url: "../ajax/articulo.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            table.ajax.reload();
        }

    });

    limpiar();

}

function mostrar(idarticulo) {
    $.post("../ajax/articulo.php?op=mostrar", {
        idarticulo: idarticulo
    }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#idcategoria").val(data.idcategoria);
        $("#idcategoria").selectpicker('refresh');
        $("#codigo").val(data.codigo);
        $("#nombre").val(data.nombre);
        $("#stock").val(data.stock);
        $("#descripcion").val(data.descripcion);
        $("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/articulos/"+data.imagen);
		$("#imagenactual").val(data.imagen);
        $("#idarticulo").val(data.idarticulo);
    })
}
// funcion desactivar registos
function desactivar(idarticulo) {
    bootbox.confirm("¿Esta seguro que desea desactivar la articulo?", function(result) {
        if (result) {
            $.post("../ajax/articulo.php?op=desactivar", {
                idarticulo: idarticulo
            }, function (e) {
                bootbox.alert(e);

                table.ajax.reload();
               
              
            });
        }
    })
}
// funcion activar categoria
function activar(idarticulo){
    bootbox.confirm("Estas seguro activar articulo", function(result){
        if(result)
        {
            $.post("../ajax/articulo.php?op=activar", {idarticulo : idarticulo}, function(e){
                bootbox.alert(e);
                table.ajax.reload();
            })
        }else { bootbox.alert("has cancelado la activacion..")}
    })
}
init();