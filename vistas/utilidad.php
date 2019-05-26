<?php
// Activamos almacenamiento en el buffer
ob_start();
session_start();

if(!isset($_SESSION["nombre"]))
{
    header("Location: login.html");
}
else
{
    require 'header.php';
    if($_SESSION['utilidad']==1)
    {
        ?>
        <!--Contenido-->
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Main content -->
            <section class="content">
                <div class="row">
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-header with-border">
                                <h1 class="box-title">Ganancias x Mes Segùn el Valor de Compra a Proveedores <!--<button class="btn btn-success" id="btnagregar" onclick="mostrarform(true)"><i class="fa fa-plus-circle"></i> Agregar</button>--></h1>
                                <div class="box-tools pull-right">
                                </div>
                            </div>
                            <!-- /.box-header -->
                            <!-- centro -->
                            <div class="panel-body table-responsive" id="listadoregistros">
                                <table id="tbllistado" class="table table-striped table-bordered table-condensed table-hover">
                                    <thead>
                                    <th>Año</th>
                                    <th>Mes</th>
                                    <th>Totales Compras</th>
                                    <th>Totales Ventas</th>
                                    <th>Ganancia x Mes</th>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                    <tfoot>
                                    <th>Año</th>
                                    <th>Mes</th>
                                    <th>Totales Compras</th>
                                    <th>Totales Ventas</th>
                                    <th>Ganancia x Mes</th>
                                    </tfoot>
                                </table>
                            </div>
                            <!--Fin centro -->
                        </div><!-- /.box -->
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </section><!-- /.content -->

        </div><!-- /.content-wrapper -->
        <!--Fin-Contenido-->
        <?php
    }
    else
    {
        require 'noacceso.php';
    }
    require 'footer.php';

    ?>
    <script type="text/javascript" src="scripts/utilidad.js"></script>
    <script type="text/javascript" src="scripts/validaciones.js"></script>
    <?php
}
ob_end_flush();
?>