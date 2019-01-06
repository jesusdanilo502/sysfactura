var table;

//funcion que se ejecuta inicio

function init() {
    mostrarform(false);
    listar();
    $("#formulario").on("submit", function (e) {
        guardaryeditar(e);
    })
    
    $("#imagenmuestra").hide();

    // mostramos los permisos
    $.post("../ajax/usuario.php?op=permisos",function(r){
         $("#permisos").html(r);
    });
}
// funcion limpiar
function limpiar() {
    
	$("#nombre").val("");
	$("#num_documento").val("");
	$("#direccion").val("");
	$("#telefono").val("");
	$("#email").val("");
	$("#cargo").val("");
	$("#login").val("");
	$("#clave").val("");
	$("#imagenmuestra").attr("src","");
	$("#imagenactual").val("");
	$("#idusuario").val("");
}
// funcion mostrar formulario
function mostrarform(flag) {
    limpiar();
    if (flag) {
        $("#listadoregistros").hide();
        $("#formularioregistros").show();
        $("#btnGuardar").prop("disabled", false);
        $("#btnagregar").hide();
    } else {
        $("#listadoregistros").show();
        $("#formularioregistros").hide();
        $("#btnagregar").show();


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
            url: '../ajax/usuario.php?op=listar',
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
        url: "../ajax/usuario.php?op=guardaryeditar",
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

function mostrar(idusuario) {
    $.post("../ajax/usuario.php?op=mostrar", {
        idusuario: idusuario
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
		$("#cargo").val(data.cargo);
		$("#login").val(data.login);
		$("#clave").val(data.clave);
		$("#imagenmuestra").show();
		$("#imagenmuestra").attr("src","../files/usuarios/"+data.imagen);
		$("#imagenactual").val(data.imagen);
		$("#idusuario").val(data.idusuario);
    })
}
// funcion desactivar registos
function desactivar(idusuario) {
    bootbox.confirm("¿Esta seguro que desea desactivar la usuario?", function(result) {
        if (result) {
            $.post("../ajax/usuario.php?op=desactivar", {
                idusuario: idusuario
            }, function (e) {
                bootbox.alert(e);

                table.ajax.reload();
               
              
            });
        }
    })
}
// funcion activar categoria
function activar(idusuario){
    bootbox.confirm("Estas seguro activar articulo", function(result){
        if(result)
        {
            $.post("../ajax/usuario.php?op=activar", {idusuario : idusuario}, function(e){
                bootbox.alert(e);
                table.ajax.reload();
            })
        }else { bootbox.alert("has cancelado la activacion..")}
    })
}

init();