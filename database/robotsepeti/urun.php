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

		include_once "../curl.php";
		$curl = new Curl();

		foreach ($menuler as $key => $value) {
			
			$page = $curl -> get($value["link"]."&limit=100");

			$tem[] = @sayfa($page);

			if (count($tem) > 0) {
				$urunler[] = $tem;
			}

		}

		return $urunler;

	}


	function sayfa($page) {

		$log = false;

		$urun = explode("<div class=\"product-list\">", $page);
		$urun = @explode("<div class=\"image\">", $urun[1]);

		$son = false;
		$i = 1;

		while ($son == false) {

			$link = @explode("<a href=\"", $urun[$i]);
			$link2 = @explode("\"", $link[1]);

			if (!@$link2[0]) {
				$son = true;
				
			}else {

				$link = $link2[0];
				$isim = $link2[4];
				$isim = stripcslashes($isim);
				$isim = addslashes($isim);

				$fiyat = @explode("<span class=\"price-new\">", $urun[$i]);
				
				
				if (@$fiyat[1]) { // İndirimli fiyat varsa
					
					$fiyat = explode("TL", $fiyat[1]);
					$fiyat = @str_replace(".", "", $fiyat[0]);
					$fiyat = trim($fiyat);

				}else {

					$fiyat = explode("<div class=\"price\">", $urun[$i]);
					$fiyat = explode("TL", $fiyat[1]);
					$fiyat = @str_replace(".", "", $fiyat[0]);
					$fiyat = trim($fiyat);
				}

				if ($log == true) {
					echo $isim;
					echo "<br>";
					echo $fiyat;
					echo "<br>";
					echo $link;
					echo "<br><br>";
				}

				$urunler[] = ["isim" => $isim, "fiyat" => $fiyat, "link" => $link];

			}

				

			$i++;
		}

		return $urunler;

	}
	
?>