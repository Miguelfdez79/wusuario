<?php

require "../clases/AutoCarga.php";
$email = Request::post("email");
$bd = new DataBase();
$gestorUsuario = new ManageUsuario($bd);
$userall = $gestorUsuario->getListAll();

if ($email != NULL || $email !="") {
    foreach ($userall as $indice => $usuariounico) {
        if ($email === $usuariounico->getEmail()) {
            $encontrado = $usuariounico->getEmail();
            header("Location:gestionadmin.php?email=$encontrado&resultado=siesta");
            break;
        }else{
             header("Location:gestionadmin.php?email=$email&resultado=noesta");
        }
        if($email === "/all"){
            header("Location:gestionadmin.php?resultado=siesta");
        }
    }
            
} else {
        header("Location:gestionadmin.php?resultado=vacio");

}



