<?php


require ("./CMS/DB/connectDB.php");
//Connect to DB
$pdo = pdo_connect_mysql();

//GET THE DB SCHEMA
$file = fopen("./CMS/DB/schema.sql","r") or die("Please refresh the page");
$schema = " ";

while(!feof($file)) {
    $schema = $schema.fgets($file)."  ";
}

$pdo->query($schema);


?>