<?php

	/*
		- Sadece Stoktakiler seçeneği olmadığından ürünün stok durumuna göre kontroller yapılmıştır.
		- Sadece ana kategoriler taranmıştır.
	*/
			
	require 'urun.php';

	$gelen_urunler = urunler();
	$menuler = menu();

	foreach ($gelen_urunler as $key => $value2) {
		foreach ($value2 as $key => $value2) {
			foreach ($value2 as $key => $value2) {
			
				$urunler[] = array("isim" => $value2["isim"], "fiyat" => $value2["fiyat"], "link" => $value2["link"]);

			}
		}
	}

	$tmp = array();

	foreach ($urunler as $row) 
	    if (!in_array($row,$tmp)) array_push($tmp,$row);

	echo count($tmp);

	require "../insert/urun.php";
	urunEkle("Roboweb", $tmp, $menuler);

?>