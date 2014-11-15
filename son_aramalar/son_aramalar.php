<div class="center box" id="son_aramalar">
	
	<table>
		<?php

			mysql_select_db("robocost_kullanici");
			
			$calistir4 = mysql_query("SELECT * FROM `robocost_kullanici`.`arama` ORDER BY `arama`.`tarih` DESC LIMIT 20") or die (mysql_error());

			while ($row = mysql_fetch_array($calistir4)) { ?>

				<tr>
					<td><?php
					if ($row["show"] == 1) {
						echo $row["search"];
					}
					?></td>
				</tr>
			
			<?php } ?>
	</table>

</div>