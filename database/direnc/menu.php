<?php 

	header("Content-type: text/html; charset=utf-8");


	function menuler() {

		$url = "http://www.direnc.net";
		include_once "../curl.php";
		$curl = new Curl();
		$page = $curl->get($url);


		// MENU

		$menu = explode("<div class='MenuItem' ", $page);

		$toplam_menu = 0;

		$a = 1;
		$son = false;

		// Ana kategorileri ayırma
		while ($son == false) {
			
			$ana_menu = @explode("'", $menu[$a]);
			
			if (!@$ana_menu[1]) {
				$son = true;

			}else {
				
				$ana_menu2 = explode("_", $ana_menu[1]);

				// Ana menüyse
				if (strcmp($ana_menu2[1], "sub") == 1 || strcmp($ana_menu2[1], "sub") == 2) {

					if (!@$ana_menu2[2]) {
						
						$isim = @$ana_menu[11];

						$tag = explode("_", $ana_menu[5]);
						$tag = explode(".", $tag[1]);
						$tag = $tag[0];

						$menuler[] = array("isim" => $isim, "tag" => $tag);

						$toplam_menu++;

					}
				}
			}

			$a++;
		}

		return $menuler;

	}

?>