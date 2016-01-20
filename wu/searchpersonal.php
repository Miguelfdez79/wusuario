<?php

require "../clases/AutoCarga.php";
$email = Request::post("email");
$bd = new DataBase();
$gestorusuario = new ManageUsuario($bd);
$userall = $gestorusuario->getListAll();
$userAUX = $gestorusuario->get($email);

if (($email != NULL || $email !="") && $userAUX->getAdministrador() !== "1" ) {
    foreach ($userall as $indice => $usuariounico) {
        if ($email === $usuariounico->getEmail()) {
            $encontrado = $usuariounico->getEmail();
            header("Location:gestionpersonal.php?email=$encontrado&resultado=siesta");
            break;
        }else{
             header("Location:gestionpersonal.php?email=$email&resultado=noesta");
        }
        if($email === "/all"){
            header("Location:gestionpersonal.php?resultado=siesta");
        }
    }
            
} else {
        header("Location:gestionpersonal.php?resultado=vacio");

}



