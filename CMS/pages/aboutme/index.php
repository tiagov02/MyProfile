<?php

require "../utils/templates.php";
require "../../DB/connectDB.php";
require_once "../../../index.php";

session_start();

$pdo = pdo_connect_mysql();

$aboutme = $pdo->query('SELECT * FROM aboutme WHERE id = 1')->fetch(PDO::FETCH_ASSOC);

if (!$aboutme) {
    die("We have a little problem, please come back in a few moment or let the administrator know");
}

if($_SERVER['REQUEST_METHOD'] == "POST" && !empty($_POST)){
    //IMAGES
    $description = isset($_POST['description']) ? $_POST['description'] : '';
}
?>

<?=template_header('ABOUT ME');?>
<div class="container">
    <div class="col-md-6">
        <img class="img-fluid" src="../../personal/assets/imgs<?=$aboutme['imagepath']?>"/>
    </div>
    <div class="col-md-6">
        <form action="index.php" method="post">

        </form>
    </div>
</div>
<?=template_footer()?>
