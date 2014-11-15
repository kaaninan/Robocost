<?php 

	header("Content-type: text/html; charset=utf-8");


	function menu() {
		include_once "menu.php";
		$menuler = menuler();
		return $menuler;
	}


	function urunler() {

		$log = false;

		require "menu.php";
		$menuler = menuler();
		$limit = 10;

		// Her menu'de çalıştır

		foreach ($menuler as $key => $value) {

			$url = $value["link"];

			include_once "../curl.php";
			$curl = new Curl();
			$page = $curl->get($url);


			/* Toplam ürün sayısı bulma
			 * Sayfa sayısı hesaplama */

			$toplam_urun = explode("<p class=\"amount\">", $page);
			$toplam_urun = explode("</p>", $toplam_urun[1]);

			// Tek sayfa ve çok sayfalıları ayırma
			$sayfa = explode(" ", $toplam_urun[0]);

			// Çok Sayfalı
			if ($sayfa[34]) { // 6

				$urun_sayisi = $sayfa[34]; // @6
				$sayfa_sayisi = intval($urun_sayisi / $limit + 1);

				// Son sayfadaki ürün sayısı
				$artan_urun = $sayfa[34] % $limit;

			// Tek Sayfalı
			}else {

				$urun_sayisi = explode(">", $sayfa[28]); // 0
				$urun_sayisi = $urun_sayisi[1];
				$sayfa_sayisi = 1;
				$artan_urun = 0;

			}

			if ($log == true) {
				echo "Ürün Sayısı:  ";
				echo $urun_sayisi;
				echo "<br>";
				echo "Sayfa Sayısı:  ";
				echo $sayfa_sayisi;
				echo "<br>";
				echo "Artan Ürün:  ";
				echo $artan_urun;
			}


			$tem[] = @sayfa($url, $limit, $sayfa_sayisi, $urun_sayisi, $artan_urun);

			if (count($tem) > 0) {
				$urunler[] = $tem;
			}

		}

		return $urunler;
	}




	// Her sayfada çalışır
	function sayfa($url, $limit, $sayfa_sayisi, $urun_sayisi, $artan_urun) {

		$log = false;

		// Tek Sayfalı (Kategori)
		if ($artan_urun == 0) {

			$curl = new Curl();
			$page = $curl->get($url);
			for ($a=2; $a < $urun_sayisi + 3; $a++) {
				$tem[] = urun($page, $a);
				if (count($tem) > 0) {
					$urun[] = $tem;
				}
			}
		}


		// Çok Sayfalı (Kategori)
		else {

			for ($sayfa=1; $sayfa <= $sayfa_sayisi; $sayfa++) {			

				$url2 = $url."?p=".$sayfa."?limit=".$limit;

				if ($log == true) {
					echo "<br><br><br>";
					echo $url2;
					echo "<br><br>";
				}

				$curl = new Curl();
				$page = $curl->get($url2);


				// Sayfalar
				if ($sayfa < $sayfa_sayisi) {
					for ($a=2; $a < 12; $a++) {
						$urun2 = urun($page, $a);

						if ($urun2) {
							$urun[] = $urun2;
						}
					}

				}

				// Son Sayfa
				elseif ($sayfa == $sayfa_sayisi) {
					for ($b=2; $b < $artan_urun + 2; $b++) {
						$urun2 = urun($page, $b);

						if ($urun2) {
							$urun[] = $urun2;
						}
					}
				}
			}
		}

		return $urun;

	}



	// Sayfadaki tüm ürünler için çalışır
	function urun($page, $a) {

		$log = false;

		$urun = @explode("<h5>", $page);
		$urun = @explode("</h5>", $urun[$a]);
		$urun = array_filter($urun);


		$fiyat = @explode("<span class=\"price\"", $urun[1]);
		$fiyat = @explode(">", $fiyat[2]);
		$fiyat = @explode("<", $fiyat[1]);
		$fiyat = array_filter($fiyat);
		$fiyat = @$fiyat[0];
		$fiyat = @explode(" ", $fiyat);
		$fiyat = @$fiyat[0];
		$fiyat = str_replace(".", "", $fiyat);
		$fiyat = str_replace(",", ".", $fiyat);

		$isimLink = @explode("\"", $urun[0]);
		$isimLink = array_filter($isimLink);
		$link = @$isimLink[1];
		$isim = @$isimLink[3];
		$isim = stripcslashes($isim);
		$isim = addslashes($isim);	
		

		if ($fiyat) {

			
			if ($log == true) {
				echo "<br><br>";
				echo $fiyat;
				echo "<br>";						
				echo $isim;
				echo "<br>";
				echo $link;
				echo "<br>";
			}
			

			$new_urun = array("isim" => $isim, "fiyat" => $fiyat, "link" => $link);

			return $new_urun;

		}else {

			if ($log == true) {
				echo "<br>";
				echo "eklenmedi";
				echo "<br>";
			}
		
		}
	}


?>