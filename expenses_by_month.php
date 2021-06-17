<?php
session_start();
ob_start();
$page_title = 'Gastos por mes';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
$user = current_user();

$request_date_start = isset($_REQUEST["date_start"]) ? $_REQUEST["date_start"] : date("Y-m-d");
$request_date_end = isset($_REQUEST["date_end"]) ? $_REQUEST["date_end"] : date("Y-m-d");


$EgresosGrupo = find_by_sql("SELECT SUM(gastos) As Gastos 
FROM ventas WHERE fecha  >= '{$request_date_start}' AND fecha  <= '{$request_date_end}' " , true);

$TotalGrupo = find_by_sql("SELECT SUM(efectivo) As Venta, SUM(productos) As Productos 
FROM ventas WHERE  fecha  >= '{$request_date_start}' AND fecha  <= '{$request_date_end}' " , true);

//REPORTE DE VENTAS POR SUCURSAL
$sales = find_by_sql("SELECT sucursal As Sucursal, SUM(gastos) As Gastos, SUM(efectivo) As Ingresos, MONTH(fecha) AS Mes 
FROM ventas  WHERE fecha  >= '{$request_date_start}' AND fecha  <= '{$request_date_end}'
GROUP BY sucursal ORDER BY sucursal, mes asc  ", true);


?>
<?php include_once('template/header.php'); ?>

<!-- Main Content -->
<div class="main-content">

    <section class="section">
           <section class="section">
          <div class="row ">
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Ingresos</h5>
                          <h2 class="mb-3 font-15"><td>$<?= number_format($TotalGrupo[0]["Venta"], 2) ?></td></h2>
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
                          <h5 class="font-15">Gastos</h5>
                         <h2 class="mb-3 font-15"><td>$<?= number_format($EgresosGrupo[0]["Gastos"], 2) ?></h2>

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
            <div class="col-xl-3 col-lg-6 col-md-6 col-sm-6 col-xs-12">
              <div class="card">
                <div class="card-statistic-4">
                  <div class="align-items-center justify-content-between">
                    <div class="row ">
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pr-0 pt-3">
                        <div class="card-content">
                          <h5 class="font-15">Piezas</h5>
                          <h2 class="mb-3 font-15"><td><?= number_format($TotalGrupo[0]["Productos"], 2) ?></h2>
                        </div>
                      </div>
                      <div class="col-lg-6 col-md-6 col-sm-6 col-xs-6 pl-0">
                        <div class="banner-img">
                          <img src="assets/img/banner/3.png" alt="">
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </section>
        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h4>Reporte de gastos por Mes</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="form-row">
                                
                                <!--
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
                                
                                -->
                                 

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
                                            <th>SUCURSAL</th>
                                            <th>MES</th>
                                    
                                            <th>INGRESOS</h>
                                            <th>EGRESOS</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sales)) {
                                            foreach ($sales as $key => $item) {
                                        ?>
                                                <tr>
                                                    <td><?= $item["Sucursal"] ?></td>
                                                    
                                             
                                                    
                                                <?php if ($item['Mes'] == 1) { ?>
                                                <td>Enero</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 2) { ?>
                                                <td>Febrero</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 3) { ?>
                                                <td>Marzo</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 4) { ?>
                                                <td>Abril</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 5) { ?>
                                                <td>Mayo</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 6) { ?>
                                                <td>Junio</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 7) { ?>
                                                <td>Julio</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 8) { ?>
                                                <td>Agosto</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 9) { ?>
                                                <td>Septiembre</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 10) { ?>
                                                <td>Oatubre</td>
                                                <?php } ?> 
                                                
                                                 <?php if ($item['Mes'] == 11) { ?>
                                                <td>Noviembre</td>
                                                <?php } ?> 
                                                
                                                
                                                <?php if ($item['Mes'] == 11) { ?>
                                                <td>Diciembre</td>
                                                <?php } ?> 
                                                
                                            
                                              <td>$<?= number_format($item["Ingresos"], 2) ?></td>
                                              <td>$<?= number_format($item["Gastos"], 2) ?></td>
                                              <td>$<?= number_format($item["Ingresos"] - $item["Gastos"], 2) ?></td>
                                                
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