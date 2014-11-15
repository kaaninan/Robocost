<?php
	
	include "functions.php";

	session_start();
	ob_start();

	$user = $_POST['user'];
	$pass = $_POST['pass'];


	$calistir = mysql_query("SELECT * FROM  `robocost_kullanici`.`users` WHERE  `email` = '$user' ");
	if ( mysql_num_rows($calistir) == 1 ) { 

		while($oku=mysql_fetch_array($calistir)){
			$pw = $oku["password"];
			$isim = $oku["isim"];
			$id = $oku["id"];
		}

		if($pass != $pw){
			$sql2 = "INSERT INTO `robocost_kullanici`.`log` (`user`, `log`, `date`) VALUES ('$user', 'basarisiz_giris', NOW())";
			if(!mysql_query($sql2)){
				echo "basarisiz_yazma";
			}else{
				echo 0;
			}

		}else{
			$sql3 = "INSERT INTO `robocost_kullanici`.`log` (`user`, `log`, `date`) VALUES ('$user', 'basarili_giris', NOW())";
			if(!mysql_query($sql3)){
				echo "basarisiz_yazma";
			}else{
				echo 1;
			}

			$_SESSION["login"] = "true";
			$_SESSION["isim"] = $isim;
			$_SESSION["user"] = $user;
			$_SESSION["pass"] = $pass;
			$_SESSION["id"] = $id;

			ob_end_flush();
		}

	}else{
		echo 0;
		
		$sql = "INSERT INTO `robocost_kullanici`.`log` (`user`, `log`, `date`) VALUES ('$user', 'basarisiz_giris', NOW())";
		if(!mysql_query($sql)){
			echo "basarisiz_yazma";
		}else{
			echo 0;
		}

	}
		


?>