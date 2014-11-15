<div class="center box">

<?php
$tablo = mysql_query("SHOW TABLES") or die (mysql_error());

    while ($row = mysql_fetch_row($tablo)) {  
    	$firma = @explode("_", $row[0]);
    	if (!@$firma[1] && $row[0] != "ALL") {
    		$firmalar[] = ["isim" => $firma[0]];
    	}
    }

?>

<div class="firmalar">
	<ul class="firmalar">
		<?php foreach ($firmalar as $key => $value) {
			?>
			<li>
				<a href="#" id="<?php echo $key; ?>" class="kullanici_yorumlari">
				<?php echo $value["isim"]; ?>
				</a>
			</li>
		<?php } ?>
	<div class="line" id="k_y"></div>
	</ul>
</div>


<div class="yorumlar">
	<div id="direnc">
		Son alışverışte sorun çıkardılar
	</div>
</div>

</div>