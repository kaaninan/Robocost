<?php

	include '../functions.php';

	if (isset($_POST["search"])){

		
		$ara = $_POST["search"];

		$result = mysql_query("SELECT * FROM `ALL` WHERE `isim` LIKE '%".$ara."%' ORDER BY `fiyat` ") or die (mysql_error());

		while ($row = mysql_fetch_array($result)) {
			
			$kayitlar[] = ["firma" => $row["firma"], "isim" => $row["isim"], "fiyat" => $row["fiyat"], "link" => $row["link"]];

		}

		echo json_encode($kayitlar);
		
	}else {
		$kayitlar[] = ["firma" => "boş", "isim" => "boş", "link" => "boş", "fiyat" => "boş"];

		echo json_encode($kayitlar);
	}

?>