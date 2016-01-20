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
$emailusuario = $user->getEmail();
$page = Request::get("page");
 $error = "";

if ($page === null || $page === "") {
    $page = 1;
}
$usuarioall = $gestor->getList($page, 5);
$usuarioTOTAL = $gestor->getListAll();
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
                            <h3 class="Search"> Users List:</h3>  
                        </div>
                        <div class = "contenedorsubtitulo">
                            <h3 class="Search"> Search User:</h3>
                            <form class="signup2" action="searchpersonal.php" method="post" enctype="multipart/form-data" id="formContactar">
                                <div class="inputs2">
                                    <input type="text" name="email" size="20" id="nombre" value="" placeholder="email" tabindex="10" />
                                </div>

                                <div class="inputs2">
                                    <input type="submit" id="submit" value="Submit" tabindex="20" />
                                </div>
                                <div class="u-form-group">
                    <h5 class="errorsearch"><?= $error ?></h2>
     
                </div>
                            </form>

                            </form>
                        </div>
                        <div class = "muestrausuarios">                                
                            <ul class="menuV">
                                <?php
                                
                                    foreach ($usuarioTOTAL as $indice => $u) {
                                        if ($usuarioaliasAUX === $u->getEmail() &&  $u->getAdministrador() !== "1") {
                                            $maildelusuario = $u->getEmail();
                                            $alias = $u->getAlias();
                                            echo "<li><a href='gestionpersonal.php?usuario=$maildelusuario'>" . $alias . "</a></li>";
                                            echo "<div class='editdelete'>";
                                            echo "<a class='borrar' href='phpdelete.php?email=" . $maildelusuario . "'>Delete</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            echo "<a class='editar' href='vieweditpersonal.php?email=" . $maildelusuario . "'>Edit</a>";
                                            echo "</div>";
                                        }
                                    }
                                
                                if ($usuarioaliasAUX2->getEmail() === null || $usuarioaliasAUX2->getEmail() === "") {
                                    foreach ($usuarioall as $indice => $u) {
                                        if($u->getAdministrador() !== "1"){
                                            $maildelusuario = $u->getEmail();
                                        $alias = $u->getAlias();
                                        echo "<li><a href='gestionpersonal.php?usuario=$maildelusuario'>" . $alias . "</a></li>";
                                        echo "<div class='editdelete'>";
                                        echo "<a class='borrar' href='phpdelete.php?email=" . $maildelusuario . "'>Delete</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                        echo "<a class='editar' href='vieweditpersonal.php?email=" . $maildelusuario . "'>Edit</a>";
                                        echo "</div>";
                                        }                                    
                                    }
                                }
                                ?>   
                            </ul>

                        </div>
                        <div class = "paginacion">                         
                            <br/>           
                            <a class='pag' href="page=1">First</a>
                            <a class='pag' href="?page= <?php echo max(1, $page - 1); ?>">Back</a>
                            <a class='pag' href="?page= <?php echo min($page + 1, $paginas); ?>">Next</a>
                            <a class='pag' href="?page= <?php echo $paginas; ?>">Last</a>
                        </div> 
           
                    </div>
                    <div class="der">
                        <?php
                        foreach ($usuarioall as $indice => $u) {
                            if ($u->getEmail() === $usuarioalias) {
                                $usuarioaliasAUX2 = $u;
                            }
                        }
                        ?> 
                        <div class="infousucontainer">
                            <p class="infotext">Email: </p>
                            <div class="infousu">
                                <span class="spantext"><?php echo $usuarioaliasAUX2->getEmail(); ?></span>    
                            </div>  
                        </div>
                        <div class="infousucontainer">
                            <p class="infotext">Password: </p>
                            <div class="infousu">
                                <span class="spantext"><?php echo $usuarioaliasAUX2->getClave(); ?></span>    
                            </div>  
                        </div>
                        <div class="infousucontainer">
                            <p class="infotext">Nickname: </p>
                            <div class="infousu">
                                <span class="spantext"><?php echo $usuarioaliasAUX2->getAlias(); ?></span>    
                            </div>  
                        </div>
                        <div class="infousucontainer">
                            <p class="infotext">Entry Date: </p>
                            <div class="infousu">
                                <span class="spantext"><?php echo $usuarioaliasAUX2->getFechaalta(); ?></span>    
                            </div>  
                        </div>
                    
                        </div>
                        
                    </div>
                    </div>
                            <div class = "acciones">
                                <form class="signup2" action="viewinsertpersonal.php" method="post" enctype="multipart/form-data" id="formContactar">
                                <div class="inputspie">
                                    <input type="submit" id="submit" value=" + Add User" tabindex="20" />
                                </div>
                            </form>
                        </div> 

                </div>
                             
    </body>
</html>

