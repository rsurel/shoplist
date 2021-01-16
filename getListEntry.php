<?php
	include('conndb.php');
	error_reporting(0);
	$error=''; // Variable To Store Error Message
	// Define $username and $password
	$username=$_POST['username'];
	$password=$_POST['password'];
	$listid=$_POST['listid'];
	
	// To protect MySQL injection for Security purpose
	$username = stripslashes($username);
	$password = stripslashes($password);
	$listid = stripslashes($listid);
	
	$username = mysql_real_escape_string($username);
	$password = mysql_real_escape_string($password);
	$listid = mysql_real_escape_string($listid);
	
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
			
			//shoplist verilerini alma
			$query3 = mysql_query("select * from tbl_shoplist where shoplist_id='$listlink_shoplist_id'", $connection);
			$rows_shop = mysql_num_rows($query3);
			
			if($rows_shop == 1) {
				
				$oku3 = mysql_fetch_assoc($query3);
				$shoplist_id = $oku3["shoplist_id"];
				$shoplist_adi = $oku3["shoplist_adi"];
				$shoplist_ilk_tarih = $oku3["shoplist_ilk_tarih"];
				$shoplist_yaratici = $oku3["shoplist_yaratici"];
				$shoplist_deg_tarih = $oku3["shoplist_deg_tarih"];
				
				$csv_output = "<data>";
				
				$csv_output .= $shoplist_id.",".$shoplist_adi."\n";
			}
			
			//shoplist entrilerini alma
			$query_shoplistentry = mysql_query("select * from tbl_listentry where listentry_shoplistid='$shoplist_id' AND listentry_durum>0", $connection);
			$rows_shoplistentry = mysql_num_rows($query_shoplistentry);
			
			if($rows_shoplistentry > 0) {
				
				$oku3 = mysql_fetch_assoc($query_shoplistentry);
				$listentry_id = $oku3["listentry_id"];
				$listentry_shoplistid = $oku3["listentry_shoplistid"];
				$listentry_tarih = $oku3["listentry_tarih"];
				$listentry_yaratici = $oku3["listentry_yaratici"];
				$listentry_tanim = $oku3["listentry_tanim"];
				$listentry_aciklama = $oku3["listentry_aciklama"];
				$listentry_durum = $oku3["listentry_durum"];
				
				$query_yaratici = mysql_query("select * from tbl_user where user_id='$listentry_yaratici'", $connection);
				$rows_yaratici = mysql_num_rows($query_yaratici);
				
				if($rows_yaratici == 1) {
					$oku4 = mysql_fetch_assoc($query_yaratici);
					$yaratici_adi = $oku4["user_kul_adi"];
				}
					
				if($listentry_durum == 1) {
					$csv_output .= $listentry_id.",(OK) ".$listentry_tanim.",".$listentry_aciklama.",".$yaratici_adi.",".$listentry_tarih.",".$listentry_durum;
				}
				else {
					$csv_output .= $listentry_id.",".$listentry_tanim.",".$listentry_aciklama.",".$yaratici_adi.",".$listentry_tarih.",".$listentry_durum;
				}
					
				while($oku3 = mysql_fetch_assoc($query_shoplistentry)) {
					
					$listentry_id = $oku3["listentry_id"];
					$listentry_shoplistid = $oku3["listentry_shoplistid"];
					$listentry_tarih = $oku3["listentry_tarih"];
					$listentry_yaratici = $oku3["listentry_yaratici"];
					$listentry_tanim = $oku3["listentry_tanim"];
					$listentry_aciklama = $oku3["listentry_aciklama"];
					$listentry_durum = $oku3["listentry_durum"];
					
					if($listentry_durum == 1) {
						$csv_output .= "\n".$listentry_id.",(OK) ".$listentry_tanim.",".$listentry_aciklama.",".$yaratici_adi.",".$listentry_tarih.",".$listentry_durum;
					}
					else {
						$csv_output .= "\n".$listentry_id.",".$listentry_tanim.",".$listentry_aciklama.",".$yaratici_adi.",".$listentry_tarih.",".$listentry_durum;
					}
				}
			}
			
			$csv_output .= "<data>";
			print $csv_output;
		}
		
		else {
			echo "error: link yok";
		}
		
	} 
	
	
	else {
		$error = "ERR102: Username or Password is invalid";
		echo "error: login";
	}
	mysql_close($connection); // Closing Connection
?>