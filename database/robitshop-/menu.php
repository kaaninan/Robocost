<?php

	header("Content-type: text/html; charset=utf-8");

	function menuler() {

		include_once "../curl.php";
		$curl = new Curl();
		$page = $curl->get("http://www.robitshop.com/index.php");
		

		$menu = explode("<li id=\"node", $page);

		$son = false;
		$i = 1;

		while ($son == false) { 
			
			$menu2 = @explode("<a href=\"", $menu[$i]);
			$menu2 = @explode("</a>", $menu2[1]);

			$link = $menu2[0];
			
			if (!$link) {
				$son = true;
			}else {

				$tag = explode(",", $link);
				$tag = explode("_", $tag[1]);
				$tag = explode(".", $tag[1]);
				$tag = $tag[0];

				$isim = explode(">", $link);
				$isim = $isim[1];

				$menuler[] = ["isim" => $isim, "tag" => $tag];

			}

			$i++;

		}

		return $menuler;
	}

?>