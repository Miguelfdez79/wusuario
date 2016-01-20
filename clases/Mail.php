<?php

class Mail {

    static function sendMail($destino) {
        $origen = "miguel.fdez.castillo@gmail.com";
        $asunto = "WU User";
        $destino = $destino;
              $alias = "Mike";
        $sha1 = sha1($destino . Constants::SEMILLA);
        $mensaje = "Saludos Usuario. Para completar su registro en WU pulse el siguiente enlace:
        https://wusuario-miguelfdez79.c9users.io/wu/phpdardealta.php?email=$destino&sha1=$sha1";
        $cliente = new Google_Client();
        $cliente->setApplicationName('ProyectoEnviarCorreo');
        $cliente->setClientId('560186546771-323f2k7vuhfr2uma1gdc3o09gjgtuagr.apps.googleusercontent.com');
        $cliente->setClientSecret('dtpKnyCb9cuaDontUMC-wntA');
        $cliente->setRedirectUri('https://wusuario-miguelfdez79.c9users.io/oauth/guardar.php');
        $cliente->setScopes('https://www.googleapis.com/auth/gmail.compose');
        $cliente->setAccessToken(file_get_contents('../oauth/token.conf'));
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
                $r = $service->users_messages->send('me', $mensaje);
                echo "se ha enviado";
            } catch (Exception $e) {
                print("Error en el envío de correo" . $e->getMessage());
            }
        } else {
            echo "no conectado con gmail";
        }
        return $r["labelIds"][0];
    }

}
