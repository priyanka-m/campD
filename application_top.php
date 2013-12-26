<?php
include 'lib/dal.php';
	$LINK = DB::connect('localhost', 'root','password','campDiaries');

	define('HOST', 'http://localhost/cd/');
	define('MEMCACHED_HOST', 'localhost');
	define('MEMCACHED_PORT', '11211');
	 
	include 'lib/cache.php';
	include 'lib/user.php';
?>