<?php
session_start();
if($_SESSION['loggedin'] && $_SESSION['role'] == "Admin"):
require "../utils/templates.php";

require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!empty($_POST)) {
        // Post data not empty insert a new record
        // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $level = isset($_POST['level']) ? $_POST['level'] : '';
        // Insert new record into the languages table

        $stmt = $pdo->prepare('insert into languages (name, level) values (?, ?)');

        $stmt->execute([$name,$level]);

        // Output message
        echo("<script>alert(\"Created sucessefyully!\")</script>");
    }
}
?>

<?=template_header('Education');?>
    <div class="form-group mx-5 my-5">
        <h2>Create language</h2>
        <form action="create.php" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="English" id="name" class="form-control">
            <label for="level">Level</label>
            <input type="text" name="level" placeholder="Advanced" id="year_ini" class="form-control">
            <button type="submit" class="btn btn-primary my-4">Submit</button>
        </form>
    </div>

<?=template_footer();?>
<?php else:
    header("location ../auth");
endif;
?>
