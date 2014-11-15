<?php

	mysql_connect("localhost","root","");
	mysql_select_db("robocost_urunler");
	mysql_query("SET NAMES UTF8");

	header("Content-type: text/html; charset=utf-8");

	@session_start();
	ob_start();

	function getTitle(){
		return "Robocost";
	}
	
?>