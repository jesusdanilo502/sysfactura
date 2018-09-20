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
    $("#idcategoria").val("");
    $("#nombre").val("");
    $("#descripcion").val("");
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
            url: '../ajax/categoria.php?op=listar',
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
        url: "../ajax/categoria.php?op=guardaryeditar",
        type: "POST",
        data: formData,
        contentType: false,
        processData: false,

        success: function (datos) {
            bootbox.alert(datos);
            mostrarform(false);
            tabla.ajax.reload();
        }

    });

    limpiar();

}

function mostrar(idcategoria) {
    $.post("../ajax/categoria.php?op=mostrar", {
        idcategoria: idcategoria
    }, function (data, status) {
        data = JSON.parse(data);
        mostrarform(true);
        $("#nombre").val(data.nombre);
        $("#descripcion").val(data.descripcion);
        $("#idcategoria").val(data.idcategoria);
    })
}
init();