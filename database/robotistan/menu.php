<?php 

	header("Content-type: text/html; charset=utf-8");


	function menuler() {

		$log = false;

		$menuler = array();
		
		include_once "../curl.php";
		$curl = new Curl();
		$url = "http://www.robotistan.com";
		$page = $curl->get($url);


		$son = false;
		$b = 1;

		while ($son == false) {

			$link = @explode("</ul><ul><li  id=\"node", $page);
			$link = @explode("=\"", $link[$b]);
		// Key -> 0

			$isim = @explode("\"", $link[1]);
		// Key -> 0

			$tag = @explode("_", $link[2]);
			$tag = @explode(".", $tag[1]);
		// Key -> 0

			if ($isim[0] == "") {
				$son = true;

			}else {

				$isim = $isim[0];
				$tag = $tag[0];

				$menuler[] = ["isim" => $isim, "tag" => $tag];

				$b++;

			}
		}

		return $menuler;

	}

?>