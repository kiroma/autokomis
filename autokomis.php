<?php
try{
	$sth = new PDO("mysql:host=127.0.0.1;charset=utf8", "autokomis", "strona");
	$sth -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
	die("Connection failed, $e");
}
try{
	$sth -> query("CREATE DATABASE IF NOT EXISTS Autokomis CHARACTER SET utf8 COLLATE utf8_general_ci");
	$sth -> query("USE Autokomis");
	$sth -> query("CREATE TABLE IF NOT EXISTS Autka 
	(ID int(10) PRIMARY KEY AUTO_INCREMENT NOT NULL, 
	Marka varchar(15) not null, 
	Model varchar(30) not null, 
	Pojemnosc varchar(30) not null, 
	Kolor varchar(15) not null, 
	Rocznik varchar(5) not null, 
	Przebieg int(20) not null, 
	Cena DECIMAL(10,2) not null,
	Zdjecie varchar(255))
	CHARACTER SET utf8 COLLATE utf8_general_ci");
}catch(PDOException $e){
	die("Creating database failed, $e");
}
print("<h1>Database connection estabilished</h1>");
if(isset($_POST["submit"]))
{
	try{
		$dbh = new PDO("mysql:host=127.0.0.1;charset=utf8;dbname=Autokomis", "autokomis", "strona");
	}catch(PDOException $e){
		die("Error when re-estabilishing database connection, $e");
	}
	$marka = $_POST["marka"];
	$model = $_POST["model"];
	$pojemnosc = $_POST["pojemnosc"];
	$kolor = $_POST["kolor"];
	$rocznik = $_POST["rocznik"];
	$przebieg = $_POST["przebieg"];
	$cena = $_POST["cena"];
	$zdjecie = 0;
	if(is_uploaded_file($_FILES["zdjecie"]["tmp_name"])){
		$check = getimagesize($_FILES["zdjecie"]["tmp_name"]);
		if($check !== false){
			$zdjecie = 1;
		}
		else{
			die("Couldn't get image size");
		}
	}
	try{
		$qry = $dbh -> prepare("INSERT INTO Autka(marka, model, pojemnosc, kolor, rocznik, przebieg, cena, zdjecie) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
		$qry -> execute(array($marka, $model, $pojemnosc, $kolor, $rocznik, $przebieg, $cena, $_FILES["zdjecie"]["name"]));
	}catch(PDOException $e){
		die("Inserting data failed, $e");
	}
	if($zdjecie == 1){
		print("Uploading $_FILES[zdjecie][name]<br>");
		$lastid = $dbh -> query("SELECT ID FROM Autka ORDER BY ID DESC LIMIT 1") -> fetchAll()[0];
		$photoid = $lastid["ID"];
		print("Photo ID = $photoid <br>");
		$tmpname = $_FILES["zdjecie"]["tmp_name"];
		$name = basename($_FILES["zdjecie"]["name"]);
		if (move_uploaded_file($tmpname, "/uploads/$name")){
			echo ("Image uploaded!");
		}else{
			print_r($tmpname." -> ".$name. "<br>");
			$dbh -> query("DELETE FROM Autka WHERE ID=$photoid");
			die("Something went wrong when uploading photo");
		}
	}
	echo ("Wystawiono!");
}
?>
