<?php
session_start();
ob_start();
$page_title = 'LISTADO DE ARTICULOS';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
$user = current_user();


//REPORTE DE VENTAS POR SUCURSAL
$sales = find_by_sql("SELECT articulo, descrip, costo, precio1 FROM productos ", true);
?>

<?php include_once('template/header.php'); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Lista de Productos </h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tableExport" class="table table-striped" id="table-1" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Articulo</th>
                                            <th>Descripcion</th>
                                            <th>Costo</th>
                                            <th>Precio</th>
                                    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sales)) {
                                            foreach ($sales as $key => $item) {
                                        ?>
                                                <tr>
                                                <td><?= $item["articulo"] ?></td>
                                                <td><?= $item["descrip"] ?></td>
                                           
                                                <td><?= number_format($item["costo"], 2) ?></td>
                                                <td><?= number_format($item["precio1"], 2) ?></td> 
                                                </tr>
                                            <?php
                                            }
                                        } else {
                                            ?>
                                            <tr>
                                                <td colspan="2">No hay dato para mostrar</td>
                                            </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<?php include_once('template/footer.php'); ?>