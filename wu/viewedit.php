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
                            <h3 class="Search"> Users List:</h3>  
                        </div>
                        <div class = "contenedorsubtitulo">
                            <h3 class="Search"> Search User:</h3>
                            <form class="signup2" action="search.php" method="post" enctype="multipart/form-data" id="formContactar">
                                <div class="inputs2">
                                    <input type="text" name="email" size="20" id="nombre" value="" placeholder="email" tabindex="10" />
                                </div>

                                <div class="inputs2">
                                    <input type="submit" id="submit" value="Submit" tabindex="20" />
                                </div>
                                <div class="u-form-group">
                                    <h5 class="errorsearch"><?= $error ?></h5>

                                </div>
                            </form>

                            </form>
                        </div>
                        <div class = "muestrausuarios">                                
                            <ul class="menuV">
                                <?php
                                foreach ($usuarioTOTAL as $indice => $u) {
                                        if ($usuarioaliasAUX === $u->getEmail()) {
                                            $maildelusuario = $u->getEmail();
                                            $alias = $u->getAlias();
                                            echo "<li><a href='gestionadmin.php?usuario=$maildelusuario'>" . $alias . "</a></li>";
                                            echo "<div class='editdelete'>";
                                            echo "<a class='borrar' href='phpdelete.php?id=" . $maildelusuario . "'>Delete</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                            echo "<a class='editar' href='viewedit.php?id=" . $maildelusuario . "'>Edit</a>";
                                            echo "</div>";
                                        }
                                    }
                                if ($usuarioaliasAUX2->getEmail() === null || $usuarioaliasAUX2->getEmail() === "") {
                                    foreach ($usuarioall as $indice => $u) {
                                        $maildelusuario = $u->getEmail();
                                        $alias = $u->getAlias();
                                        echo "<li><a href='gestionadmin.php?usuario=$maildelusuario'>" . $alias . "</a></li>";
                                        echo "<div class='editdelete'>";
                                        echo "<a class='borrar' href='phpdelete.php?email=" . $maildelusuario . "'>Delete</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                                        echo "<a class='editar' href='viewedit.php?email=" . $maildelusuario . "'>Edit</a>";
                                        echo "</div>";
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
                        <div class = "acciones">

                        </div>            
                    </div>
                    <div class="der">
                        <?php
                        foreach ($usuarioall as $indice => $u) {
                            if ($u->getEmail() === $mailselect) {
                                $usuarioaliasAUX = $u;
                            }
                        }
                        ?> 
                        <div class="centradoraux">
                         <form class="editing" action="phpedit.php" method="post" enctype="multipart/form-data" id="formContactar">

                            </br>
                            <div class="inputse">
                             <p class="infotext">Email: </p>
                            <input class="editor" type="text" name="pkemail" size="30" id="nombre" value="" placeholder="<?php echo $usuarioaliasAUX->getEmail(); ?>" tabindex="10" /><span id="errornombre"></span>
                            <br/>
                            </div>

                            
                            <div class="inputse">
                            <p class="infotext">Pass: </p>
                            <input class="editor" type="text" name="clave" size="30" id="email" value="" placeholder="<?php echo $usuarioaliasAUX->getClave(); ?>" tabindex="10" /><span id="errormail"></span>
                            </br>

                            </div>
                            
                            <div class="inputse">
                                <p class="infotext">Nickname: </p>
                            <input  class="editor" type="text" name="alias" size="20" id="pass" value="" placeholder="<?php echo $usuarioaliasAUX->getAlias(); ?>" tabindex="10" /><span id="errorpass"></span>
                            <br/>

                            </div>
                            
                            <div class="inputse">
                                  <p class="infotext">Date: </p>
                            <input class="editor" type="text" name="fechaalta" size="20" id="pass2" value="" placeholder="<?php echo $usuarioaliasAUX->getFechaalta(); ?>" tabindex="10" /><span id="errorpass2"></span>
                            <br/>

                            </div>
                            
                            <div class="inputse">
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
                                <input class="editor" type="submit" id="editingbt" value="send changes" tabindex="20" />
                            </div>
                            
                            
                        </form>   
                            
                        </div>
                        <div class="inputse">
                             <h5 class="errorupdate"><?= $errorupdate ?></h5>
                        </div>
                        
                        
                    </div>
                                      <div class = "acciones">
                            <form class="signup2" action="phpinsert.php" method="post" enctype="multipart/form-data" id="formContactar">
                                <div class="inputspie">
                                    <input type="submit" id="submit" value=" + Add User" tabindex="20" />
                                </div>
                            </form>
                        </div> 
                </div>
                </body>
                </html>

