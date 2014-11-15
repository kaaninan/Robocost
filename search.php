<?php

	$ara = $_GET["search"];
	$result = mysql_query("SELECT * FROM `ALL` WHERE `isim` LIKE '%".$ara."%' ORDER BY `fiyat` ") or die (mysql_error());

	$user_id = NULL;

	if(isset($_SESSION["login"])){
		$user_id = $_SESSION["id"];
	}


	if (mysql_num_rows($result) != 0) {
		$sql = mysql_query("INSERT INTO `robocost_kullanici`.`arama` (`search`, `user_id`, `tarih`, `show`) VALUES ('".$ara."', '".$user_id."', NOW(), 1)") or die (mysql_error());
	}else {
		$sql = mysql_query("INSERT INTO `robocost_kullanici`.`arama` (`search`, `user_id`, `tarih`, `show`) VALUES ('".$ara."', '".$user_id."', NOW(), 0)") or die (mysql_error());
	}

	while($row = mysql_fetch_array($result)){
?>

<tr class="urunler">

	<td class="firma"><?php echo $row['firma']; ?></td>

	<td class="isim">
		<a href="<?php echo $row['link']; ?>" target="_blank"><?php echo $row['isim']; ?></a>
	</td>

	<td class="fiyat"><?php echo $row["fiyat"]; ?> TL | <a class="takip_et" id="<?php echo $row["id"]; ?>" href="#">Takip</a></td>

</tr>

<div class="clear"></div>

<?php } ?>