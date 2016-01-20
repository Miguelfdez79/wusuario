<?php
require '../clases/AutoCarga.php';
$bd = new DataBase();
$sesion = new Session();
if (!$sesion->isLogged()) {
    $sesion->sendRedirect("index.php");
} else {
    $user = new Usuario();
    $user = $sesion->getUser();
}

$querys = Request::get("email");
$gestor = new ManageUsuario($bd);
$pkemail = Request::post("pkemail");
$usuarioupdate = new Usuario;
$usuarioupdate = $gestor->get($pkemail);
$alias= Request::post("alias");
$clave = Request::post("clave");
$fechaalta = $usuarioupdate->getFechaalta();
$activo = $usuarioupdate->getActivo();
$administrador = $usuarioupdate->getAdministrador();
$personal = $usuarioupdate->getPersonal();
$oknorepetido = true;
$userall =  $gestor->getListAll();

 foreach ($userall as $indice => $usuariounico) {
     if($usuariounico->getEmail() === $pkemail && $usuariounico->getEmail() !== $user->getEmail()){
         $oknorepetido = false;
     }
     
 }
 
if(strlen($pkemail) > 80 
        || strlen($alias) > 40
        || strlen($clave) > 40
        || $oknorepetido === false
        ){

    header("Location:vieweditusuario.php?resultado=YESERRORUPDATE");
}else{
    
$newuser = new Usuario ($pkemail, sha1($clave), $alias, $fechaalta, $activo, $administrador, $personal);
$r = $gestor->set($newuser, $pkemail); 
$bd->close();

if($user->getEmail() === $querys){
    $user->setAlias($alias);
    $user->setEmail($email);
    $user->setClave(sha1($clave));
    $user->setFechaalta($fechaalta);
    $user->setPersonal($personal);
    $user->setAdministrador($administrador);
    $user->setActivo($activo);
    $sesion->destroy();
    $sesion= new Session();
    $sesion->setUser($user);
}

header("Location:vieweditusuario.php?resultado=NOERRORUPDATE&op=edit&r=$r");    
}

