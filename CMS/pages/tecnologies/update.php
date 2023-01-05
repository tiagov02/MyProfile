<?php
require "../utils/templates.php";

require "../../DB/connectDB.php";

session_start();

$pdo = pdo_connect_mysql();

$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['id'])) {
    if($_SERVER["REQUEST_METHOD"] == "POST"){
        if (!empty($_POST)) {
            // This part is similar to the create.php, but instead we update a record and not insert
            $name = isset($_POST['name']) ? $_POST['name'] : '';
            $description = isset($_POST['description']) ? $_POST['level'] : '';

            // Update the record
            $stmt = $pdo->prepare('UPDATE technologies SET name=?, description=?, WHERE id = ?');
            $stmt->execute([$name, $description, $_GET['id']]);
            $msg = 'Updated Successfully!';
        }
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM education WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $technologie = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$technologie) {
        exit('Language doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Education');?>
    <div class="form-group mx-5 my-5">
        <h2>Create language</h2>
        <form action="update.php?id=<?=$_GET['id']?>'" method="post">
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Asp.net core 6" id="name" class="form-control" value="<?=$technologie['name']?>">
            <label for="description"></label>
            <textarea name="description" placeholder="I worked..." id="description" class="form-control" rows="6" cols="10">
                <?=$technologie['description']?>
            </textarea>
            <button type="submit" class="btn btn-primary my-4">Submit</button>
        </textarea>
            <button type="submit" class="btn btn-primary my-4">Submit</button>
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer();?>