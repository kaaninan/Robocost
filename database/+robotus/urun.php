<?php 

	header("Content-type: text/html; charset=utf-8");


	function menu() {
		include_once "menu.php";
		$menuler = menuler();
		return $menuler;
	}


	function urunler(){

		include_once "menu.php";

		$menuler = menuler();

		foreach ($menuler as $key => $value) {

			$curl = new Curl();
			$page = $curl->get($value["link"]);


			// Alt Kategori Kontrolu
			$alt_kategori = @explode("<ul class='children'>", $page);
			$alt_menu = @explode("</ul>", $alt_kategori[1]);

			if (@$alt_kategori[1]) { // Alt kategorisi varsa
				
				$son = false;
				$a = 1;
				
				while ($son == false) {

					$menu2 = @explode("<li class=\"cat-item", $alt_menu[0]);

					$menu = @explode("<a href=\"", $menu2[$a]);

					if (!@$menu[1]) {
						$son = true;
					}else {

						$link = @explode("\"", $menu[1]);
						$link = $link[0];

						$isim = @explode(">", $menu[1]);
						$isim = @explode("<", $isim[1]);
						$isim = $isim[0];

						$alt_menuler[] = ["link" => $link];

					}

					$a++;
				}

			}else { // Her türlü link ekleniyor.
				
				$alt_menuler[] = ["link" => $value["link"]];

			}
		}

		// SAYFALARI ARRAY HALİNE GETİRME


		// KARIŞIK / Eğer çok sayfalı menu varsa sayfa linklerini normal linklere ekleme

		foreach ($alt_menuler as $key => $value) {
			
			$curl = new Curl();
			$page = $curl->get($value["link"]);

			$sayfalar = @explode("<a class='page-numbers'", $page);

			if (@$sayfalar[1]) { // Eğer sayfa numaraları gösteriliyorsa (Örn: 1)

				$sayfalar_yeni[] = ["link" => $value["link"]]; // 1. sayfayıda ekle

				$son2 = false;
				$a = 1;

				while ($son2 == false) {
					
					@$sayfalar2 = @explode(">", $sayfalar[$a]);

					$son = false;
					$b = 0;

					while ($son == false) {
						
						if (!@$sayfalar2[$b]) {
							$son = true;
						}else{
							$link = @explode(">", $sayfalar2[$b]);
							$link = @explode("'", $link[0]);
							
							if (@$link[1]) { // Gelen şey linke benziyorsa

								$link2 = @explode("/", $link[1]);

								if (count($link2) > 4 ) { // Anasayfa linki gelmesin
									
									$sayfalar_yeni[] = ["link" => $link[1]];
								
								}
							}

						}

						$b++;
					}

					if (!@$sayfalar[$a]) {
						$son2 = true;
					}
					
					$a++;

				}

			} else { // Normal sayfalarıda ekle

				$sayfalar_yeni[] = ["link" => $value["link"]];

			}

		}


		// Tüm sayfaların linkleri toplandı. Tek tek ürünler ayrıştırılacak.

		foreach ($sayfalar_yeni as $key => $value) {
			
			$curl = new Curl();
			$page = $curl -> get($value["link"]);

			$urunler[] = urun($page);

		}

		return $urunler;

	}


	function urun($page) {

		$log = false;

		$urun = @explode("<li class=\"post", $page);

		$son = false;
		$a = 1;

		while ($son == false) {

			if (!@$urun[$a]) {
				$son = true;

			}else {

				$urun2 = @explode("</li>", $urun[$a]);

				$isim = @explode("<h3>", $urun2[0]);
				$isim = @explode("</h3>", $isim[1]);
				$isim = $isim[0];
				$isim = stripcslashes($isim);
				$isim = addslashes($isim);

				$link = @explode("<a href=\"", $urun2[0]);
				$link = @explode("\"", $link[1]);
				$link = $link[0];

				$fiyat = @explode("amount\">", $urun2[0]);
				$fiyat2 = @explode("&", $fiyat[2]);


				if (@$fiyat2[0]) { // İndirimli fiyat varsa

					$degil = @explode("<input", $fiyat2[0]);

					if (@$degil[1]) {
						$fiyat = @explode("&", $fiyat[1]);
						$fiyat = $fiyat[0];
					}else {
						$fiyat = $fiyat2[0];
					}
						
				} else {

					$fiyat = @explode("&", $fiyat[1]);
					$fiyat = $fiyat[0];

				}

				if ($isim == "Neden Robotus?") {
					$son = true;

				}else {

					if ($fiyat) {

						// KDV Ekleme

						$fiyat = $fiyat / 100 * 18;

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
				}
			}

			$a++;
		}

		return $urunler;
	}

?>