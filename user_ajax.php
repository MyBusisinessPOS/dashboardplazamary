<?php
require_once('includes/load.php');

$name = isset($_REQUEST['name']) ? $_REQUEST['name'] : null;
$email = isset($_REQUEST['email']) ? $_REQUEST['email'] : null;
$role_id = isset($_REQUEST['role_id']) ? $_REQUEST['role_id'] : null;
$id =  isset($_REQUEST['user_id']) ? $_REQUEST['user_id'] : null;
$password = isset($_REQUEST['password']) ? $_REQUEST['password'] : "";
$condition = " ";

switch ($_GET["option"]) {
    case 0:
        $password = sha1(md5(trim($password)));
        $sql = "INSERT INTO users (`name`, email, `password`, created_at, updated_at, role_id) 
            VALUES('{$name}', '{$email}', '{$password}', now(), now(), {$role_id});";
        $result = $db->query($sql);
        if ($result) {
            echo json_encode(array(
                'status' => 1,
                'message' => 'Usuario guardado correctamente!',
                'data' => $result
            ));
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Error al guardar, intente más tarde!',
                'data' => array()
            ));
        }
        break;
    case 1:
        if (!empty($password)) {
            $password = sha1(md5(trim($password)));
            $condition = " , password='{$password}' ";
        }
        $result = $db->query("UPDATE users SET name='{$name}', email='{$email}', role_id={$role_id} {$condition}, updated_at=now() WHERE id={$id}");
        if ($result) {
            echo json_encode(array(
                'status' => 1,
                'message' => 'Usuario actualizado correctamente!',
                'data' => $result
            ));
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Error al actualizar, intente más tarde!',
                'data' => array()
            ));
        }
        break;
    case 2:
        $result = $db->query("UPDATE users SET deleted_at=now(), updated_at=now() WHERE id={$id}");
        if ($result) {
            echo json_encode(array(
                'status' => 1,
                'message' => 'Usuario bloqueado correctamente!',
                'data' => $result
            ));
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Error al bloquear usuario, intente más tarde!',
                'data' => array()
            ));
        }
        break;
    case 3:
        $result = $db->query("UPDATE users SET deleted_at=null, updated_at=now() WHERE id={$id}");
        if ($result) {
            echo json_encode(array(
                'status' => 1,
                'message' => 'Usuario activado correctamente!',
                'data' => $result
            ));
        } else {
            echo json_encode(array(
                'status' => 0,
                'message' => 'Error al activar usuario, intente más tarde!',
                'data' => array()
            ));
        }
        break;
}
