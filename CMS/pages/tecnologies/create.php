<?php
session_start();

require "../utils/templates.php";
require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!empty($_POST)) {
        // Post data not empty insert a new record
        // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
        $name = isset($_POST['name']) ? $_POST['name'] : '';
        $description = isset($_POST['description']) ? $_POST['description'] : '';
        // Insert new record into the languages table

        $stmt = $pdo->prepare('insert into technologies (name, description) values (?, ?)');

        $stmt->execute([$name,$description]);

        // Output message
        $msg = 'Created Successfully!';
    }
}
?>

<?=template_header('Education');?>
    <div class="form-group mx-5 my-5">
        <h2>Create language</h2>
        <form action="create.php" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Asp.net core 6" id="name" class="form-control">
            <label for="description"></label>
            <textarea name="description" placeholder="I worked..." id="description" class="form-control" rows="6" cols="10"></textarea>
            <button type="submit" class="btn btn-primary my-4">Submit</button>
        </form>
        <?php if (isset($msg)): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer();?>