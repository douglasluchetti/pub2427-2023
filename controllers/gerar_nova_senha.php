<?php

header('Content-Type: text/html; charset=UTF-8');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
 
//required files
require '../phpmailer/src/Exception.php';
require '../phpmailer/src/PHPMailer.php';
require '../phpmailer/src/SMTP.php';



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

    //Content
    $mail->isHTML(true);               //Set email format to HTML
    $assunto = '=?UTF-8?B?'.base64_encode("Avaliação de Disciplinas | Senha").'?=';
    $mail->Subject = $assunto;   // email subject headings
    $mail->Body    = "Olá, $name! <br> Sua senha é: " . $row['password'] . "<br><br> Atenciosamente, <br> Avaliação de Disciplinas."; //email message
    
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
