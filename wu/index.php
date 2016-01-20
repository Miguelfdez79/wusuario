<?php
require '../clases/AutoCarga.php';
$bd = new DataBase();
$sesion = new Session();

$gestor = new ManageUsuario($bd);
$usuario = new Usuario();
$mail = $usuario->getEmail();
$page = Request::get("page");
if ($page === null || $page === "") {
$page = 1;
}
$usuario = $gestor->getList($page);
$registros = $gestor->count();
$paginas = ceil($registros / Constants::NRPP);
$op = Request::get("op");
$r = Request::get("r");
$error = "";
switch(Request::get("error")){
    case "exist":
        $error = "Complete the required fields. ";
        break;
    case "clave":
        $error = "Wrong User or  Password";
        break;
    case "activo":
        $error = "your account is deactivated. Check your emails, please. ";
        break;
    case "existyet":
        $error = "This e-mail already exists. ";
        break;
    case "clavesdesiguales":
        $error = "The passwords do not match or invalid email format";
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
        <?php
        if (!$sesion->isLogged()) {
            ?>

            <div id="fondo">
                <div id="presentation">
                    <h1>welcome to the community</h1>
                </div>
                <br>

                <div class="container">
                    <form class="signup" action="phplogin.php" method="post" enctype="multipart/form-data" id="formContactar">
                        <h3>Sign In</h3>
                        </br>
                        <input type="text" name="email" id="nombre" value="" placeholder="Alias o email" tabindex="10" /><span id="errornombre"></span>
                        <br/>
                        <!-- cambio de campo -->

                        </br>
                        <input type="password" name="pass" id="pass" value="" placeholder="password" tabindex="10" /><span id="errorpass"></span>
                        <br/>
                        <!-- cambio de campo -->
                        <div class="inputs">
                            <input type="submit" id="submit" value="Submit" tabindex="20" />
                        </div>
                        <div class="inputs">
                            <a class="forget" href="recuperar.php">Did you forget your password?</a>
                        </div>
                    </form>

                    <form class="signup" action="newuser.php" method="post" enctype="multipart/form-data" id="formContactar">
                        <h3>Not a Member Yet?</h3>
                        </br>
                        <input type="text" name="alias" size="30" id="nombre" value="" placeholder="name" tabindex="10" /><span id="errornombre"></span>
                        <br/>
                        <!-- cambio de campo -->
                        <input type="text" name="email" size="30" id="email" value="" placeholder="email" tabindex="10" /><span id="errormail"></span>

                        </br>
                        <input type="password" name="pass" size="20" id="pass" value="" placeholder="password" tabindex="10" /><span id="errorpass"></span>
                        <br/>

                        <!-- cambio de campo -->
                        <input type="password" name="pass2" size="20" id="pass2" value="" placeholder="repit password" tabindex="10" /><span id="errorpass2"></span>
                        <!-- cambio de campo -->
                        <div class="inputs">
                            <input type="submit" id="register" value="Register" tabindex="20" />
                        </div>
                    </form>
                </div>
                
                <div class="u-form-group">
                    <h2 class="errorindex">-<?= $error ?>-</h2>
     
                </div>
            </div>
            <?php
        } else {
            if ($sesion->getUser() === "admin") {
                $sesion->sendRedirect("gestionadmin.php");
            } else {
                $sesion->sendRedirect("gestionusuario.php");
            }
        }
        ?>
    </body>

</html>