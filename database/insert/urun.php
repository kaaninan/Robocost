<?php
	
	include '../../functions.php';
                                                                                                              

	function urunEkle ($firma, $yeni_urunler2, $menuler) {

		print_r($yeni_urunler2);

		// LOG İÇİN
		$degisen_urun = 0;
		$eklenen_urun = 0;
		$silinen_urun = 0;

		$degisen_urunler = array();
		$eklenen_urunler = array();
		$silinen_urunler = array();

		$gelen_ayni_urun = 0;
		
		$log = "";
		$firma_var = false;
      
      

		$tarih2 = getdate();
		$tarih = $tarih2['year']."-".$tarih2['mon']."-".$tarih2['mday'];


		// VERİTABANINDAKİ TABLOLARI EŞLEŞTİRME
		$tablo = mysql_query("SHOW TABLES") or die(mysql_error());
		$sonuc = false;
	    while ($row = mysql_fetch_row($tablo)) {  
	        if ($firma == $row[0]) {
	        	$firma_var = true;
	        }
	    }


	    // KAYITLI FİRMA
	    if ($firma_var == true) {

	    	echo "Firma Var \n";

	    	// GEÇİCİ TABLO
	    	$sql = "CREATE TEMPORARY TABLE `".$firma."_1` (
	    		`id` int AUTO_INCREMENT, 
	    		`firma` varchar(100),
	    		`isim` text,
	    		`link` text,
	    		`fiyat` decimal(10,2),
	    		`tarih` date,
	    		PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;";
			mysql_query($sql) or die(mysql_error());

			foreach ($yeni_urunler2 as $key => $value) {
	    		$sql = mysql_query("INSERT INTO `".$firma."_1` (`firma`, `isim`, `link`, `fiyat`, `tarih`) VALUES ('".$firma."',  '".$value["isim"]."', '".$value["link"]."', '".$value["fiyat"]."', '".$tarih."')") or die(mysql_error());
	    	}



	    	// KAYITLARI ARRAY YAPMA
	    	$sorgula = mysql_query("SELECT * FROM `".$firma."_1`") or die(mysql_error());
			while($row = mysql_fetch_array($sorgula)){
	    		$yeni_urunler[] = ["id" => $row["id"], "isim" => $row["isim"], "link" => $row["link"], "tarih" => $row["tarih"]];
			}

	    	$sorgula = mysql_query("SELECT * FROM `".$firma."`") or die (hata("Firmanın tablosu seçilemedi.", null, "select"));
			while($row = mysql_fetch_array($sorgula)){
	    		$eski_urunler[] = ["id" => $row["id"], "isim" => $row["isim"], "link" => $row["link"], "tarih" => $row["tarih"]];
			}



			#### KARŞILAŞTIRMA ####

			// ESKİ -> YENİ (ARTIK SATILMAYAN ÜRÜNLER)
			foreach ($eski_urunler as $key => $value_eski) {
				$eski_isim = $value_eski["isim"];
				$eski_isim = stripcslashes($eski_isim);
				$eski_isim = addslashes($eski_isim);

				$var = false;

				foreach ($yeni_urunler as $key => $value_yeni) {
					$yeni_isim = $value_yeni["isim"];
					$yeni_isim = stripcslashes($yeni_isim);
					$yeni_isim = addslashes($yeni_isim);

					if ($eski_isim == $yeni_isim) {
						$var = true;
						break;
					}
				}

				if ($var == false) {
					// Stok durumu düzeltme
					$sql = mysql_query("UPDATE `robocost_urunler`.`".$firma."` SET `stok` = 0 WHERE `id` = ".$value_eski["id"]) or die(mysql_error());

					$silinen_urun++;
					$silinen_urunler[] = $value_eski;
				}
			}


			
			// YENİ -> ESKİ (SATIŞA BAŞLANAN ÜRÜNLER ve DEĞİŞEN ÜRÜNLER)
			foreach ($yeni_urunler as $key => $value_yeni) {
				$yeni_isim = $value_yeni["isim"];
				$yeni_isim = stripcslashes($yeni_isim);
				$yeni_isim = addslashes($yeni_isim);				

				$var = false;

				foreach ($eski_urunler as $key => $value_eski) {

					$eski_isim = $value_eski["isim"];
					$eski_isim = stripcslashes($eski_isim);
					$eski_isim = addslashes($eski_isim);

					// Eşleşirse
					if ($yeni_isim == $eski_isim) {
						$var = true;
						break;
					}

				}

				// ÖNCEDEN SATILMIYORSA
				if ($var == false) {

					$sql = mysql_query("INSERT INTO `".$firma."` (`firma`, `isim`, `link`, `tarih`, `stok`) VALUES ('".$firma."',  '".$yeni_isim."', '".$value_yeni["link"]."', '".$tarih."', 1)") or die(mysql_error());
					$sql = mysql_query("INSERT INTO `".$firma."_Fiyat` (`firma`, `isim`, `fiyat`, `tarih`) VALUES ('".$firma."',  '".$yeni_isim."', '".$value_yeni["fiyat"]."', '".$tarih."')") or die(mysql_error());

					$eklenen_urunler[] = $value_yeni;
					$eklenen_urun++;

				// SATIŞINA DEVAM EDİLİYORSA
				}else{

					// FİYAT TABLOSU GÜNCELLEME
					if ($tarih != $value_eski["tarih"]) {
						$sql = mysql_query("UPDATE `robocost_urunler`.`".$firma."` SET `tarih` = '".$tarih."' WHERE `id` = ".$value_eski["id"]) or die(mysql_error());
						$sql = mysql_query("INSERT INTO `".$firma."_Fiyat` (`firma`, `isim`, `fiyat`, `tarih`) VALUES ('".$firma."',  '".$yeni_isim."', '".$value_yeni["fiyat"]."', '".$tarih."')") or die(mysql_error());
						
						$degisen_urun++;
						$degisen_urunler[] = $value_yeni;
					}

				}

			}

			$sql = "DROP TEMPORARY TABLE `".$firma."_1`";
			mysql_query($sql) or die (mysql_error());

	    }


	    // FİRMA KAYITLI DEĞİLSE
	    else {

	    	echo "Firma Yok \n";

	    	$sql = "CREATE TABLE `".$firma."` (
	    		`id` int AUTO_INCREMENT, 
	    		`firma` text,
	    		`isim` text,
	    		`link` text,
	    		`stok` int,
	    		`tarih` date,
	    		PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;";

			mysql_query($sql) or die(mysql_error());


			$sql = "CREATE TABLE `".$firma."_Fiyat` (
	    		`id` int AUTO_INCREMENT, 
	    		`firma` text,
	    		`isim` text,
	    		`fiyat` decimal(10,2),
	    		`tarih` date,
	    		PRIMARY KEY (`id`)
			) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_turkish_ci;";

			mysql_query($sql) or die(mysql_error());


	    	foreach ($yeni_urunler2 as $key => $value) {
	    		$sql = mysql_query("INSERT INTO `robocost_urunler`.`".$firma."` (`firma`, `isim`, `link`, `tarih`, `stok`) VALUES ('".$firma."',  '".$value["isim"]."', '".$value["link"]."', '".$tarih."', 1)") or die(mysql_error());
	    		$sql = mysql_query("INSERT INTO `robocost_urunler`.`".$firma."_Fiyat` (`firma`, `isim`, `fiyat`, `tarih`) VALUES ('".$firma."', '".$value["isim"]."', '".$value["fiyat"]."', '".$tarih."')") or die(mysql_error());
	    	
	    		$eklenen_urun++;
	    		$eklenen_urunler[] = $value;
	    	}
	    	
	    }




		// LOG
		$log_mail .= "<h1>".$firma."</h1>";
		$log_mail .= "<h2>Veritabanı Durumu: ";
		
		if ($firma_var == true) {
			$log_mail .= "Kayıtlı<br><br></h2>";
		}else{
			$log_mail .= "İlk Tarama<br><br></h2>";
		}

		$log_mail .= "<h2>Menüler</h2><ul style='margin:0;padding:0;'>";

		foreach ($menuler as $key => $value) {
			$log_mail .= "<li><a href='".$value["link"]."'>".$value["isim"]."</a></li><br>";
		}

		$log_mail .= "</ul><h2>Toplam Ürün Sayısı: ".count($yeni_urunler2);
		$log_mail .= "</h2><br>---<br>";

		$log_mail .= "<h3>Eklenen Ürünler: ".$eklenen_urun."<br></h3>";
		if ($eklenen_urun > 0) {
			foreach ($eklenen_urunler as $key => $value) {
				$log_mail .= $value["isim"]."<br><br>";
			};
		};

		$log_mail .= "<h3>Stoğu Biten Ürünler: ".$silinen_urun."<br></h3>";
		if ($silinen_urun > 0) {
			foreach ($silinen_urunler as $key => $value) {
				$log_mail .= $value["isim"]."<br>";
			}
		}

		$log_mail .= "<h3>Değişen Ürünler: ".$degisen_urun."<br></h3>";
		if ($degisen_urun > 0) {
			foreach ($degisen_urunler as $key => $value) {
				$log_mail .= $value["isim"]."<br>";
			}
		}



		include 'class.phpmailer.php';
		$mail = new PHPMailer();
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = 'smtp.gmail.com';
		$mail->Port = 465;
		$mail->Username = 'kaaninan@robocost.com';
		$mail->Password = 'kaan2mail';
		$mail->SetFrom($mail->Username, 'Robocost');
		$mail->AddAddress('kaaninan@outlook.com', 'Kağan İnan');
		$mail->AddAddress('meliozkurt@gmail.com', 'Melih Özkurt');
		$mail->CharSet = 'UTF-8';
		$mail->Subject = 'Robocost | Günlük Tarama Sonucu';
		$mail->MsgHTML($log_mail);
		if($mail->Send()) {
			echo "Mail gönderildi! \n";
		} else {
			echo 'Mail gönderilirken bir hata oluştu: ' . $mail->ErrorInfo;
		}

	}


?>