<?php
session_start();
ob_start();
$page_title = 'Perfil';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
$user = current_user();

?>
<?php include_once('template/header.php'); ?>

<!-- Main Content -->
<div class="main-content">
    <section class="section">
        <div class="section-body">
            <div class="row mt-sm-4">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card author-box">
                        <div class="card-body">
                            <div class="author-box-center">
                                <img alt="image" src="<?= BASE_URL ?>/assets/img/default.png" class="rounded-circle author-box-picture">
                                <div class="clearfix"></div>
                                <div class="author-box-name">
                                    <a href="#"><?= $user["name"] ?></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card">
                        <div class="card-header">
                            <h4>Detalles personales</h4>
                        </div>
                        <div class="card-body">
                            <div class="py-4">
                                <p class="clearfix">
                                    <span class="float-left">
                                        Fecha Alta
                                    </span>
                                    <span class="float-right text-muted">
                                        <?= $user["created_at"] ?>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="padding-20">
                            <ul class="nav nav-tabs" id="myTab2" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="home-tab2" data-toggle="tab" href="#settings" role="tab" aria-selected="true">Configuración</a>
                                </li>
                            </ul>
                            <div class="tab-content tab-bordered" id="myTab3Content">
                                <div class="tab-pane fade show active" id="settings" role="tabpanel" aria-labelledby="profile-tab2">
                                    <form method="post" class="needs-validation">
                                        <div class="card-header">
                                            <h4>Editar Perfil</h4>
                                        </div>
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="form-group col-md-7 col-12">
                                                    <label>Nombre</label>
                                                    <input type="text" class="form-control" readonly value="<?= $user["name"] ?>">
                                                    <div class="invalid-feedback">
                                                        Por favor ingrese el nombre
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="form-group col-md-7 col-12">
                                                    <label>Correo electrónico</label>
                                                    <input type="email" class="form-control" readonly value="<?= $user["email"] ?>">
                                                    <div class="invalid-feedback">
                                                        Por favor complete el correo electrónico
                                                    </div>
                                                </div>
                                            </div>                                           
                                        </div>                                        
                                    </form>
                                </div>
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