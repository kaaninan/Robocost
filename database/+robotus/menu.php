<?php

	header("Content-type: text/html; charset=utf-8");

	function menuler(){

		$log = false;

		$url = "http://robotus.net";
		
		include_once "../curl.php";
		$curl = new Curl();
		$page = $curl->get($url);

		$menu = explode("<li class=\"cat-item", $page);

		$son = false;
		$a = 1;

		while ($son == false) {

			$menu2 = @explode("<a href=\"", $menu[$a]);


			if (!@$menu2[1]) {
				$son = true;
			}else {

				$link = explode("\"", $menu2[1]);
				$link = $link[0];

				$isim = explode(">", $menu2[1]);
				$isim = explode("<", $isim[1]);
				$isim = $isim[0];

				$menuler[] = ["isim" => $isim, "link" => $link];

				if ($log == true) {
					echo $isim;
					echo "<br>";
					echo $link;
					echo "<br><br>";
				}	

			}	

			$a++;
		}

		return $menuler;
	}

?>