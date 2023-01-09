<?php
require "../CMS/DB/connectDB.php";
$pdo = pdo_connect_mysql();

function getEducationRows(){
    $pdo = pdo_connect_mysql();

    return $pdo->query("SELECT * FROM education order by year_ini")->fetchAll(PDO::FETCH_ASSOC);

}
function register_email($from,$name,$msg){
    $headers = "From: jtiagoviana@ipvc.pt" . "\r\n" .
        "CC: jtiagoviana@ipvc.pt"."\r\n".
        "Reply-To: <jtiagoviana@ipvc.pt>";
    $msg .= "\r\n\nNote that the team will reply in 24h!";
    $pdo = pdo_connect_mysql();
    $pdo->prepare('insert into messages (from, name, message,state) values (?, ?, ?, ?)')->execute([$from,$name,$msg,0]);
    $subject = "[#".$pdo->lastInsertId()."] You send a message to Tiago Viana";
    mail($from,$subject,$msg,$headers);

}
function registerNewDevice($devicetype,$ip){
    $pdo = pdo_connect_mysql();
    $pdo->prepare('insert into acess (deviceType, ip_adress) values (?, ?)')->execute([$devicetype,$ip]);

}