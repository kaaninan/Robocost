<?php
	
	$dir = "../database/";
	$dh  = opendir($dir);
	while (false !== ($filename = readdir($dh))) {
	    $files[] = $filename;
	}

	sort($files);

	foreach ($files as $key => $value) {
		if ($value != ".DS_Store" && $value != "." && $value != ".." && $value != "curl.php" && $value != "dizin.php" && $value != "insert" && $value != "error_log") {
			$link[] = "http://robocost.com/database/".$value."/";
		}
	}

	include_once "curl.php";
	$curl = new Curl();
	
	foreach ($link as $key => $value) {
		$curl->get($value);
	}

	$curl->get("http://robocost.com/database/insert/sql.php");

?>