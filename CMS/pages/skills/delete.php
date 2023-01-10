<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ) {
    require '../../DB/connectDB.php';
    $pdo = pdo_connect_mysql();
    if (isset($_GET['confirm']) && isset($_GET['id'])) {
        if ($_GET['confirm'] == 'yes') {
            // User clicked the "Yes" button, delete record
            try {
                $stmt = $pdo->prepare('DELETE FROM skills WHERE id = ?');
                $stmt->execute([$_GET['id']]);
                echo("<script>alert(\"You done the delete!\")</script>");
                header("location: index.php");
            } catch (PDOException $ex) {
                die("<h1>You entered uncorrectly on this script or an error occurs</h1>");
            }
        }
    }
}
