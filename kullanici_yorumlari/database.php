<?php
	
	include '../functions.php';

	$sql = "CREATE TABLE `kullanici_yorumlari` (
		`id` int AUTO_INCREMENT, 
		`firma` text,
		`isim` text,
		`link` text,
		`fiyat` decimal(10,2),
		`tarih` date,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;";

	mysql_query($sql) or die (mysql_error());

?>