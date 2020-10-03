<?php 

$host = "mysql:host=localhost;dbname=hospital";
$user = "root";
$pass = "";
try 
{
    $con = new PDO($host,$user,$pass);
}
catch(PDOException $e)
{
    echo "not connect ".$e->getMessage();
}