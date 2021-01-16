<?php
	include('conndb.php');
	
	$error=''; // Variable To Store Error Message
	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];
	$listid=$_POST['listid'];
	$tanim=$_POST['tanim'];
	$aciklama=$_POST['aciklama'];
	
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
	$listid = stripslashes($listid);
	$tanim = stripslashes($tanim);
	$aciklama = stripslashes($aciklama);
	
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	$listid = mysql_real_escape_string($listid);
	$tanim = mysql_real_escape_string($tanim);
	$aciklama = mysql_real_escape_string($aciklama);
	
	// Selecting Database
	$db = mysql_select_db("db_shoplist", $connection);
	
	// kullanıcı doğrulama
	$query = mysql_query("select * from tbl_user where user_sifre='$password' AND user_kul_adi='$username'", $connection);
	$rows = mysql_num_rows($query);
	
	if ($rows == 1) {
		
		$oku = mysql_fetch_assoc($query);
		$user_id = $oku["user_id"];
		$user_kul_adi = $oku["user_kul_adi"];
		$user_adi = $oku["user_adi"];
		
		//list link doğrulama
		$query2 = mysql_query("select * from tbl_listlink where listlink_user_id='$user_id' AND listlink_shoplist_id='$listid'", $connection);
		$rows_link = mysql_num_rows($query2);
		
		if($rows_link == 1) {
			
			$oku2 = mysql_fetch_assoc($query2);
			$listlink_id = $oku2["listlink_id"];
			$listlink_shoplist_id = $oku2["listlink_shoplist_id"];
			$listlink_user_id = $oku2["listlink_user_id"];
			$listlink_tarih = $oku2["listlink_tarih"];
			
			//list entry güncelleme
			$sorgu_add = mysql_query("insert into tbl_listentry(listentry_shoplistid, listentry_yaratici, listentry_tanim, listentry_aciklama) values ('".$listid."','".$user_id."','".$tanim."','".$aciklama."')", $connection);
			echo "OK!";
			
		}
		else {
			echo "error: list link hatasi";
		}
		
	} 
	else {
		$error = "ERR102: Username or Password is invalid";
		//echo "error: login";
	}
	mysql_close($connection); // Closing Connection
?>