<?php
	include('conndb.php');
	
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
	
	$error=''; // Variable To Store Error Message
	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];
	$list_id=$_POST['list_id'];
	$user2_name=$_POST['user2_name'];
	
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
	$list_id = stripslashes($list_id);
	$user2_name = stripcslashes($user2_name);
	
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	$list_id = mysql_real_escape_string($list_id);
	$user2_name = mysql_real_escape_string($user2_name);
	
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
			
			$ok_shoplist = mysql_fetch_assoc($query_shoplist);
			$shoplist_adi = $oku_shoplist["shoplist_adi"];
			
			$query_user2 = mysql_query("SELECT * FROM tbl_user WHERE user_kul_adi='$user2_name'", $connection);
			$rows_user2 = mysql_num_rows($query_user2);
			
			if ($rows_user2 == 1) {
				
				$oku_user2 = mysql_fetch_assoc($query_user2);
				$user2_id = $oku_user2["user_id"];
				$user2_kul_adi = $oku_user2["user_kul_adi"];
				$user2_adi = $oku_user2["user_adi"];
				
				$sorgu_add_list = mysql_query("INSERT INTO tbl_listlink (listlink_shoplist_id, listlink_user_id) VALUES ('".$list_id."','".$user2_id."')", $connection);
				
			}
			else {
				echo "user2_name yok!";
			}
			
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