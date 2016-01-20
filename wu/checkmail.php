<?php
require '../clases/AutoCarga.php';
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
$usuario = new Usuario();
$mail = $usuario->getEmail();
$op = Request::get("op");
$r = Request::get("r");
$error = "";
switch(Request::get("error")){
    case "correcto":
        $error = "Your mail have sent successfully. ";
        break;
    case "incorrecto":
        $error = "There was a technical problem. :-( ";
        break;
}
?>

<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">

        <title>WelcomeUser</title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
       <!-- <script src="validacion.js"></script> -->
    </head>
    <body>
            <div id="fondo">
                <div id="presentation">
                    <h2  class="cabecera">We have sent you an e-mail. Please, Check it! </h2>
                </div>
                <br>
                <div class="container2">         
                    <h2 class="error">-<?= $error ?>-</h2>
                    <a id="volver" href="index.php">Back to Login</a>
                </div>
            </div>
    </body>
</html>
