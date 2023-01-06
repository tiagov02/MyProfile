<?php
session_start();

require "../utils/templates.php";
require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['id'])) {
    // Select the record that is going to be deleted
    $stmt = $pdo->prepare('SELECT * FROM technologies WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $technologie = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$technologie) {
        exit('Language doesn\'t exist with that ID!');
    }
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM technologies WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            $msg = 'You have deleted the language!';
        } else {
            // User clicked the "No" button, redirect them back to the read page
            header('Location: index.php');
            exit;
        }
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Delete')?>

<div class="content delete">
    <h2>Delete language #<?=$technologie['id']?></h2>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php else: ?>
        <p>Are you sure you want to delete <?=$technologie['name']?>?</p>
        <div class="yesno">
            <a href="delete.php?id=<?=$technologie['id']?>&confirm=yes">Yes</a>
            <a href="delete.php?id=<?=$technologie['id']?>&confirm=no">No</a>
        </div>
    <?php endif; ?>
</div>

<?=template_footer()?>
