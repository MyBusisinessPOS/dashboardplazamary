<?php
session_start();
ob_start();
$page_title = 'Reporte de beneficios';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
$user = current_user();

$request_date_start = isset($_REQUEST["date_start"]) ? $_REQUEST["date_start"] : date("Y-m-d");
$request_date_end = isset($_REQUEST["date_end"]) ? $_REQUEST["date_end"] : date("Y-m-d");

//REPORTE DE VENTAS POR SUCURSAL
$sales = find_by_sql("SELECT ventas.sucursal As Sucursal, SUM(ventas.gastos) As Gastos, SUM(ventas.efectivo + ventas.tarjeta) As Ingresos, MONTH(ventas.fecha) AS Mes FROM ventas WHERE ventas.fecha >= '2021-03-01' aND ventas.fecha <= '2021-03-31' AND ventas.sucursal = 'ALLENDE' GROUP BY ventas.sucursal ORDER BY ventas.sucursal, mes asc", true);

$traspasos = find_by_sql("SELECT SUM(valor_costo) As Costo FROM traspasos WHERE fecha >= '2021-03-01' aND fecha <= '2021-03-31' AND sucursal = 'ALLENDE' ", true);




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
                            <h4>Beneficios por mes antes de gastos generales</h4>
                        </div>
                        <div class="card-body">
                            <form method="GET" class="form-row">
                                

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
                                            <th>VENTAS</h>
                                            <th>GASTOS</th>
                                            <th>TRASPASOS</th>
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
                                                
                                                
                                                <?php if ($item['Mes'] == 12) { ?>
                                                <td>Diciembre</td>
                                                <?php } ?> 
                                                
                                            
                                              <td>$<?= number_format($item["Ingresos"], 2) ?></td>
                                              <td>$<?= number_format($item["Gastos"], 2) ?></td>
                                              
                                               <?php
                                                if (!empty($sales)) {
                                                    foreach ($traspasos as $key => $t) {
                                                ?>
                                                   
                                                    <td>$<?= number_format($t["Costo"], 2) ?></td>
                                                    
                                                       <td>$<?= number_format($item["Ingresos"] - $item["Gastos"] - $t["Costo"], 2) ?></td>
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