<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/src/Exception.php';
require 'phpmailer/src/PHPMailer.php';
require 'phpmailer/src/SMTP.php';

$mail = new PHPMailer(true);
$mail->CharSet = 'UTF-8';
$mail->setLanguage('ru', 'phpmailer/language/');
$mail->IsHTML(true);


$mail->isSMTP();                                            //Send using SMTP
$mail->Host       = 'smtp.timeweb.ru';                     //Set the SMTP server to send through
$mail->SMTPAuth   = true;                                   //Enable SMTP authentication
$mail->Username   = 'drivers-lending77@es-trans.ru';                     //SMTP username
$mail->Password   = 'es-trans77';                               //SMTP password
$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
$mail->Port       = 465;


//От кого письмо
$mail->setFrom('drivers-lending77@es-trans.ru', 'Лендинг "Доставим и растаможим"'); // Указать нужный E-mail
//Кому отправить
$mail->addAddress('sde@es-trans.pro'); // Указать нужный E-mail 
//Тема письма
$mail->Subject = 'Привет! Это запрос с лендинга "Доставим и растаможим".';

//Тело письма
$body = '<h1>Нас интересуют услуги ООО "ЕС Транс"</h1>';

if (trim(!empty($_POST['company-name']))) {
	$body .= '<p><strong>Название компании:</strong> ' . $_POST['company-name'] . '</p>';
}

if (trim(!empty($_POST['first-name']))) {
	$body .= '<p><strong>Имя:</strong> ' . $_POST['first-name'] . '</p>';
}

if (trim(!empty($_POST['tel']))) {
	$body .= '<p><strong>Телефон или мессенджер:</strong> ' . $_POST['tel'] . '</p>';
}

if (trim(!empty($_POST['email']))) {
	$body .= '<p><strong>E-mail:</strong> ' . $_POST['email'] . '</p>';
}

if (trim(!empty($_POST['text-message']))) {
	$body .= '<p><strong>Вопрос по доставке или таможенному оформлению:</strong> ' . $_POST['text-message'] . '</p>';
}

// Проверка на бота
if ($_POST['code'] != 'NOSPAM') {
	exit;
}

$mail->Body = $body;

//Отправляем
if (!$mail->send()) {
	$message = 'Ошибка';
} else {
	$message = 'Данные отправлены!';
}

$response = ['message' => $message];

header('Content-type: application/json');
echo json_encode($response);
