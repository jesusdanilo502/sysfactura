var table;

//funcion que se ejecuta inicio

function init() {
    mostrarform(false);
    listar();
   
}

// funcion mostrar formulario
function mostrarform(flag) {
    //limpiar();
    if (flag)
	{
		$("#listadoregistros").hide();
		$("#formularioregistros").show();
		$("#btnGuardar").prop("disabled",false);
		$("#btnagregar").hide();
	}
	else
	{
		$("#listadoregistros").show();
		$("#formularioregistros").hide();
		$("#btnagregar").hide();
	}
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
            url: '../ajax/permiso.php?op=listar',
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

init();