<?php 
session_start();
ob_start();
include_once('includes/load.php'); 

$req_fields = array('email', 'password');
validate_fields($req_fields);
$username = remove_junk($_POST['email']);
$password = remove_junk($_POST['password']);

if (empty($errors)) {
  $user_id = authenticate($username, $password);
  if ($user_id) {
    //create session with id
    $session->login($user_id);
    //Update Sign in time
    $session->msg("s", "Bienvenido");
    redirect('home.php', false);
  } else {
    $session->msg("d", "Usuario y/o contraseña incorrecto.");
    redirect('index.php', false);
  }
} else {
  $session->msg("d", $errors);
  redirect('index.php', false);
}

?>
