<?php
require '../clases/AutoCarga.php';
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
$usuario = new Usuario();
$mail = $usuario->getEmail();
$op = Request::get("op");
$r = Request::get("r");
$error = "";
switch(Request::get("solicitud")){
    case "activada":
        $error = "Your account has been activated. Enjoy!. ";
        break;
    case "noactivada":
        $error = "Your account is not active yet. ";
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
                    <h2 class="cabecera">Hello again... We are waiting for you! </h2>
                </div>
                <br>
                <div class="container2">         
                    <h2 class="error">-<?= $error ?>-</h2>
                    <a id="volver" href="index.php">Back to Login</a>
                </div>
            </div>
    </body>
</html>
