 <?php

session_start();
require_once '../clases/Google/autoload.php';
$cliente = new Google_Client();
$cliente->setApplicationName('ProyectoEnviarCorreo');
 $cliente->setClientId('560186546771-323f2k7vuhfr2uma1gdc3o09gjgtuagr.apps.googleusercontent.com');
        $cliente->setClientSecret('dtpKnyCb9cuaDontUMC-wntA');
$cliente->setRedirectUri('https://wusuario-miguelfdez79.c9users.io/oauth/guardar.php');
$cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
$cliente->setAccessType('offline');

if (isset($_GET['code'])) {
   $cliente->authenticate($_GET['code']);
   $_SESSION['token'] = $cliente->getAccessToken();
   $archivo = "token.conf";
   $fh = fopen($archivo, 'w') or die("error");
   fwrite($fh, $cliente->getAccessToken()); //almacenamiento del token
   fclose($fh);
}