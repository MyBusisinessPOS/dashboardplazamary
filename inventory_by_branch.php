<?php
session_start();
ob_start();
$page_title = 'Existencias por sucursal';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
$user = current_user();


$branchs = find_by_sql("SELECT sucursal from ventas group by sucursal ORDER BY sucursal", true);

$request_branch = isset($_REQUEST["branch"]) ? $_REQUEST["branch"] : $branchs[0]["sucursal"];


$productInStock = find_by_sql("SELECT Count(*) As Total 
							FROM inventarios AS i
							INNER JOIN productos As p On i.articulo = p.articulo
							WHERE i.existencia > 0 AND sucursal  LIKE '{$request_branch}' ", true);


$productNotStock = find_by_sql("SELECT Count(*) As Total 
							FROM inventarios AS i
							INNER JOIN productos As p On i.articulo = p.articulo
							WHERE i.existencia <= 0 AND sucursal LIKE '{$request_branch}' ", true);

//CONTIENE LOS ACUMULADOS DE LA CONSULTA
$inventoryBySucursal = find_by_sql("SELECT i.articulo, p.descrip, i.existencia, i.sucursal 
FROM inventarios AS i
INNER JOIN productos As p On i.articulo = p.articulo
WHERE sucursal  LIKE '{$request_branch}' AND i.existencia > 0 ", true);



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
                          <h5 class="font-15">Existencias por sucursal</h5>
                          <h2 class="mb-3 font-18"><?= $productInStock[0]['Total'] ?></h2>
                
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
                          <h5 class="font-15"> Productos sin Stock</h5>
                          <h2 class="mb-3 font-18"><?= $productNotStock[0]['Total']  ?></h2>
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
                                            <th>Articulo</th>
                                             <th>Descripcion</th>
                                               <th>Existencia</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    	
                                        <?php
                                        if (!empty($inventoryBySucursal)) {
                                            foreach ($inventoryBySucursal as $key => $item) {
                                        ?>
                                                <tr>
                                                  <td><?= $item["sucursal"] ?></td>
                                                  <td><?= $item["articulo"] ?></td>
                                                  <td><?= $item["descrip"] ?></td>
                                                  <td><?= $item["existencia"] ?></td>
                                                  
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