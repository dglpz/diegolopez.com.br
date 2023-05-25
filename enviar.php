<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

//Load Composer's autoloader
require 'vendor/autoload.php';

// Google reCAPTCHA API key configuration 
$siteKey     = '6Leo_rAfAAAAAFDpYVuyqaMOGulg21_4OeIhSsqF'; 
$secretKey     = '6Leo_rAfAAAAADwYCOS0eb65NVznNX17_G9EvrEj'; 

$mail = new PHPMailer(true);

//Variaveis
$name = $_POST['name'];
$fname = $_POST['fname'];
$telephone = $_POST['telephone'];
$email = $_POST['email'];
$subject = $_POST['subject'];
$message = $_POST['message'];

//Configuracao do server
$mail->isSMTP();
$mail->Host       = 'smtp.sendgrid.net';
$mail->SMTPAuth   = true;
$mail->Username   = 'apikey';
$mail->Password   = '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';
$mail->Port       = 587;

//Recipients
$mail->setFrom('contato@diegolopez.com.br', 'Contato '.$nome);
$mail->addAddress('oi@diegolopez.com.br', 'Formulario via site '.$nome);
$conteudo = "
<table border='1'>
  <tr>
    <th>Nome</th>
    <th>Telefone</th>
    <th>E-mail</th>
    <th>Assunto</th>
    <th>Mensagem</th>
  </tr>
  <tr>
    <td>".$fname."</td>
    <td>".$telephone."</td>
    <td>".$email."</td>
    <td>".$subject."</td>
    <td>".$message."</td>
  </tr>
</table>
";

//reCAPTCHA
    // Checking valid form is submitted or not
    if (isset($_POST['Enviar'])) 
    {

    // Storing google recaptcha response
    // in $recaptcha variable
    $recaptcha = $_POST['g-recaptcha-response'];
  
    // Put secret key here, which we get
    // from google console
    $secret_key = '6LcSSrEfAAAAAMe3uTQ-8Hm7OTnUol0S-ruDwOtL';
  
    // Hitting request to the URL, Google will
    // respond with success or error scenario
    $url = 'https://www.google.com/recaptcha/api/siteverify?secret='
          . $secret_key . '&response=' . $recaptcha;
  
    // Making request to verify captcha
    $response = file_get_contents($url);
  
    // Response return by google is in
    // JSON format, so we have to parse
    // that json
    $response = json_decode($response);
  
    // Checking, if response is true or not
    if ($response->success == true) {
        echo '<script>alert("E-mail enviado com sucesso :)");window.location="index.html";</script>';
        //Content
        $mail->isHTML(true);
        $mail->Subject = 'Formulario via site';
        $mail->Body    = $conteudo;
        $mail->send();
    } 
    else {
        echo '<script>alert("E-mail não enviado... :(");window.location="index.html"</script>';
    }
}

?>