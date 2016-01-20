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
$alias= Request::post("alias");
$clave = Request::post("clave");
$fechaalta = Request::post("fechaalta");
$activo = Request::post("activo");
$administrador = Request::post("administrador");
$personal = Request::post("personal");
$date_regex = '/^(19|20)\d\d[\-\/.](0[1-9]|1[012])[\-\/.](0[1-9]|[12][0-9]|3[01])$/';
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
        || !preg_match($date_regex, $fechaalta)
        || $oknorepetido === false
        ){

    header("Location:viewedit.php?resultado=YESERRORUPDATE");
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

header("Location:viewedit.php?resultado=NOERRORUPDATE&op=edit&r=$r");    
}

