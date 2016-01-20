 <?php
session_start();

$origen= "miguel.fdez.castillo@gmail.com";
$destino= "miguel.fdez.castillo@gmail.com";
$asunto= "Prueba";
$mensaje= "llega o no llega";
$alias = "mike";

require_once '../clases/Google/autoload.php';
require_once '../clases/class.phpmailer.php';  //las últimas versiones también vienen con autoload
$cliente = new Google_Client();

$cliente->setApplicationName('ProyectoEnviarCorreo');
 $cliente->setClientId('560186546771-323f2k7vuhfr2uma1gdc3o09gjgtuagr.apps.googleusercontent.com');
        $cliente->setClientSecret('dtpKnyCb9cuaDontUMC-wntA');
$cliente->setRedirectUri('https://wusuario-miguelfdez79.c9users.io/oauth/guardar.php');
$cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
$cliente->setAccessToken(file_get_contents('token.conf'));
if ($cliente->getAccessToken()) {
    $service = new Google_Service_Gmail($cliente);
    try {
        $mail = new PHPMailer();
        $mail->CharSet = "UTF-8";
        $mail->From = $origen;
        $mail->FromName = $alias;
        $mail->AddAddress($destino);
        $mail->AddReplyTo($origen, $alias);
        $mail->Subject = $asunto;
        $mail->Body = $mensaje;
        $mail->preSend();
        $mime = $mail->getSentMIMEMessage();
        $mime = rtrim(strtr(base64_encode($mime), '+/', '-_'), '=');
        $mensaje = new Google_Service_Gmail_Message();
        $mensaje->setRaw($mime);
        $service->users_messages->send('me', $mensaje);
        echo "correo enviado correctamente";
    } catch (Exception $e) {
        print($e->getMessage());
    }
} else{
    echo "No conectado con gmail";
}
