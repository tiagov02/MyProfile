<?php
require '../DB/connectDB.php';
$pdo = pdo_connect_mysql();

echo(json_encode($pdo->query("select COUNT(*) as num_devices,deviceType from acess group by deviceType;")->fetchAll(PDO::FETCH_ASSOC)));
