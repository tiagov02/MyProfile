<?php
require "../CMS/DB/connectDB.php";
$pdo = pdo_connect_mysql();

function getEducationRows(){
    $pdo = pdo_connect_mysql();

    return $pdo->query("SELECT * FROM education order by year_ini")->fetchAll(PDO::FETCH_ASSOC);

}