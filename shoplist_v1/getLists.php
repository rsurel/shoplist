<?php
	include('conndb.php');
	
	error_reporting(E_ALL ^ E_NOTICE);
	ini_set('error_reporting', E_ALL ^ E_NOTICE);
	
	$error=''; // Variable To Store Error Message
	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];
	
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	
	// Selecting Database
	$db = mysql_select_db("db_shoplist", $connection);
	
	// SQL query to fetch information of registerd users and finds user match.
	$query = mysql_query("select * from tbl_user where user_sifre='$password' AND user_kul_adi='$username'", $connection);
	$rows = mysql_num_rows($query);
	
	if ($rows == 1) {
		
		$oku = mysql_fetch_assoc($query);
		$user_id = $oku["user_id"];
		$user_kul_adi = $oku["user_kul_adi"];
		$user_adi = $oku["user_adi"];
		
		//list link tarama
		$query2 = mysql_query("select * from tbl_listlink where listlink_user_id='$user_id'", $connection);
		$rows_link = mysql_num_rows($query2);
		
		if($rows_link > 0) {
			while($oku2 = mysql_fetch_assoc($query2)) {
				
				$listlink_id = $oku2["listlink_id"];
				$listlink_shoplist_id = $oku2["listlink_shoplist_id"];
				$listlink_user_id = $oku2["listlink_user_id"];
				$listlink_tarih = $oku2["listlink_tarih"];
				
				$query3 = mysql_query("select * from tbl_shoplist where shoplist_id='$listlink_shoplist_id'", $connection);
				$rows_list = mysql_num_rows($query3);
				
				if($rows == 1) {
					
					$oku3 = mysql_fetch_assoc($query3);
					$shoplist_id = $oku3["shoplist_id"];
					$shoplist_adi = $oku3["shoplist_adi"];
					$shoplist_ilk_tarih = $oku3["shoplist_ilk_tarih"];
					$shoplist_yaratici = $oku3["shoplist_yaratici"];
					$shoplist_deg_tarih = $oku3["shoplist_deg_tarih"];
					$shoplist_act_tarih = $oku3["shoplist_act_tarih"];
					
					$now = time();
					$gmt = 2;
					if((time()+($gmt*3600)-strtotime("$shoplist_act_tarih")) < 60) {
						$csv_output .= $shoplist_id.",".$shoplist_adi." (toplanıyor..)\n";
					}
					else {
						$csv_output .= $shoplist_id.",".$shoplist_adi."\n";
					}
				}
			}
			
			print $csv_output;
		}
		
	} 
	else {
		$error = "ERR102: Username or Password is invalid";
		echo "error";
	}
	mysql_close($connection); // Closing Connection
	
	exit;
?>