<?php

	/*
		TODO - İndirimli Ürün

		- Sadece stoktaki ürünler taranıyor.
		- Sayfalar tag sistemiyle çaprılıyor.
		- Türkçe karakter sorunu için Unicode çevirme kullanılıyor.
	*/


	include_once 'urun.php';

	$menuler = menu();
	$gelen_urunler = urunler();

	print_r($gelen_urunler);

	foreach ($gelen_urunler as $key => $value2) {
		foreach ($value2 as $key => $value2) {
			foreach ($value2 as $key => $value2) {
				foreach ($value2 as $key => $value2) {

					$urunler[] = array("isim" => $value2["isim"], "fiyat" => $value2["fiyat"], "link" => $value2["link"]);

				}
			}
		}
	}

	$tmp = array();

	foreach ($urunler as $row) 
	    if (!in_array($row,$tmp)) array_push($tmp,$row);

	echo count($tmp);


	include_once "../insert/urun.php";
	urunEkle("Direnç", $tmp, $menuler);


?>