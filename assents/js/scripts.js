// KULLANICI YORUMLARI

<script type="text/javascript">
$(function(){
	$("a.kullanici_yorumlari").click(function(){

		event.preventDefault();

		var id = $(this).attr("id");

		// Kaydırma
		if (id == 0) {
			kaydir = "5px";
		};
		if (id == 1) {
			kaydir = "135px";
		};
		if (id == 2) {
			kaydir = "265px";
		};
		if (id == 3) {
			kaydir = "395px";
		};
		if (id == 4) {
			kaydir = "525px";
		};
		if (id == 5) {
			kaydir = "655px";
		};
		if (id == 6) {
			kaydir = "785px";
		};
		if (id == 7) {
			kaydir = "915px";
		};
		if (id == 8) {
			kaydir = "1045px";
		};

		$("div#k_y").animate({ "left": kaydir }, "slow" );

	});
});
</script>



// TAKİP ET

<script type="text/javascript">
$(function(){
	$("a.takip_et").click(function(){

		event.preventDefault();

		var id = $(this).attr("id");
		var data = "id="+id;

		$.ajax({
	        type: "POST",
	        url: "takip.php",
	        data: data,
	        success: function(donenVeri){
	        	alert(donenVeri);
			}
		});

	});
});
</script>




// KULLANICI GİRŞİ

<script type="text/javascript">
$(function(){

	$("form#login").submit(function(){
		event.preventDefault();
		var data = $("form#login").serialize();

		$.ajax({
	        type: "POST",
	        url: "../login.php",
	        data: data,
	        success: function(donenVeri){
	        	if (donenVeri == 1) {
	        		window.location = "/index.php";
	        	};
			},
			error: function(donenVeri2){
				alert("hata");
			}
		});
	});
});
</script>



// İLETİŞİM FORMU

<script type="text/javascript">
$(function(){

	$("form#iletisim").submit(function(){
		event.preventDefault();
		var data = $("form#iletisim").serialize();

		$(".load").animate({ "display": "block" }, "slow" );

		$.ajax({
	        type: "POST",
	        url: "../iletisim/iletisim-form.php",
	        data: data,
	        success: function(donenVeri){
	        	if (donenVeri == 1) {
	        		window.location = "/index.php";
	        	};
			},
			error: function(donenVeri2){
				alert("hata");
			}
		});
	});
});
</script>




// PROFİL SEÇENEKLERİ

<script type="text/javascript">
$(function (){
	c = 1;
	hiz = 300;
	$(".cursor").click(function (){
		if (c == 1) {
			$("div#secenek").slideDown(hiz);
			c++;
		}else{
			$("div#secenek").slideUp(hiz);
			c--;
		}
	});
});
</script>




// UYE DİV

<script type="text/javascript">
$(function(){
	a = false;
	b = false;
	hiz = 300;

	$("a#uye_girisi").click(function(){
		if (a == false) {
			$("div#kayit").slideUp(hiz).
			b = false;
			$("div#uye").slideDown(hiz);
			a = true;
		}else{
			$("div#uye").slideUp(hiz);
			a = false;
		}
	});

	$("a#uye_kayit").click(function(){
		if (b == false) {
			$("div#uye").slideUp(hiz);
			a = false;
			$("div#kayit").slideDown(hiz);
			b = true;
		}else{
			$("div#kayit").slideUp(hiz);
			b = false;
		}
	});
});
</script>


	


// SON ARANANLAR

<script type="text/javascript">
$(function(){
	$("a#yenile").click(function(){
		$("div#son_aramalar").load("son_aramalar.php");
	});
});
</script>
