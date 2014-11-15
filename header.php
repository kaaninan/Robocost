<!-- Header -->
<div class="header">

	<div class="center">
		
		<div class="logo">
			<a id="anasayfa" href="/index.php">
				<img src="/assents/images/logo.png" class="img">
				<div class="title"><?php echo getTitle(); ?></div>
			</a>
		</div>

		<div class="line"></div>

		<div class="menu">
			<ul id="menu">
				<a id="son-aramalar" href="/son_aramalar"><li>Son Aramalar</li></a>
				<a id="indirimler" href="/indirimler"><li>İndirimler</li></a>
				<a id="kullanici-yorumları" href="/kullanici_yorumlari"><li>Kullanıcı Yorumları</li></a>
				<a id="hakkinda" href="/hakkinda/"><li>Hakkında</li></a>
				<a id="iletisim" href="/iletisim"><li>İletişim</li></a>
			</ul>
		</div>

		<!-- LOGIN -->

		<?php
			
			if(!isset($_SESSION["login"])){ ?>



		<div class="uye-kaydol" id="kayit">
			<form id="kaydol">
				<input type="text" class="input" id="user" name="user" placeholder="İsim">
				<input type="email" class="input" id="email" name="email" placeholder="Email">
				<input type="password" class="input" id="pass" name="pass" placeholder="Şifre">
				<input type="password" class="input" id="pass2" name="pass2" placeholder="Şifre (Tekrar)">
				<input type="submit" class="submit-login" value="Kayıt Ol">
			</form>
		</div>

		<div class="uye">
			<a id="uye_girisi" href="#">Üye Girişi</a>
			<a id="uye_kayit" href="#">Kayıt Ol</a>

			<div class="uye-giris" id="uye">
				<form id="login">
					<input type="text" class="input" id="user" name="user" placeholder="Kullanıcı Adı">
					<input type="password" class="input" id="pass" name="pass" placeholder="Şifre">
					<input type="submit" class="submit-login" value="Giriş Yap">
					
					<div id="uyari">Uyari</div>
				</form>
			</div>
		</div>
		

		<?php }else { ?>


		<div class="profil">
			<div class="cursor">
				<span>Merhaba, </span>
				<span class="user"><?php echo $_SESSION["isim"]; ?></span>
				<div class="bottom"><img src="/assents/images/bottom.png" width="24px"></div>
			</div>

			<div class="secenek" id="secenek">
				<ul id="secenek">
					<a href="/profil/takip_ettiklerim"><li>Takip Ettiklerim</li></a>
					<a href="#"><li class="li">Fiyat Alarmları</li></a>
					<a href="#"><li class="li">Ayarlar</li></a>
					<a href="/logout.php"><li class="li">Çıkış Yap</li></a>
				</ul>
			</div>
		</div>

				<?php } ?>

		<div class="clear"></div>

	</div>
</div>
