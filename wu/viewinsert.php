<?php
require '../clases/AutoCarga.php';
$sesion = new Session();
if (!$sesion->isLogged()) {
    $sesion->sendRedirect("index.php");
} else {
    $user = new Usuario();
    $user = $sesion->getUser();
}
$bd = new DataBase();
$gestor = new ManageUsuario($bd);
$usuarioall = new Usuario();
$usuarioalias = new Usuario();
$usuarioaliasAUX = new Usuario();
$usuarioaliasAUX2 = new Usuario();
$usuarioalias = Request::get("usuario");
$mailselect = Request::get("email");
$usuarioselect = $gestor->get($mailselect);
$emailusuario = $user->getEmail();
$page = Request::get("page");
$error = "";
$errorupdate = "";
$usuarioTOTAL = $gestor->getListAll();

if ($page === null || $page === "") {
    $page = 1;
}
$usuarioall = $gestor->getList($page, 5);
$registros = $gestor->count();
$paginas = ceil($registros / Constants::NRPP);
$op = Request::get("op");
$r = Request::get("r");


switch (Request::get("resultado")) {
    case "siesta":
        $error = "";
        $usuarioaliasAUX = Request::get("email");
        $usuarioaliasAUX2 = $gestor->get($usuarioaliasAUX);

        break;
    case "noesta":
        $error = "Not Exist";
        break;
    case "vacio":
        $error = "Empty Field ";
        break;
    
    case "YESERRORUPDATE":
        $errorupdate = "Wrong values or date fotmat. Please try again.";
        break;
    case "NOERRORUPDATE":
        $errorupdate = "Changes successfully.";
        break;
}
?>


<html>
    <head>
        <meta charset="UTF-8">
        <title>WU</title>
        <link rel="stylesheet" type="text/css" href="../css/reset.css" media="screen" />
        <link rel="stylesheet" type="text/css" href="../css/style.css" media="screen" />
        <script src="../js/scripts.js" type="text/javascript"></script>
    </head>
    <body>
        <div class="contenedorG">
            <div id="lateralI">
                <div class = "contenedortitulo">
                    <div id="h2title"><h2 class="toptitle">Welcome <?php echo $user->getAlias(); ?> </h2></div>
                    <div id="salir"><p id="cierre"><a href="logout.php">LogOut</a></p>
                    <a class="back "href="gestionadmin.php"><-Back</a></div>
                </div>

                <div class = "contenedorusuarios">
                    
                    <div class="der2">
                        <?php
                        foreach ($usuarioall as $indice => $u) {
                            if ($u->getEmail() === $mailselect) {
                                $usuarioaliasAUX = $u;
                            }
                        }
                        ?> 
                        <div class="centradoraux">
                         <form class="insert" action="phpinsert.php" method="post" enctype="multipart/form-data" id="formContactar">

                            </br>
                            <div class="inputse">
                             <p class="infotext2">Email: </p>
                            <input class="editor2" type="text" name="pkemail" size="30" id="nombre" value="" placeholder="example@yourdomain.com" tabindex="10" /><span id="errornombre"></span>
                            <br/>
                            </div>

                            
                            <div class="inputse">
                            <p class="infotext2">Pass: </p>
                            <input class="editor2" type="text" name="clave" size="30" id="email" value="" placeholder="password" tabindex="10" /><span id="errormail"></span>
                            </br>

                            </div>
                            
                            <div class="inputse">
                                <p class="infotext2">Nickname: </p>
                            <input  class="editor2" type="text" name="alias" size="20" id="pass" value="" placeholder="nickname" tabindex="10" /><span id="errorpass"></span>
                            <br/>

                            </div>
                            
                            <div class="inputse">
                                  <p class="infotext2">Date: </p>
                            <input class="editor2" type="text" name="fechaalta" size="20" id="pass2" value="" placeholder="YYYY-MM-DD" tabindex="10" /><span id="errorpass2"></span>
                            <br/>

                            </div>
                            
                            <div class="inputseinsert">
                                <label>Active</label><select name="activo">
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select >
                             <label>Admin</label><select name="administrador">
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                             <label>Worker</label><select name="personal">
                                <option value="0">0</option>
                                <option value="1">1</option>
                            </select>
                            </div>
     
                            <div class="inputs">
                                <input class="editor" type="submit" id="inserting" value="add new user" tabindex="20" /><br/>
                                 
                            </div>
                                                      
                            
                        </form>   
                            
                        </div>
                        <div class="inputse">
                             <h5 class="errorupdate"><?= $errorupdate ?></h5>
                        </div>                 
                    </div>
                </div>
                </body>
                </html>

