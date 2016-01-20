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


if(strlen($pkemail) > 80 
        || strlen($alias) > 40
        || strlen($clave) > 40
        || !preg_match($date_regex, $fechaalta) 
        || ValidarUsuario::comprobar_email($pkemail) === 0
        ){
    
    header("Location:viewinsert.php?resultado=YESERRORUPDATE");
}else{
    
$newuser = new Usuario ($pkemail, sha1($clave), $alias, $fechaalta, $activo, $administrador, $personal);
Mail::sendMail($pkemail);
$r = $gestor->insert($newuser); 
$bd->close();

header("Location:viewinsert.php?resultado=NOERRORUPDATE&op=edit&r=$r");    
}

