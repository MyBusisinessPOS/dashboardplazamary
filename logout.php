<?php
  session_start();
  ob_start();
  require_once('includes/load.php');
  if(!$session->logout()) {redirect("index.php");}
?>
