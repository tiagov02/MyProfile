<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ):
require "../utils/templates.php";

require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;

// Prepare the SQL statement and get records from our languages table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM messages ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch the records, so we can display them in our template.
$certs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_records = $pdo->query('SELECT COUNT(*) FROM messages')->fetchColumn();
if(isset($_GET['id']) && isset($_GET['read'])){
    if(($_GET['read'] != "0") && ($_GET['read'] != "1")){
        echo(gettype($_GET['read']));
        header("location: index.php");
    }
    else{
        $st=$pdo->prepare('UPDATE messages SET state=? WHERE id=?');
        header("location: index.php");
        try{
            $st->execute([$_GET['read'],$_GET['id']]);
        }catch (PDOException $ex){
            die($ex->getMessage());
        }
    }
}
?>
<?php
    template_header('Home')
    ?>

    <div class="container my-5">
        <?php if($num_records > 0):?>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col"></th>
                    <th scope="col">#</th>
                    <th scope="col">From</th>
                    <th scope="col">Name</th>
                    <th scope="col">Date</th>
                    <th scope="col">State</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($certs as $row):?>
                    <tr style="<?=$row['state']==0 ? 'background-color: #a5a7a9;' : ''?>">
                        <th scope="row">
                            <span class="d-inline-block" tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus"
                                  data-bs-content="<?=$row['state'] == 0 ? 'Mark as read':'Mark as unread'?>">
                                <a href="index.php?id=<?=$row['id']?>&read=<?=$row['state'] == 0 ? '1':'0'?>" style="text-decoration:none;">
                                    <i class="<?=$row['state'] == 0 ? 'bi bi-envelope':'bi bi-envelope-open'?>"></i>
                                </a>
                            </span>
                        </th>
                        <th scope="row"><?=$row['id']?></th>
                        <td><?=$row['rementent']?></td>
                        <td><?=$row['name']?></td>
                        <td><?=$row['date']?></td>
                        <td><?=$row['state'] == 0 ? 'Unread':'Read'?></td>
                        <td class="actions">
                            <a href="reply.php?id=<?=$row['id']?>" ><i class="bi bi-pencil-square"></i></a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        <?php else:?>
            <strong><div class="empty-text">There are no messages</div></strong>
        <?php endif;?>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="index.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_records): ?>
            <a href="index.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
    <?=template_footer()?>
<?php else:
    header(" location: ../auth");
endif;
?>