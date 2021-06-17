<?php
session_start();
ob_start();
$page_title = 'Ventas por més por sucursal';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
$user = current_user();

$branchs = find_by_sql("SELECT sucursal from ventas group by sucursal ORDER BY sucursal", true);

$request_branch = isset($_REQUEST["branch"]) ? $_REQUEST["branch"] : $branchs[0]["sucursal"];
$request_date_start = isset($_REQUEST["date_start"]) ? $_REQUEST["date_start"] : date("Y-m-d");
$request_date_end = isset($_REQUEST["date_end"]) ? $_REQUEST["date_end"] : date("Y-m-d");


$sales = find_by_sql("SELECT sucursal, MONTH(fecha) As mes, SUM(efectivo) As efectivo, SUM(tarjeta) As tarjeta, SUM(gastos) As gastos from ventas WHERE sucursal LIKE '{$request_branch}' AND fecha  >= '{$request_date_start}' AND fecha  <= '{$request_date_end}'  GROUP BY MONTH(fecha), sucursal", true);


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
                            <h4>Ventas por més por sucursal</h4>
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

                            <div class="table-responsive" >
                                <table class="table table-striped table-hover" id="tableExport" class="table table-striped" id="table-1" style="width:100%;">
                                    <thead>
                                        <tr>
                                            <th>Sucursal</th>
                                            <th>Mes</th>
                                            <th>EFECTIVO</th>
                                            <th>TARJETA</th>
                                            <th>GASTOS</th>
                                            <th>TOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        if (!empty($sales)) {
                                            foreach ($sales as $key => $item) {
                                        ?>
                                                <tr>
                                                    <td><?= $item["sucursal"] ?></td>
                                                    <td><?= $item["mes"] ?></td>
                                                    <td><?= number_format($item["efectivo"], 2) ?></td>
                                                    <td><?= number_format($item["tarjeta"], 2) ?></td>
                                                    <td><?= number_format($item["gastos"], 2) ?></td>
                                                    <td><?= number_format(($item["efectivo"] + $item["tarjeta"]) - $item["gastos"], 2) ?></td>
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