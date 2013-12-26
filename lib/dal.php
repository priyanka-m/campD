<?php
// Data access Library
	Class DB {
		static protected $con = NULL;
		static protected $db = NULL;
		public static function connect($host, $username, $password, $db) {
			self::$con = mysqli_connect($host, $username, $password, $db);
			// Check connection
			if (mysqli_connect_errno()) {
    			printf("Connect failed: %s\n", mysqli_connect_error());
    			exit();
			}
			return self::$con;
		}

		public static function createDB($dbname) {
			//Create and select database
			$query = "CREATE DATABASE IF NOT EXISTS `campDiaries`";
			self::$db = DB::query($query);
			$select_db = mysqli_select_db(self::$con, 'campDiaries');

			//create tables
			$query = "CREATE TABLE IF NOT EXISTS `users_test` (
			`userid` TINYINT(3) NOT NULL AUTO_INCREMENT,
			`username` VARCHAR(50) NOT NULL ,
			`password` VARCHAR(12) NOT NULL ,
			`age` TINYINT(2),
			PRIMARY KEY (`userid`)";
			DB::query($query);
		}

		public static function query($LINK, $query) {
			$query_result = mysqli_query($LINK, $query);
			return $query_result;
		}

		public static function fetchResult($result) {
			$row = mysqli_fetch_array($result, MYSQL_ASSOC);
			return $row;
		}
	}
?>