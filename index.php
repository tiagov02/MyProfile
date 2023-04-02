<?php

require ("./CMS/DB/connectDB.php");
//Connect to DB
$pdo = pdo_connect_mysql();
error_reporting(E_ALL);
ini_set('display_errors', 'on');

//GET THE DB SCHEMA
$file = fopen("./CMS/DB/schema.sql","r") or die("Please refresh the page");
$schema = " ";

while(!feof($file)) {
    $schema = $schema.fgets($file)."  ";
}
//CREATE THE TABLES IF NOT EXISTS
$pdo->query($schema);
//Create the registry about me if not created
$aboutme = $pdo->query("SELECT id from aboutme WHERE id=1")->fetch(PDO::FETCH_ASSOC);

if(!$aboutme){
    $pdo->query("insert into aboutme (id) values (1);");
}

header("location: ./personal");

?>