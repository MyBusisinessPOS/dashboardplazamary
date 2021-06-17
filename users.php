<?php
session_start();
ob_start();
$page_title = 'Usuarios';
require_once('includes/load.php');
if (!$session->isUserLoggedIn(true)) {
    redirect('index.php', false);
}
$user = current_user();
if ($user['role_id'] != 1) {
    redirect('home.php', false);
}
$users = find_by_sql("SELECT u.*, r.name as `role` from users u INNER JOIN roles r ON u.role_id = r.id", true);
$roles = find_by_sql("SELECT * FROM roles", true);

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
                            <h4>Lista de Usuarios <button type="button" class="btn btn-primary" id="openForm" data-option="0">Agregar</button></h4>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">
                                                #
                                            </th>
                                            <th>Nombre</th>
                                            <th>Correo</th>
                                            <th>Perfil</th>
                                            <th>Ultima Actualización</th>
                                            <th>Estado</th>
                                            <th>Acción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach ($users as $key => $user) {
                                        ?>
                                            <tr>
                                                <td><?= $user['id'] ?></td>
                                                <td><?= $user['name'] ?></td>
                                                <td><?= $user['email'] ?></td>
                                                <td><?= $user['role'] ?></td>
                                                <td><?= $user['updated_at'] ?></td>
                                                <td><?= $user['deleted_at'] ? '<div class="badge badge-danger badge-shadow">Inactivo</div>' : '<div class="badge badge-success badge-shadow">Activo</div>' ?></td>
                                                <td>
                                                    <?php
                                                    if (!$user['deleted_at']) {
                                                    ?>
                                                        <a href="#" class="btn btn-xs btn-info btn-edit" data-option="1" data-id="<?= $user['id'] ?>" data-name="<?= $user['name'] ?>" data-email="<?= $user['email'] ?>" data-role="<?= $user['role_id'] ?>" ">Editar</a>
                                                    <?php if ($user['id'] != 1) { ?>
                                                        <a href=" #" class="btn btn-xs btn-danger btn-disabled" data-id="<?= $user['id'] ?>"" data-option=" 2">Bloquear</a>
                                                    <?php } ?>
                                                <?php
                                                    }
                                                ?>

                                                <?php
                                                if ($user['deleted_at']) {
                                                ?>
                                                    <a href="#" class="btn btn-xs btn-warning btn-active" data-id="<?= $user['id'] ?>"" data-option=" 3">Activar</a>
                                                <?php
                                                }
                                                ?>

                                                </td>
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

<!-- Modal with form -->
<div class="modal fade" id="formModal" tabindex="-1" role="dialog" aria-labelledby="formModal" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalTitle">Nuevo Usuario</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="formUser" class="">
                    <input type="hidden" name="option" id="option">
                    <input type="hidden" name="user_id" id="user_id">
                    <div class="form-group">
                        <label>Nombre</label>
                        <input type="text" id="name" name="name" class="form-control" placeholder="Nombre completo" required="">
                    </div>
                    <div class="form-group">
                        <label>Correo</label>
                        <input type="email" id="email" name="email" placeholder="example@example.com" class="form-control" required="">
                    </div>
                    <div class="form-group">
                        <label>Perfil</label>
                        <select id="role_id" name="role_id" class="form-control">
                            <?php
                            foreach ($roles as $key => $rol) {
                            ?>
                                <option value="<?= $rol['id'] ?>"><?= $rol['name'] ?></option>
                            <?php
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group mb-0">
                        <label>Contraseña</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Contraseña">
                        <div id="help" class="help-block">La contraseña se modifica si ingresa algo.</div>
                    </div>
                    <button type="button" id="btn-save" name="btn-save" value="btn-save" class="btn btn-primary m-t-15 waves-effect">Guardar</button>
                </form>
            </div>
        </div>
    </div>
</div>


<!-- /.content-wrapper -->
<?php include_once('template/footer.php'); ?>

<script>
    $(function(e) {
        $('#openForm').on('click', function(e) {
            $('#modalTitle').html('Nuevo Usuario');
            $('#formUser').trigger("reset");
            $('#help').hide();
            $('#password').prop('required', true);
            $('#formModal').modal('show');
        });

        $('.btn-edit').on('click', function(e) {
            $('#modalTitle').html('Editar Usuario');
            $('#formUser').trigger("reset");
            $('#formModal').modal('show');
            $('#help').show();
            $('#password').prop('required', false);
            let option = $(this).data('option');
            let id = $(this).data('id');
            let name = $(this).data('name');
            let email = $(this).data('email');
            let role_id = $(this).data('role');

            $('#user_id').val(id);
            $('#option').val(option)
            $('#name').val(name)
            $('#email').val(email)
            $('#role_id').val(role_id)
        });

        $('#btn-save').on('click', function(e) {
            let form = $('#formUser').serialize();
            let option = $('#option').val()
            store(form, option).then(response => {
                if (response.status === 1) {
                    iziToast.success({
                        title: 'Usuario',
                        message: response.message,
                        position: 'topRight'
                    });

                    $('#modalTitle').html('Nuevo Usuario');
                    $('#formUser').trigger("reset");
                    $('#help').hide();
                    $('#password').prop('required', true);
                    $('#formModal').modal('hide');
                    setTimeout(() => {
                        window.location.reload();
                    }, 1500);
                } else {
                    iziToast.error({
                        title: 'Usuario',
                        message: response.message,
                        position: 'topRight'
                    });
                }

            }).catch(error => {
                iziToast.error({
                    title: 'Usuario',
                    message: error,
                    position: 'topRight'
                });
            });

        });

        $('.btn-disabled').on('click', function(e) {
            let option = $(this).data('option');
            let id = $(this).data('id');
            swal({
                    title: 'Esta seguro?',
                    text: 'Una vez bloqueado, ¡no podrá acceder al sistema!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        disabled(id, option).then(response => {
                            if (response.status === 1) {
                                iziToast.success({
                                    title: 'Usuario',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 1500);
                            } else {
                                iziToast.error({
                                    title: 'Usuario',
                                    message: response.message,
                                    position: 'topRight'
                                });
                            }
                        }).catch(error => {
                            iziToast.error({
                                title: 'Usuario',
                                message: error,
                                position: 'topRight'
                            });
                        })
                    }
                });
        })

        $('.btn-active').on('click', function(e) {
            let option = $(this).data('option');
            let id = $(this).data('id');
            swal({
                    title: 'Esta seguro?',
                    text: 'Una vez activado, ¡podrá acceder al sistema!',
                    icon: 'warning',
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        disabled(id, option).then(response => {
                            if (response.status === 1) {
                                iziToast.success({
                                    title: 'Usuario',
                                    message: response.message,
                                    position: 'topRight'
                                });
                                setTimeout(() => {
                                    window.location.reload();
                                }, 3000);
                            } else {
                                iziToast.error({
                                    title: 'Usuario',
                                    message: response.message,
                                    position: 'topRight'
                                });
                            }
                        }).catch(error => {
                            iziToast.error({
                                title: 'Usuario',
                                message: error,
                                position: 'topRight'
                            });
                        })
                    }
                });
        })
    })

    const store = function(data, option) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '<?= BASE_URL ?>/user_ajax.php?option=' + option,
                method: 'post',
                dataType: "json",
                data: data
            }).done(resolve).fail(reject);
        });
    }

    const disabled = function(id, option) {
        return new Promise((resolve, reject) => {
            $.ajax({
                url: '<?= BASE_URL ?>/user_ajax.php?option=' + option,
                method: 'post',
                dataType: "json",
                data: {
                    user_id: id,
                    option: option
                }
            }).done(resolve).fail(reject);
        });
    }
</script>