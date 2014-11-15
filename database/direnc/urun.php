<?php

	header("Content-type: text/html; charset=utf-8");

	function menu() {
		include_once "menu.php";
		$menuler = menuler();
		return $menuler;
	}
	

	function urunler() {

		include_once "menu.php";

		$menuler = menuler();

		// HER MENUDE
		foreach ($menuler as $key => $value) {

			$tag = $value["tag"];
			
			$tem[] = @sayfa($tag);

			if (count($tem) > 0) {
				$urunler[] = $tem;
			}

		}
		return $urunler;
	}
	

	function sayfa($tag) {

		$log = false;

		$url = "http://www.direnc.net/index.php?do=catalog/showLabel.ajax&labels=".$tag."&stockOnly=1";
		include_once "../curl.php";
		$curl = new Curl();
		$page = $curl->get($url);

		$urunler = array();

		// TOPLAM SAYFA SAYISINI BULMA
		$sayfa_s = explode("pageScroolTop", $page);

		$son = false;
		$c = 1;
		$sayfa = 1;

		while ($son == false){
			$sayfa_s2 = explode(">", $sayfa_s[$c]);
			$sayfa_s2 = explode("<", $sayfa_s2[1]);
			$sayfa_s2 = $sayfa_s2[0];

			// NOT: Tek sayfa olanlar için \n kontrolü yapılmıştır.

			if (!$sayfa_s2) {
				$son = true;
			}
			elseif (strcmp($sayfa_s2, "\n") > 80){
				$son = true;
			} 
			else {
				$sayfa++;
			}

			$c++;
		}

		if ($log == true) {
			echo "<strong>Sayfa Sayısı: ";
			echo $sayfa;
			echo "<br><br></strong>";
		}


		// Sayfanın ürünlerine döngü

		for ($i=1; $i <= $sayfa; $i++) {

			if ($log == true) {
				echo "<br><br><br><br><br><br><br><br><br><strong>Sayfa -> ";
				echo $i;
				echo "<br><br></strong>";
			}
			
			$url = "http://www.direnc.net/index.php?do=catalog/showLabel.ajax&labels=".$tag."&stockOnly=1&tp=".$i;
			include_once "../curl.php";
			$curl = new Curl();
			$page = $curl->get($url);

			$urunler[] = urun($page);
			
		}

		$a = 0;
		foreach ($urunler as $key => $value) {
			$a++;
		}

		return $urunler;

	}


	function urun($page) {

		$log = false;

		$urun = explode("_productItem", $page);

		$urunler = array();

		for ($i=1; $i < 61; $i++) { 

			if (@$urun[$i]){

				// ISIM
				$isim = explode("alt=\\\"", $urun[$i]); // ++
				$isim = explode("\"", $isim[1]);
				$isim = rtrim($isim[0], "'\'");


				// Türkçe Karakter Çözümü
				$sablonlar[] = '/\\\\u00fc/';
				$sablonlar[] = '/\\\\u00dc/';
				$sablonlar[] = '/\\\\u015f/';
				$sablonlar[] = '/\\\\u015e/';
				$sablonlar[] = '/\\\\u0131/';
				$sablonlar[] = '/\\\\u0130/';
				$sablonlar[] = '/\\\\u00e7/';
				$sablonlar[] = '/\\\\u00c7/';
				$sablonlar[] = '/\\\\u00f6/';
				$sablonlar[] = '/\\\\u00d6/';
				$sablonlar[] = '/\\\\u011f/';
				$sablonlar[] = '/\\\\u011e/';
				$sablonlar[] = '/\\\\u00ae/';
				$sablonlar[] = '/\\\\u00a9/';


				$yeniler[] = 'ü';
				$yeniler[] = 'Ü';
				$yeniler[] = 'ş';
				$yeniler[] = 'Ş';
				$yeniler[] = 'ı';
				$yeniler[] = 'İ';
				$yeniler[] = 'ç';
				$yeniler[] = 'Ç';
				$yeniler[] = 'ö';
				$yeniler[] = 'Ö';
				$yeniler[] = 'ğ';
				$yeniler[] = 'Ğ';
				$yeniler[] = '&#174;';
				$yeniler[] = '&#169;';


				$isim = preg_replace($sablonlar, $yeniler, $isim);
				$isim = stripcslashes($isim);
				$isim = addslashes($isim);



				// FİYAT
				$fiyat = explode("<strong>", $urun[$i]);
				$fiyat = explode(" ", $fiyat[1]);
				$fiyat = $fiyat[0];
				$fiyat = str_replace(".", "", $fiyat);
				$fiyat = str_replace(",", ".", $fiyat);


				// LINK
				$link = explode("<a href=\\\"", $urun[$i]);
				$link = explode("\\", $link[1]);
				$link = "http://www.direnc.net/".$link[0];

				if ($log == true) {
					echo $isim;
					echo "<br>";
					echo $link;
					echo "<br>";
					echo $fiyat;
					echo "<br><br>";
				}

				$urunler[] = array("isim" => $isim, "fiyat" => $fiyat, "link" => $link);

			}
		}

		return $urunler;
	}

?>