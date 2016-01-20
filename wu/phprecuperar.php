<?php

require '../clases/AutoCarga.php';
require_once '../clases/Google/autoload.php';
require_once '../clases/class.phpmailer.php';
$sesion = new Session();
$bd = new DataBase();
$gestorusuario = new ManageUsuario($bd);
$email = Request::post("email");
$usuarios = new Usuario();
$usuarios = $gestorusuario->getListAll();
$ok = 0;
$nuevopass ="";


function RandomString($length=10,$uc=TRUE,$n=TRUE,$sc=FALSE)
{
    $source = 'abcdefghijklmnopqrstuvwxyz';
    if($uc==1) $source .= 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
    if($n==1) $source .= '1234567890';
    if($sc==1) $source .= '|@#~$%()=^*+[]{}-_';
    if($length>0){
        $rstr = "";
        $source = str_split($source,1);
        for($i=1; $i<=$length; $i++){
            mt_srand((double)microtime() * 1000000);
            $num = mt_rand(1,count($source));
            $rstr .= $source[$num-1];
        }
 
    }
    return $rstr;
}

foreach ($usuarios as $indice => $u) {
    if ($u->getEmail() === $email) {
        $ok=1;
        $email= $u->getEmail();
        $alias= $u->getEmail();
        $fechaalta= $u->getFechaalta();
        $activo= $u->getActivo();
        $administrador= $u->getAdministrador();
        $personal= $u->getPersonal();
    }
}


$nuevopass = RandomString(10, true, true, true);


$bd->close();   
 if($ok === 1){
   $newuser = new Usuario ($email, sha1($nuevopass), $alias, $fechaalta, $activo, $administrador, $personal);
   $r = $gestorusuario->set($newuser, $email); 
   $r=  Mail::sendMail($email);
   header("Location:recuperar.php?error=correcto"); 
 }else{
    header("Location:recuperar.php?error=incorrecto"); 
 }



