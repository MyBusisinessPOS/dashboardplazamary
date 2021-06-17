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

        </div>
    </section>
</div>
<!-- /.content-wrapper -->
<?php include_once('template/footer.php'); ?>