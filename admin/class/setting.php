<?php
	//Start Session and Cookie.
	session_start();
	ob_start();
	
	//CONNECTION DATABASE CONFIG.
	include'config.php';
	
	
	//COUNT TIME ON LOAD PAGE
	$mtime = microtime();
	$mtime = explode(" ",$mtime);
	$mtime = $mtime[1] + $mtime[0];
	$starttime = $mtime;
	
	//COUNT QUERY STATEMENT
	$res = mysql_query("SHOW SESSION STATUS LIKE 'Questions'");
	$igen = mysql_fetch_array($res, MYSQL_ASSOC);
	define("START_QUERIES",$igen['Value']);
	
	// ALL CLASS ////////////////////////////
	include'class.mydev.php';
	include'class.youtube.php';
	include'class.video.php';
	include'class.category.php';
	include'class.article.php';
	include'class.photo.php';
	include'class.fb.php';
	include'class.setting.php';
	//include'class.admin.php';
	
	//CREATE OBJECT
	//$admin = new Admin;
	$article = new Article;
	$category = new Category;
	$youtube = new Youtube;
	$video = new Video;
	$photo = new Photo;
	$mydev = new MyDev;
	$setting = new Setting;
?>