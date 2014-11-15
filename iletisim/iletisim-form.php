<?php

	header("Content-type: text/html; charset=utf-8");

	// Kontroller
	if (!$_POST["name"]) {
		$name = "Boş";
	}else{
		$name = $_POST["name"];
	}

	if (!$_POST["email"]) {
		$email = "Boş";
	}else{
		$email = $_POST["email"];
	}

	if (!$_POST["konu"]) {
		$konu = "Boş";
	}else{
		$konu = $_POST["konu"];
	}

	if (!$_POST["text"]) {
		$mesaj = "Boş";
	}else{
		$mesaj = $_POST["text"];
	}

	
	$text = "<span style='font-family:Lucida Sans, sans-serif; font-size:24px;'>Robocost İletişim Formu</span>
	<hr>
	<table border='0' style='font-family:'Lucida Grande', 'Lucida Sans Unicode', 'Lucida Sans', 'DejaVu Sans', Verdana, sans-serif''>
  	<tbody>
    	<tr style='border: 1px solid #DBDBDB'>
      		<td style='padding:10px'><strong>İsim: </strong></td>
      		<td style='padding:10px'>".$name."</td>
    	</tr>
    	<tr>
      		<td style='padding:10px'><strong>Email: </strong></td>
      		<td style='padding:10px'>".$email."</td>
		</tr>
    	<tr>
      		<td style='padding:10px'><strong>Konu: </strong></td>
      		<td style='padding:10px'>".$konu."</td>
		</tr>
    	<tr>
      		<td style='padding:10px'><strong>Mesaj: </strong></td>
      		<td style='padding:10px; max-width: 600px;'>".$mesaj."</td>
    	</tr>
	</tbody>
	</table>";


	include '../database/insert/class.phpmailer.php';
	$mail = new PHPMailer();
	$mail->IsSMTP();
	$mail->SMTPAuth = true;
	$mail->SMTPSecure = 'ssl';
	$mail->Host = 'smtp.gmail.com';
	$mail->Port = 465;
	$mail->Username = 'kaaninan@robocost.com';
	$mail->Password = 'kaan2mail';
	$mail->AddReplyTo('kaaninan@yandex.com', 'Reply to name');
	$mail->SetFrom($mail->Username, 'Robocost');
	$mail->AddAddress('kaaninan@outlook.com', 'Kağan İnan');
	$mail->AddAddress('meliozkurt@gmail.com', 'Melih Özkurt');
	$mail->CharSet = 'UTF-8';
	$mail->Subject = 'Robocost İletişim Formu - '.$konu;
	$mail->MsgHTML($text);
	if($mail->Send()) {
		echo 'Mesaj gönderildi!';
	} else {
		echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
	}

?>