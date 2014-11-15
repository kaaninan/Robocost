<?php
	
	header("Content-type: text/html; charset=utf-8");
	

	function urun() {

		$log = false;
		
		include_once "../curl.php";
		$curl = new Curl();
		$page = $curl->get("http://www.hobievi.com/-m-.html?page_type=cat&page=1&clicked=stock&stock=1&cat_id[]=110%2C");

		$page = encodeToUtf8($page);

		$urun = explode("<div class=\"box-padd\">", $page);

		$son = false;
		$a = 1;

		while ($son == false) {

			$urun2 = @explode("<a", $urun[$a]);
			$urun2 = @explode("<span", $urun2[0]);

			if (@$urun2[1]) {

				$isim = explode("\">", $urun[$a]);
				$isim = explode("</a>", $isim[2]);
				$isim = $isim[0];
				$isim = stripcslashes($isim);
				$isim = addslashes($isim);

				$link = explode("<a href=\"", $urun[$a]);
				$link = explode("\"", $link[1]);
				$link = $link[0];

				$fiyat = explode("<span class=\"productSpecialPrice\">", $urun[$a]);
				
				if(!@$fiyat[1]){
					$son = true;

				}else {

					$fiyat = explode("<br>", $fiyat[1]);
					$fiyat = explode("TL", $fiyat[0]);
					$fiyat = str_replace(".", "", $fiyat[0]);
					$fiyat = str_replace(",", ".", $fiyat);
			
					if ($log == true) {
						echo $isim;
						echo "<br>";
						echo $fiyat;
						echo "<br>";
						echo $link;
						echo "<br><br>";
					}

					$urunler[] = ["isim" => $isim, "link" => $link, "fiyat" => $fiyat];

				}				

			}

			$a++;
		}

		return $urunler;
	}

	function encodeToUtf8($string) {
    	return mb_convert_encoding($string, "UTF-8", mb_detect_encoding($string, "ISO-8859-9", true)); 
	}

?>