<?php
	include('conndb.php');
	
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
	$db = mysql_select_db("shoplist", $connection);
	
	// SQL query to fetch information of registerd users and finds user match.
	$query = mysql_query("select * from tbl_user where user_sifre='$password' AND user_kul_adi='$username'", $connection);
	$rows = mysql_num_rows($query);
	if ($rows == 1) {
		$oku = mysql_fetch_assoc($query);
		$user_id = $oku["user_id"];
		$user_kul_adi = $oku["user_kul_adi"];
		$user_adi = $oku["user_adi"];
		$csv_output = "<data>".$user_id.",".$user_kul_adi.",".$user_adi."<data>";
		
		print $csv_output;
	} 
	else {
		$error = "ERR102: Username or Password is invalid";
		echo "error";
	}
	mysql_close($connection); // Closing Connection
?>