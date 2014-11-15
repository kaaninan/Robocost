<!-- Takip Ettiklerim -->
<div class="center box">

	<table>
		<tr>
			<th>Firma</th>
			<th>İsim</th>
			<th>Fiyat</th>
		</tr>

		<?php

		mysql_select_db("robocost_kullanici");

		$calistir = mysql_query("SELECT * FROM  `robocost_kullanici`.`takip`") or die(mysql_error());
		while ($row = mysql_fetch_assoc($calistir)) {
			
			$calistir2 = mysql_query("SELECT * FROM  `robocost_urunler`.`".$row["urun_firma"]."` WHERE  `id` = '".$row["urun_id"]."' ") or die(mysql_error());
			while ($row2 = mysql_fetch_array($calistir2)) {
				
			?>
				<tr>
					<td><?php echo $row2["firma"]; ?></td>
					<td><?php echo $row2["isim"]; ?></td>
					<td><?php 
						$calistir3 = mysql_query("SELECT * FROM  `robocost_urunler`.`".$row["urun_firma"]."_Fiyat` WHERE  `isim` = '".$row2["isim"]."' ") or die(mysql_error());
						while ($row3 = mysql_fetch_array($calistir3)) {
							echo $row3["fiyat"];
						}
					?></td>
				</tr>
			<?php

			}						
		}

		?>

	</table>

</div>