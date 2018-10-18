var table;

//funcion que se ejecuta inicio

function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })

}
// funcion limpiar
function limpiar() {
    $("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#idpersona").val("");
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
            url: '../ajax/persona.php?op=listarp',
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
        url: "../ajax/persona.php?op=guardaryeditar",
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

function mostrar(idpersona) {
    $.post("../ajax/persona.php?op=mostrar", {
        idpersona: idpersona
    }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);

        $("#nombre").val(data.nombre);
		$("#tipo_documento").val(data.tipo_documento);
		$("#tipo_documento").selectpicker('refresh');
		$("#num_documento").val(data.num_documento);
		$("#direccion").val(data.direccion);
		$("#telefono").val(data.telefono);
		$("#email").val(data.email);
 		$("#idpersona").val(data.idpersona);
		
    })
}
// funcion desactivar registos
function eliminar(idpersona) {
    bootbox.confirm("¿Esta seguro que desea elimina el proveedor?", function(result) {
        if (result) {
            $.post("../ajax/persona.php?op=eliminar", {
                idpersona: idpersona
            }, function (e) {
                bootbox.alert(e);

                table.ajax.reload();
               
              
            });
        }
    })
}

init();