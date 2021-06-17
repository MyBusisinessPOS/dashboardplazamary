<?php
session_start();
ob_start();
$page_title = 'Ventas por susursal';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
$user = current_user();


$branchs = find_by_sql("SELECT sucursal from ventas group by sucursal ORDER BY sucursal", true);

$request_branch = isset($_REQUEST["branch"]) ? $_REQUEST["branch"] : $branchs[0]["sucursal"];
$request_date_start = isset($_REQUEST["date_start"]) ? $_REQUEST["date_start"] : date("Y-m-d");
$request_date_end = isset($_REQUEST["date_end"]) ? $_REQUEST["date_end"] : date("Y-m-d");



//CONTIENE LOS ACUMULADOS DE LA CONSULTA
$countProducts = find_by_sql("SELECT  SUM(p.cantidad) As Cantidad, SUM(p.precio * p.cantidad) As Total 
FROM partidas As p  
INNER JOIN ventas As v ON p.venta = v.venta 
WHERE v.sucursal  LIKE '{$request_branch}' AND v.f_emision >= '{$request_date_start}' <= v.f_emision <= '{$request_date_end}' ", true);


//REPORTE DE VENTAS POR SUCURSAL

$sales = find_by_sql("SELECT sucursal, sum(importe + impuesto) as acumulado FROM ventas WHERE sucursal LIKE '{$request_branch}' AND f_emision  >= '{$request_date_start}' AND f_emision  <= '{$request_date_end}' GROUP BY sucursal ", true);


?>
<?php include_once('template/header.php'); ?>

<!-- Main Content -->
<div class="main-content">

    <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Total de ingresos</h5>
                          <h2 class="mb-3 font-18">$ <?= number_format($countProducts[0]['Total'] , 2) ?></h2>
                
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/1.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15"> Productos vendidos</h5>
                          <h2 class="mb-3 font-18">Cantidad <?= $countProducts[0]['Cantidad']  ?></h2>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/2.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
    </div>
    <section class="section">
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Reporte de ventas por sucursal</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="form-row">
                                <div class="form-group col-md-3">
                                    <label for="sucursal">Sucursal</label>
                                    <select name="branch" id="branch" class="form-control mb-2 mr-sm-2">
                                        <?php
                                        foreach ($branchs as $key => $item) {
                                        ?>
                                            <option <?= ($request_branch == $item["sucursal"]) ? 'selected' : '' ?> value="<?= $item['sucursal'] ?>"><?= $item["sucursal"] ?></option>
                                        <?php
                                        }
                                        ?>
                                    </select>
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="date_start">Fecha Inicio</label>
                                    <input type="date" class="form-control" id="date_start" name="date_start" value="<?= $request_date_start ?>">
                                </div>
                                <div class="form-group col-md-3">
                                    <label for="date_final">Fecha Final</label>
                                    <input type="date" class="form-control" id="date_end" name="date_end" value="<?= $request_date_end ?>">
                                </div>
                                <div class="form-group col-md-3 ">             
                                    <label><br><br><br></label>                                                           
                                    <button type="submit" class="btn btn-primary"><i class="fa fa-filter"></i> Filtrar</button>
                                </div>                             
                            </form>
                            <hr>

                            <div class="table-responsive">
                                <table class="table table-striped table-hover" id="tableExport" class="table table-striped" id="table-1" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Sucursal</th>
                                            <th>Total vendido</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sales)) {
                                            foreach ($sales as $key => $item) {
                                        ?>
                                                <tr>
                                                    <td><?= $item["sucursal"] ?></td>
                                                    <td>$<?= number_format($item["acumulado"], 2) ?></td>
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