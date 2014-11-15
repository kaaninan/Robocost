<?php

	include '../../functions.php';

	header("Content-type: text/html; charset=utf-8");


	$tablo = mysql_query("SHOW TABLES") or die (mysql_error());

    while ($row = mysql_fetch_row($tablo)) {  
    	$table[] = [$row[0]];
    }

    $sql = mysql_query("DROP TABLE IF EXISTS `ALL`") or die(mysql_error());

    $sql = "CREATE TABLE `ALL` (
		`id` int AUTO_INCREMENT, 
		`firma` text,
		`isim` text,
		`link` text,
		`fiyat` decimal(10,2),
		`tarih` date,
		PRIMARY KEY (`id`)
	) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;";

	mysql_query($sql) or die (mysql_error());



    foreach ($table as $key => $value) {

    	$as = @explode("_", $value[0]);

    	if (!@$as[1] && $value[0] != "ALL") {

    		$sql = mysql_query("SELECT * FROM `".$value[0]."`") or die (mysql_error());

			while($row = mysql_fetch_assoc($sql)){

				$isim = stripcslashes($row["isim"]);
				$isim = addslashes($isim);

				$sql2 = mysql_query("SELECT * FROM `".$value[0]."_Fiyat` WHERE `isim` = '".$isim."' ") or die (mysql_error());

				$row2 = mysql_fetch_array($sql2);

				$fiyat = $row2["fiyat"];

				$urunler[] = ["firma" => $row["firma"], "isim" => $row["isim"], "link" => $row["link"], "fiyat" => $fiyat, "tarih" => $row["tarih"]];

			}
    	}
    }

    foreach ($urunler as $key => $value) {

    	$isim = stripcslashes($value["isim"]);
		$isim = addslashes($isim);
    	
    	$sql = mysql_query("INSERT INTO `ALL` (`firma`, `isim`, `link`, `fiyat`, `tarih`) VALUES ('".$value["firma"]."',  '".$isim."', '".$value["link"]."', '".$value["fiyat"]."', '".$value["tarih"]."')") or die (mysql_error());

    }

?>
