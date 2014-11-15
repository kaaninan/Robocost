<?php
 
session_start();
 
ob_start();
 
session_destroy();
 
echo "Cikis yaptiniz. Anasayfaya yonlendiriliyorsunuz.";
 
header("Refresh: 1; url=index.php");

?>