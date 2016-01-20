<?php
require '../clases/AutoCarga.php';

$bd = new DataBase();
$gestorusuario = new ManageUsuario($bd);
$sha1 = Request::get("sha1");
$email = Request::get("email");

//Hacemos comprobacion del sh1 y lo activamos si todo va bien
if (sha1($email . Constants::SEMILLA) === $sha1) {
    echo sha1($email . Constants::SEMILLA);
    $usuario = new Usuario();
    echo $email;
    $usuario = $gestorusuario->get($email);
    var_dump($usuario);
    $usuario->setActivo(1);
    $r = $gestorusuario->set($usuario, $email);
    echo $r;
    header("Location:welcome.php?solicitud=activada");
} else {
    header("Location:welcome.php?solicitud=noactivada");
}
