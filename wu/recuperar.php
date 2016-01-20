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
        $error = "Data sent. Please check your mail ";
        break;
    case "incorrecto":
        $error = "The email doesn't exist in our database. ";
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
                    <h2  class="cabecera">Don't Worry, Be Happy </h2>
                </div>
                <br>
                <div class="container2">         
                    <form class="insert" action="phprecuperar.php" method="post" enctype="multipart/form-data" id="formContactar">

                            </br>
                            <div class="inputse">
                             <p class="infotext2">We need your email. </p>
                            <input class="editor2" type="text" name="email" size="30" id="nombre" value="" placeholder="example@yourdomain.com" tabindex="10" /><span id="errornombre"></span>
                            <br/>
                            </div>
     
                            <div class="inputs">
                                <input class="editor" type="submit" id="inserting" value="send" tabindex="20" /><br/>
                                 
                            </div>
                            <div class="inputse">
                             <h5 class="errorupdate"><?= $error ?></h5>
                        </div>
                                                      
                            
                        </form> 
                </div>
            </div>
    </body>
</html>
