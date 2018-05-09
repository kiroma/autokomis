<?php
try{
    $sth = new PDO("mysql:host=127.0.0.1;charset=utf8", "autokomis", "strona");
    $sth -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e)
{
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
    Zdjecie varchar(2083))
    CHARACTER SET utf8 COLLATE utf8_general_ci");
}catch(PDOException $e)
{
    die("Creating database failed, $e");
}
if(isset($_POST["submit"]))
{
    $marka = $_POST["marka"];
    $model = $_POST["model"];
    $pojemnosc = $_POST["pojemnosc"];
    $kolor = $_POST["kolor"];
    $rocznik = $_POST["rocznik"];
    $przebieg = $_POST["przebieg"];
    $cena = $_POST["cena"];
    try{
        $qry = $sth -> prepare("INSERT INTO Autka(marka, model, pojemnosc, kolor, rocznik, przebieg, cena) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $qry -> execute(array($marka, $model, $pojemnosc, $kolor, $rocznik, $przebieg, $cena));
    }catch(PDOException $e)
    {
        die("Inserting data failed, $e");
    }
}
echo ("Wystawiono!");
?>
