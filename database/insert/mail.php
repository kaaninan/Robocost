<?php 
include 'class.phpmailer.php';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->Username = 'kaaninan@robocost.com';
		$mail->Password = 'kaan2mail';
		$mail->SetFrom($mail->Username, 'Robocost');
		$mail->AddAddress('kaaninan@outlook.com', 'Kağan İnan');
		$mail->AddAddress('meliozkurt@gmail.com', 'Melih Özkurt');
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Robocost | Günlük Tarama Sonucu';
		$mail->MsgHTML("dsad");
		if($mail->Send()) {
			echo 'Mail gönderildi!';
		} else {
			echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
		}
?>