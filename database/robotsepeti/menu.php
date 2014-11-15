<?php

	header("Content-type: text/html; charset=utf-8");


	function menuler() {

		$log = false;

		include_once "../curl.php";
		$curl = new Curl();
		$page = $curl -> get("http://www.robotsepeti.com");

		$menu = explode("<ul id=\"nav-one\" class=\"dropmenu\">", $page);

		$menu = explode("<a href=\"", $menu[1]);

		$son = false;
		$i = 1;

		while ($son == false) {
			
			$menu2 = explode("\">", $menu[$i]);

			$link = $menu2[0];

			$isim = explode("</a>", $menu2[1]);
			$isim = $isim[0];

			$isim2 = @explode("<img", $isim);

			if (@$isim2[1]) {
				
				$son = true;
			}else {

				$linkler = explode("/", $link);

				if (!@$linkler[4]) {
					
					if ($log == true) {
						echo $isim;
						echo "<br>";
						echo $link;
						echo "<br><br>";
					}

					$menuler[] = ["isim" => $isim, "link" => $link]; 

				}

			}

			$i++;
		}

		return $menuler;
	}

?>