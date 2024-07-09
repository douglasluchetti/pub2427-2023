<?php

header('Content-Type: text/html; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);

include('../config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];

    $query = "SELECT * FROM user WHERE (user_id=? OR email=?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ss", $username, $username);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $name = $row['name'];
    $email = $row['email'];
    echo $email;

    if ($result->num_rows == 0) {
        echo
        " 
        <script> 
        alert('Não foi possível enviar a senha. Verifique o e-mail ou número de matrícula e tente novamente.');
        document.location.href = '../views/nova_senha.php';
        </script>
        ";

    }

    $mail = new PHPMailer(true);
    
    //Server settings
    $mail->isSMTP();                              //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';       //Set the SMTP server to send through
    $mail->SMTPAuth   = true;             //Enable SMTP authentication
    $mail->Username   = 'pub2427@gmail.com';   //SMTP write your email
    $mail->Password   = 'xozz wujm zcxi prbn';      //SMTP password
    $mail->SMTPSecure = 'ssl';            //Enable implicit SSL encryption
    $mail->Port       = 465;                
    $mail -> charSet = "UTF-8";                    

    //Recipients
    $mail->setFrom( 'pub2427@gmail.com', 'PUB2427'); // Sender Email and name
    if ($mail->validateAddress($email)) {
        $mail->addAddress($email);
    } else {
        echo
        " 
        <script> 
        alert('Não foi possível enviar a senha. Verifique o e-mail ou número de matrícula e tente novamente.');
        document.location.href = '../views/nova_senha.php';
        </script>
        ";
    }

    $appname = "Avaliação de Disciplinas";

    $email_content = '
    <html><body>
    <div class="" style="text-align : center; margin : auto;">
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    <tr>
            <div style="margin: auto; display: inline-block; width: 100%; min-width: 350px; max-width : 720px; min-height: 150px; max-height: 320px; background-size: cover; background-color: #E38D13;">
                <h1 style="color: #FFFFFF; font-family: sans-serif; font-size: 40px;">Avaliação de Disciplinas</h1>
            </div>
        </td>
    </tr>
    </table>
    </div>
    <div style="background-color: #FFFFFF; font-family:  sans-serif; margin : auto ;min-width: 350px; max-width : 720px; min-height : 350px; max-height : 720px; color: #ffffff; line-height: 140%; text-align: center; word-wrap: break-word;">
    <div style="width: 100%; height: 4px;"></div>
    <div style="min-width: 350px; max-width : 720px; height: 4px; background-color: #1094AB;"></div>
    <div style="min-width: 350px; max-width : 720px; height: 4px; background-color: #64c4d1;"></div>
    <p style="font-size: 14px; padding-top :40px; color:black">Olá, '.$name.'!</p>
    <p style="font-size: 14px;"><span style="font-size: 16px; color:black"><strong>Você solicitou o reenvio da sua senha:</strong></span></p>
    <h1 style="color: #ff8900; line-height: 140%; text-align: center; word-wrap: break-word; font-weight: normal; font-family:  sans-serif; font-size: 22px;"><strong>'.$row['password'].'</strong></h1>
    <br>
    <br>
    <p style="font-size: 14px;"><span style="font-size: 14px; color:#4B4B4B;">Se você não reconhece essa solicitação, poderá ignorar com segurança este email.</span></p>
    <br>
    <div style="font-family:  sans-serif; color: #ffffff; line-height: 150%; text-align: center; word-wrap: break-word;">
        <p style="font-size: 14px; line-height: 150%; padding-top :10px;color:#4B4B4B"><strong>'.$appname.'</strong></p>
    </div>

    <div style="line-height: 170%; text-align: center; word-wrap: break-word;">
        <p style="font-size: 14px; line-height: 170%;color:#4B4B4B">Esse email foi gerado automaticamente para o endereço cadastrado.</p>
    </div>
    </div>

    </body>
    </html>'; 

    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $assunto = '=?UTF-8?B?'.base64_encode("Avaliação de Disciplinas | Senha").'?=';
    $mail->Subject = $assunto;   // email subject headings
    $mail->Body    = $email_content;
    $mail->AltBody = "Olá, $name! \n Sua senha é: " . $row['password'] . "\n\n Atenciosamente, \n Avaliação de Disciplinas."; 
    //$mail->Body = file_get_contents('../views/mail.html');
    
    // Success sent message alert
    if ($mail->send()) {
        session_start();
        $_SESSION['new_password'] = TRUE;
        header("Location: ../index.php");
        exit();
    } else {
        echo
        " 
        <script> 
        alert('Não foi possível enviar a senha. Verifique o e-mail ou número de matrícula e tente novamente.');
        document.location.href = '../views/nova_senha.php';
        </script>
        ";
    }
}

exit();
?>
