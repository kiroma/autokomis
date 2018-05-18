<!DOCTYPE html>
<html>
	<head>
		<title>Autokomis</title>
		<meta charset=utf-8>
		<link rel=stylesheet href=default.css>
	</head>
	<body>
		<table>
		<tr>
			<th>ID</th>
			<th>Marka</th>
			<th>Model</th>
			<th>Pojemność</th>
			<th>Kolor</th>
			<th>Rocznik</th>
			<th>Przebieg</th>
			<th>Cena</th>
			<th>Zdjęcie</th>
		</tr>
			<?php
			try{
				$sth = new PDO("mysql:dbname=Autokomis;host=127.0.0.1;charset=utf8", "autokomis", "strona");
				$sth -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
			}catch(pdoexception $e)
			{
				die("Error estabilishing connection with database, $e");
			}
			try{
				$offers = $sth -> query("SELECT * FROM Autka") -> fetchAll();
				foreach($offers as $prod)
				{
					print("<tr>");
					for($i=0; $i<=8; $i++)
					{
						print("<td>");
						switch($i)
						{
							case 0:
							print("<a href=buy.php?id=$prod[$i]><img src=buy.png></a>");
							break;
							case 8:
							print("<img src=uploads/$prod[$i]>");
							break;
							default:
							print("$prod[$i]");
							break;
						}
						print("</td>");
					}
					print("</tr>");
				}
			}catch(pdoexception $e)
			{
				die("<h2>Error grabbing data from database (Did it die?)</h2><p>$e</p>");
			}
			?>
		</table>
	</body>
</html>
