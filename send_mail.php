<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    require 'vendor/autoload.php';

    $mail = new PHPMailer(true);
	
try {
    //Server settings
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
    $mail->isSMTP();                                            //Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
    $mail->Username   = 'slavik.zb@gmail.com';                     //SMTP username
    $mail->Password   = 'hifuycmhctkcduql';                               //SMTP password
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;            //Enable implicit TLS encryption
    $mail->Port       = 587; 

    $mail->CharSet = "UTF-8";
    $mail->IsHTML(true);

    $name = $_POST["name"];
	$phone = $_POST["phone"];
    $email = $_POST["email"];
    $message = $_POST["message"];
	$email_template = "template_mail.html";

    $body = file_get_contents($email_template);
	$body = str_replace('%name%', $name, $body);
	$body = str_replace('%phone%', $phone, $body);
	$body = str_replace('%email%', $email, $body);
	$body = str_replace('%message%', $message, $body);

	$mail->setFrom($email);
	// $mail->setFrom('photoschool.com.ua', 'Фотошкола');
    $mail->addAddress("slavik.zb@gmail.com");
    $mail->Subject = "Заявка с сайту [photoschool.com.ua]";
    $mail->MsgHTML($body);

    if (!$mail->send()) {
        $message = "Помилка відправлення";
    } else {
        $message = "Дані відправлено!";
    }
	
	$response = ["message" => $message];

    header('Content-type: application/json');
    echo json_encode($response);
} catch (Exception $e) {
    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
}