<?php

	/*
		- Sadece stokta olan ürünler sayfası getiriliyor.
		- Elektronike ilgili bir menu olduğu için sadece bir sayfa taranıyor.
		- Bir sayfada bütün ürünler geliyor.
		- Sayfanın kodlaması utf-8'e dönüştürülüyor.
	*/
			
	include_once 'urun.php';

	$gelen_urunler = urun();
	$menuler = array("isim" => "Kategori Yok");

	foreach ($gelen_urunler as $key => $value2) {
			
		$urunler[] = array("isim" => $value2["isim"], "fiyat" => $value2["fiyat"], "link" => $value2["link"]);

	}

	$tmp = array();

	foreach ($urunler as $row) 
	    if (!in_array($row,$tmp)) array_push($tmp,$row);

	echo count($tmp);

	include_once "../insert/urun.php";
	urunEkle("Hobievi", $tmp, $menuler);

?>