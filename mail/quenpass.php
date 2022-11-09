<?php
require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
require 'vendor/autoload.php';
 class QUENPASS
 {
    public function quenmk($title,$content,$addressMail)
    {
        $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = 0;                      //Enable verbose debug output
                    $mail->isSMTP(); 
                    $mail-> CharSet = "utf-8";                                           //Send using SMTP
                    $mail->Host       = "ssl://smtp.gmail.com";                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'thaihung11092001@gmail.com';                     //SMTP username
                    $mail->Password   = 'rzqnygqmvjacluuf';                               //SMTP password
                    $mail->SMTPSecure = "SSL";  
                    $mail->Port = 465;
                                                //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('thaihung11092001@gmail.com', 'Hệ thống cung cấp mật khẩu đăng nhập.');
                    $mail->addAddress($addressMail);     //Add a recipient
                   // $mail->addAddress('ellen@example.com');               //Name is optional
                   // $mail->addReplyTo('info@example.com', 'Information');
                $mail->addCC('thaihung11092001@gmail.com');
                    //$mail->addBCC('bcc@example.com');

                    //Attachments
                   // $mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                   // $mail->addAttachment('img-sanpham/2.jfif','hinh');    //Optional name

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = $title;
                    $mail->Body    = $content;
                   // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
                    $mail->send();
                    echo"<script>alert('Hệ thống đã cung cấp mật khẩu truy cập về Email.')</script>";
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
    }
 }
 ?>