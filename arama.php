<!-- Arama -->
<div class="center" id="search">
	
	<!-- Search -->
	<div class="search">	
		<form id="search" action"index.php" type="GET">
			<div class="detay"><img src="/assents/images/submenu.png"></div>
			<input type="text" class="input_search" id="search" name="search" placeholder="Ne aradınız?" value="<?php if(isset($_GET["search"])){ echo $_GET["search"]; } ?>">
			<input type="submit" class="submit" value="" />
		</form>
	</div>

	<div class="clear"></div>

	<!-- Arama Sonuçları -->
	<?php if(isset($_GET["search"])){ ?>

		<div class="liste">

			<table>

				<tr class="baslik">
                    <th class="firma">Firma</div></th>
                    <th class="isim">İsim</div></th>
                    <th class="fiyat">Fiyat</div></th>
                </tr>
            
			<div class="clear"></div>
				
			<?php require "search.php"; ?>

			</table>
			
		</div>

		<?php }else { ?>

		<?php } ?>
</div>