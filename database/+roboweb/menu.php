<?php 

	header("Content-type: text/html; charset=utf-8");

	function menuler() {

		$log = false;

		$menuler = array();

		include_once "../curl.php";
		$curl = new Curl();
		$page = $curl->get("http://www.roboweb.net");

		$son = false;
		$b = 1;

		// Parse İşlemleri

		while ($son == false) {

			$link = @explode("<div class=\"accordion-row\">", $page);

			// Arttır
			$link = @explode("</a>", $link[$b]);
			$link = @explode("<a href=\"", $link[0]);
			$link = @explode("\"", $link[1]);
			$isim = @explode(">", $link[1]);

			$link = array_filter($link);

			// Bittiğini bulma
			if (!$link) {
				$son = true;
			}

			// Bitmediyse
			else {

				// Link urun.php için
				// İsim bilgilendirme maili için
				$link = @$link[0];
				$isim = @$isim[1];


				// Ana menuleri bulma
				$menu_link = explode("/", $link);
				$sayi = count($menu_link);

				// Eğer kategori ismi ana kategoriyse
				if ($sayi == 4) {
					
					if ($log == true) {				
						echo "Link:  ";
						echo $link;
						echo "<br><br>";
						echo "İsim:  ";
						echo $isim;
						echo "<br><br><br><br>";
					}

					$menuler[] = ["isim" => $isim, "link" => $link];
				}
			}
			$b++;
		}

	return $menuler;

	}

 ?>