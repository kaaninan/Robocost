<?php

	/*
		- Ürünleri listelemek için gönderilen sayfayı (index.php?do... olarak devam eden sayfaya) kategori tagı ve sayfa numarası ile iseniyor.
		- Sadece stokta olanlar listelendiğinden ayrıca kontrol yapılmıyor.
		- Türkçe karakter sorunundan dolayı Unicode çevirme kullanılıyor.
	*/
		
	include_once 'urun.php';

	$$menuler = menu();
	$gelen_urunler = urunler();

	foreach ($gelen_urunler as $key => $value) {
		foreach ($value as $key => $value2) {
			foreach ($value2 as $key => $value2) {
			
				$urunler[] = array("isim" => $value2["isim"], "fiyat" => $value2["fiyat"], "link" => $value2["link"]);

			}
		}
	}

	$tmp = array();

	foreach ($urunler as $row) 
	    if (!in_array($row,$tmp)) array_push($tmp,$row);

	echo count($tmp);


	include_once "../insert/urun.php";
	urunEkle("Robotistan", $tmp, $menuler);

?>