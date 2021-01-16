<?php
	include('conndb.php');
	
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
	
	$error=''; // Variable To Store Error Message
	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];
	$list_id=$_POST['list_id'];
	
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
	$list_id = stripslashes($list_id);
	
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	$list_id = mysql_real_escape_string($list_id);
	
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
		
		$query_shoplist = mysql_query("SELECT * FROM tbl_shoplist WHERE shoplist_id='$list_id' AND shoplist_yaratici='$user_id'", $connection);
		$rows_shoplist = mysql_num_rows($query_shoplist);
		
		if ($rows_shoplist == 1) {
			
			$query_delete_shoplist = mysql_query("DELETE FROM tbl_shoplist WHERE shoplist_id='$list_id'", $connection);
			$query_delete_listlink = mysql_query("DELETE FROM tbl_listlink WHERE listlink_shoplist_id='$list_id'", $connection);
			$query_delete_listentry = mysql_query("DELETE FROM tbl_listentry WHERE listentry_shoplistid='$list_id'", $connection);
		}
		
		else {
			echo "listenin yaraticisi degilsin!";
		}
		
	} 
	else {
		$error = "ERR102: Username or Password is invalid";
		echo "error";
	}
	mysql_close($connection); // Closing Connection
	
	exit;
?>