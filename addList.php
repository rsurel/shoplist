<?php
	include('conndb.php');
	
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
	
	$error=''; // Variable To Store Error Message
	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];
	$listname=$_POST['listname'];
	
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
	$listname = stripslashes($listname);
	
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	$listname = mysql_real_escape_string($listname);
	
	// Selecting Database
	$db = mysql_select_db("db_shoplist", $connection);
	
	// SQL query to fetch information of registerd users and finds user match.
	$query = mysql_query("SELECT * FROM tbl_user WHERE user_sifre='$password' AND user_kul_adi='$username'", $connection);
	$rows = mysql_num_rows($query);
	
	if ($rows == 1) {
		
		$oku = mysql_fetch_assoc($query);
		$user_id = $oku["user_id"];
		$user_kul_adi = $oku["user_kul_adi"];
		$user_adi = $oku["user_adi"];
		
		$sorgu_add_list = mysql_query("INSERT INTO tbl_shoplist (shoplist_adi, shoplist_yaratici) VALUES ('".$listname."','".$user_id."')", $connection);
		$shoplist_id = mysql_insert_id();
		
		$sorgu_add_listlink = mysql_query("INSERT INTO tbl_listlink (listlink_shoplist_id, listlink_user_id) VALUES ('".$shoplist_id."','".$user_id."')", $connection);
		
	} 
	else {
		$error = "ERR102: Username or Password is invalid";
		echo "error";
	}
	mysql_close($connection); // Closing Connection
	
	exit;
?>