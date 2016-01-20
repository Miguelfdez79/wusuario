<?php

require "../clases/AutoCarga.php";
$email = Request::post("email");
$pass = Request::post("pass");
//$pass = sha1($pass);
$sesion = new Session(); // descomentar
$user = new Usuario();
$user->setEmail($email);
$user->setClave($pass);
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);
$usuario = $gestorUsuario->get($email);

if (isset($email) && isset($pass)) {
        $maildelusuario = $usuario->getEmail();
        $passdelusuario = $usuario->getClave();
        $soyadmin = $usuario->getAdministrador();
        $soyworker = $usuario->getPersonal();
        $alias = $usuario->getAlias();
        if ($pass == $passdelusuario && $soyadmin == 1) {
            $user->setAdministrador(1);
            $user->setPersonal(1);
            $user->setAlias($alias);
            $sesion->setUser($user);
            $sesion->sendRedirect("gestionadmin.php");
        } else
        if ($email === $maildelusuario && $pass === $passdelusuario && $soyadmin === 0 && $soyworker === 1) {
            $user->setAdministrador(0);
            $user->setPersonal(1);
            $user->setAlias($alias);
            $sesion->setUser($user);
            $sesion->sendRedirect("gestionpersonal.php");
        } else
        if ($email === $maildelusuario && $pass === $passdelusuario && $soyadmin === 0 && $soyworker === 0) {
            $user->setAdministrador(0);
            $user->setPersonal(0);
            $user->setAlias($alias);
            $sesion->setUser($user);
            $sesion->sendRedirect("gestionusuario.php");
        }

   header("Location:index.php?error=clave");
} else {
    if ($email === null || $pass === null) {
        header("Location:index.php?error=exist");
    } else
    if (sha1($clave) !== $usuario->getClave()) {
        header("Location:index.php?error=clave");
    } else
    if ($usuario->getActivo() === "0") {
        header("Location:index.php?error=activo");
    }
}



