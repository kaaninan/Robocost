<?php

	header("Content-type: text/html; charset=utf-8");


	function menu() {
		include_once "menu.php";
		$menuler = menuler();
		return $menuler;
	}


	function urunler() {

		require "menu.php";
		$menuler2 = menuler();

		$urunler = array();

		foreach ($menuler2 as $key => $value) {
			$tag = $value["tag"];
			
			$tem[] = @sayfa($tag);

			if (count($tem) > 0) {
				$urunler[] = $tem;
			}
		}

		return $urunler;
	}



	function sayfa ($tag){

		$log = false;

		$urunler = array();

		$url = "http://www.robitshop.com/index.php?do=catalog/showLabel.ajax&labels=".$tag."&stockOnly=1&type=catalog";
		
		include_once "../curl.php";
		$curl = new Curl();
		$page = $curl->get($url);


		// SAYFA SAYISI BULMA

		$sayfa_s = explode("pageScroolTop", $page);

		$son = false;
		$c = 1;
		$sayfa = 2;

		while ($son == false){
			$sayfa_s2 = explode(">", $sayfa_s[$c]);
			$sayfa_s2 = explode("<", $sayfa_s2[1]);
			$sayfa_s2 = $sayfa_s2[0];

			if (!$sayfa_s2) {
				$son = true;

			}else {
				$sayfa++;
			}

			$c++;
		}



		// HER SAYFADA 

		for ($i=1; $i < $sayfa; $i++) {
			
			$url = "http://www.robitshop.com/index.php?do=catalog/showLabel.ajax&labels=".$tag."&stockOnly=1&type=catalog&tp=".$i;
			
			$curl = new Curl();
			$page = $curl->get($url);

			if ($log == true) {
				echo "<br><br><br><br>Sayfa: ";
				echo $i;
				echo "<br><br>";
			}

			$son = false;
			$a = 1;

			// Sayfanın her ürününe döngü
			while ($son == false) {

				$urun = @explode("scPictureMean", $page);
				$urun = @explode("<a href", $urun[$a]);

				if (@$urun[1]){
					$urunler[] = urun($urun);
				}

				if ($a == 30) { // TOPLAM ÜRÜN SAYISI
					$son = true;
				}

				$a++;
			}
		}

		return $urunler;
	}


	function urun ($urun){

		$log = false;

		// İsim
		$isim = explode("alt=", $urun[1]);
		$isim = explode("\"", $isim[1]);
		$isim = rtrim($isim[1], "'\'");


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


		// Fiyat
		$fiyat = explode("showcaseItem_1", $urun[1]);
		$fiyat = explode("<span>", $fiyat[1]);
		$fiyat = explode("<", $fiyat[2]);
		$fiyat = explode(" ", $fiyat[0]);
		$fiyat = str_replace(".", "", $fiyat[0]);
		$fiyat = str_replace(",", ".", $fiyat);

		// Link
		$link = explode("\"", $urun[1]);
		$link = explode("\\", $link[1]);
		$link = "http://www.robitshop.com/".$link[0];

		if ($log == true) {
			echo "İsim: ";
			echo $isim;
			echo "<br>";
			echo "Fiyat: ";
			echo $fiyat;
			echo "<br>";
			echo "Link: ";
			echo $link;
			echo "<br><br><br>";
		}

		$new_urun = array("isim" => $isim, "fiyat" => $fiyat, "link" => $link);
		

		return $new_urun;
	}

?>