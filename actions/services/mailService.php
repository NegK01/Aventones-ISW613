<?php
//Librerias necesarias para usar PHPMailer
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Llamamos las clases necesarias
require_once __DIR__ . '../../../common/PHPMailer/Exception.php';
require_once __DIR__ . '../../../common/PHPMailer/PHPMailer.php';
require_once __DIR__ . '../../../common/PHPMailer/SMTP.php';
require_once __DIR__ . '/../auth/usuario.php';

class mailService
{
    private $mail;

    public function __construct()
    {

        $this->mail = new PHPMailer(true);

        try {
            //Agregamos UTF-8 para el contenido de mail
            $this->mail->CharSet = 'UTF-8';

            //Configuracion del servidor 
            $this->mail->SMTPDebug = 0;                      //Se utiliza para mostrar errores, para desactivar usar OFF, para activar usar SERVER
            $this->mail->isSMTP();                                         //Usamos el protocolo SMTP
            $this->mail->Host       = 'smtp.gmail.com';                    //Dominio del servidor que usamos
            $this->mail->SMTPAuth   = true;                                //Activamos autentificacion
            $this->mail->Username   = 'mandangaymerequetengue@gmail.com';  //Gmail usado para mandar los mails
            $this->mail->Password   = 'ztonvzahbcdvaqrf';                  //Contraseña de aplicacion dada por google
            $this->mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;         //Protocolo de cifrado
            $this->mail->Port       = 465;                                 //Puerto que usara SMTP

            //Direcciones, en donde se envia y para quien
            $this->mail->setFrom('mandangaymerequetengue@gmail.com', 'Aventones');

            //Para enviar archivos adjuntos
            //$mail->addAttachment('/var/tmp/file.tar.gz');s
            //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');

            //Contenido del mail
            $this->mail->isHTML(true);
        } catch (Exception $e) {

            echo "Error configurar la clase mail: {$this->mail->ErrorInfo}";
        }
    }

    public function sendVerificationMail(usuario $usuario)
    {

        //Limpia los posibles anteriores mail 
        $this->mail->clearAllRecipients();
        $this->mail->clearAttachments();

        try {
            $this->mail->addAddress($usuario->getCorreo(), $usuario->getNombre());

            $this->mail->Subject = "Verificacion de cuenta:";
            $this->mail->Body    = "
            Para verificar su cuenta ingrese a este link: 
            http://isw613.net:8081/Proyecto-1/pages/verification.php?token=" . $usuario->getToken();

            $this->mail->send();
        } catch (Exception $e) {

            echo "Error al enviar el mail: {$this->mail->ErrorInfo}";
        }
    }
}
