<!DOCTYPE html>
<html>
	<head>
		<title>Autokomis</title>
		<meta charset=utf-8>
		<link rel=stylesheet href=default.css>
	</head>
	<body>
		<?php
		try{
			$sth = new PDO("mysql:dbname=Autokomis;host=127.0.0.1;charset=utf8", "autokomis", "strona");
			$sth -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		}catch(pdoexception $e)
		{
			die("Error estabilishing connection with database, $e");
		}
		try{
			$qry = $sth -> prepare("DELETE FROM Autka WHERE ID=?");
			$qry -> execute(array($_GET[id]));
		}catch(pdoexception $e)
		{
			die("<h2>Error grabbing data from database (Did it die?)</h2><p>$e</p>");
		}
		print("<h1> Właśnie kupiłeś auto! </h1>");
		?>
	</body>
</html>
