<?php
require "../utils/templates.php";

require "../../DB/connectDB.php";

$pdo = pdo_connect_mysql();


session_start();


$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['id'])) {
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST)) {
            // This part is similar to the create.php, but instead we update a record and not insert
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $level = isset($_POST['level']) ? $_POST['level'] : '';

            // Update the record
            $stmt = $pdo->prepare('UPDATE languages SET name=?, level=?, WHERE id = ?');
            $stmt->execute([$name,$level,$_GET['id']]);
            $msg = 'Updated Successfully!';
        }
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM languages WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $language = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$language) {
        exit('Language doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Education');?>
    <div class="form-group mx-5 my-5">
        <h2>Update Language <?=$language['name']?></h2>
        <form action="update.php?id=<?=$_GET['id']?>'" method="post">
            <label for="name">Language</label>
            <input type="text" name="name" placeholder="English" id="name" class="form-control" value="<?=$language['name']?>">
            <label for="level">Level</label>
            <input type="text" name="level" placeholder="Advanced" id="year_ini" class="form-control" value="<?=$language['level']?>">
            <button type="submit" class="btn btn-primary my-4">Submit</button>
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer();?>