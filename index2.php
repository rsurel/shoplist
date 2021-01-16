<!DOCTYPE html>
<html>
	<head>
		<title>Login Form in PHP with Session</title>
		<link href="style.css" rel="stylesheet" type="text/css">
	</head>
	<body>
		<div id="main">
			<h1>PHP Login Session Example</h1>
			<div id="login">
				<h2>Login Form</h2>
				<form action="/shoplist/getListEntry.php" method="post">
					<label>UserName :</label>
					<input id="name" name="username" placeholder="username" type="text">
					<label>Password :</label>
					<input id="password" name="password" placeholder="**********" type="password">
					<label>Post1 :</label>
					<input id="listid" name="listid" placeholder="listid" type="text">
					<input name="submit" type="submit" value=" Login ">
				</form>
			</div>
		</div>
	</body>
</html>
<?php
	
		echo (time()+(2*3600)-strtotime("2017-12-06 00:45:59"));
	

?>