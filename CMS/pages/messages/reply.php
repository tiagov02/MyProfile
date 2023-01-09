<?php
session_start();

require '../../DB/connectDB.php';
require '../utils/templates.php';

$pdo = pdo_connect_mysql();

if(isset($_GET['id'])) {
    $stmt = $pdo->prepare('SELECT * FROM messages where id=?');
    $stmt->execute([$_GET['id']]);
    $message = $stmt->fetch(PDO::FETCH_ASSOC);



    $pdo->prepare('UPDATE messages SET state = 1 WHERE id=?')->execute([$_GET['id']]);
    $st = $pdo->prepare('SELECT * from replies WHERE id_message=?');
    $st->execute([$_GET['id']]);
    $replies = $st->fetchAll(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST)) {
            $msg = !isset($_POST['msg']) ? '' : $_POST['msg'];
            $headers = "From: jtiagoviana@ipvc.pt" . "\r\n" .
                "CC: jtiagoviana@ipvc.pt" . "\r\n" .
                "Reply-To: <jtiagoviana@ipvc.pt>";
            $subject = "[#" . $pdo->lastInsertId() . "] You send a message to Tiago Viana";
            mail($message['from'], $subject, $msg, $headers);
            $st_create = $pdo->prepare('insert into replies (id_message, message, user) values (?,?,?);');
            $st_create->execute([$_GET['id'], $msg, $_SESSION['username']]);
            header("location: update.php?id=".$_GET['id']);
        }
    }
}
else{
    header("location: index.php");
}
template_header('tt');
?>

<div class="container-fluid m-1 overflow-auto bg-body-tertiary text-align-center">
    <!--EXTERNAL MSG-->
    <div class="row p-2 overflow-y-auto">
        <div class="col-1" style="border-right: solid 1px rgb(110, 110, 110);"><i class="bi bi-person-fill"></i></div>
        <div class="col-11">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-6">From:<?=$message['name']?><a href="mailto:<?=$message['from']?>"><<?=$message['from']?>></a></div>
                        <div class="col-6 text-body-secondary"><?=$message['date']?></div>
                    </div>
                </div>
                <div class="card-body">
                    <h5 class="card-title">Support Request #<?=$message['id']?></h5>
                    <p class="card-text"><?=$message['message']?></p>
                </div>
            </div>
        </div>
    </div>
    <?php foreach ($replies as $row):?>
        <div class="row p-2">
            <div class="col-1" style="border-right: solid 1px rgb(110, 110, 110);"><i class="bi bi-briefcase-fill"></i></div>
            <div class="col-11" >
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-6">From: Supporting Team(<?=$row['user']?>)</a></div>
                            <div class="col-6"><?=$row['date']?></div>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title">RE: Support Request #<?=$message['id']?></h5>
                        <p class="card-text"><?=$row['message']?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach;?>
    <form action="reply.php?id=<?=$_GET['id']?>" method="post">
        <div class="row py-4 px-1">
            <div class="col-1"></div>
            <div class="col-sm-8">
                <textarea name="msg" placeholder="message..." id="msg" class="form-control" rows="6" cols="10" required></textarea>
            </div>
            <div class="col-sm-3">
                <button class="btn btn-primary col-3" type="submit">Send</button>
            </div>
        </div>
    </form>
</div>

    <!--FORM-->
<div class="container mt-5 bg-body-secondary" >

</div>

<?=template_footer()?>
