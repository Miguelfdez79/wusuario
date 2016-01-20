<?php
require '../clases/AutoCarga.php';
require_once '../clases/Google/autoload.php';
require_once '../clases/class.phpmailer.php';
$sesion = new Session();
$bd = new DataBase();
$gestorusuario = new ManageUsuario($bd);
//Creamos el nuevo usuario a oartur de aqui.
$alias = Request::post("alias");
$email = Request::post("email");
$clave = Request::post("pass");
$clave2 = Request::post("pass2");
$fechaalta = date('Y-m-d');
$usuario = new Usuario($email, sha1($clave), $alias, $fechaalta);

if($clave === $clave2 && Filter::isEmail($email)){
    if($gestorusuario->get($email)->getEmail() != null){
        header("Location:index.php?error=existyet");
    }else{
        $r = Mail::sendMail($email);
        if($r === "SENT") {
            $gestorusuario->insert($usuario);
            $sesion->destroy();
           header("Location:checkmail.php?error=correcto");
        }else{
           header("Location:checkmail.php?error=incorrecto");
        }
    }
}else{
   header("Location:index.php?error=clavesdesiguales");
}
