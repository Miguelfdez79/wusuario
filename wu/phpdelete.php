<?php
require '../clases/AutoCarga.php';
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
$email = Request::get("email");
var_dump($email);
$r = $gestor->delete($email);
$bd->close();

header("Location:gestionadmin.php?op=delete&r=$r");