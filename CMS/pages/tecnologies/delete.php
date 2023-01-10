<?php
session_start();
if($_SESSION['loggedin'] && $_SESSION['role'] == "Admin"):
require "../utils/templates.php";
require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();
$msg = '';
// Check that the language ID exists
if (isset($_GET['id'])) {
    // Make sure the user confirms before deletion
    if (isset($_GET['confirm'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            $stmt = $pdo->prepare('DELETE FROM technologies WHERE id = ?');
            $stmt->execute([$_GET['id']]);
            echo("<script>alert(\"You done the delete!\")</script>");
            header('Location: index.php');
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
<?php else:
    header("location ../auth");
endif;
?>
