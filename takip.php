<?php

	include 'functions.php';

	$id = $_POST['id'];
	echo $id;

	// URUN SORGULAMA

	$calistir = mysql_query("SELECT * FROM  `ALL` WHERE  `id` = '".$id."' ") or die(mysql_error());
	
	if (mysql_num_rows($calistir) == 1) {
		
		while ($row = mysql_fetch_array($calistir)) {
			$firma = $row["firma"];
			$isim = $row["isim"];
		}

		$result = mysql_query("SELECT * FROM `".$firma."` WHERE `isim` = '".$isim."'") or die (mysql_error());
		while ($satir = mysql_fetch_array($result)) {
			$id = $satir["id"];
		}

	}

	// EKLEME

	$sql = mysql_query("INSERT INTO `robocost_kullanici`.`takip` (`urun_firma`, `urun_id`, `user_id`) VALUES ('".$firma."', '".$id."', '".$_SESSION["id"]."');") or die(mysql_error());

	echo "Eklendi";

?>