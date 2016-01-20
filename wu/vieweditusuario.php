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
                    <div id="salir"><p id="cierre"><a href="logout.php">LogOut</a></p></div>
                </div>

                <div class = "contenedorusuarios">
                    <div class="izq">
                        <div class = "contenedorsubtitulo">
                            <h3 class="solo"> Your Info:</h3>  
                        </div>

                        <div class = "muestrausuarios">                                
                            <ul class="menuV">
                                <li class="menusolo">Alias: <span class="spansolo"><?php echo " " . $user->getAlias(); ?></span></li>
                                <li class="menusolo">Email: <span class="spansolo"><?php echo " " . $user->getEmail(); ?></span></li>
                                <?php
                                echo "<div class='editdelete'>";
                                echo "<a id='borrarsolo' class='borrar' href='phpdelete.php?email=" . $user->getEmail() . "'>Delete</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                echo "<a id ='editarsolo' class='editar' href='vieweditusuario.php?email=" . $user->getEmail() . "'>Edit</a>";
                                echo "</div>";
                                ?> 
                            </ul>
                        </div>
                    </div> 

                    <div class="der">
                        <div class="centradoraux">
                            <form class="editing" action="phpeditusuario.php" method="post" enctype="multipart/form-data" id="formContactar">

                                </br>
                                <div class="inputseEspacio">
                                    <p class="infotext">Email: </p>
                                    <input class="editor" type="text" name="pkemail" size="30" id="nombre" value="" placeholder="<?php echo $usuarioaliasAUX->getEmail(); ?>" tabindex="10" /><span id="errornombre"></span>
                                    <br/>
                                </div>


                                <div class="inputseEspacio">
                                    <p class="infotext">Pass: </p>
                                    <input class="editor" type="text" name="clave" size="30" id="email" value="" placeholder="<?php echo $usuarioaliasAUX->getClave(); ?>" tabindex="10" /><span id="errormail"></span>
                                    </br>

                                </div>

                                <div class="inputseEspacio">
                                    <p class="infotext">Nickname: </p>
                                    <input  class="editor" type="text" name="alias" size="20" id="pass" value="" placeholder="<?php echo $usuarioaliasAUX->getAlias(); ?>" tabindex="10" /><span id="errorpass"></span>
                                    <br/>

                                </div>

                                <div class="inputs">
                                    <input class="editor" type="submit" id="editingbtsolo" value="send changes" tabindex="20" />
                                </div>
                            </form>   

                        </div>
                        <div class="inputse">
                            <h5 class="errorupdate"><?= $errorupdate ?></h5>
                        </div>
                    </div>                      
                </div>
            </div>
        </div>                        
    </body>
</html>

