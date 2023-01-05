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
            $place = isset($_POST['place']) ? $_POST['place'] : '';
            $description = isset($_POST['description']) ? $_POST['description'] : '';
            $year_ini = isset($_POST['year_ini']) ? $_POST['year_ini'] : '';
            $year_end = isset($_POST['year_end']) ? $_POST['year_end'] : '';

            // Update the record
            $stmt = $pdo->prepare('UPDATE education SET place=?, description=?, year_ini=?,year_end=? WHERE id = ?');
            $stmt->execute([$place, $description, $year_ini, $year_end, $_GET['id']]);
            $msg = 'Updated Successfully!';
        }
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM education WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $education = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$education) {
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
        <label for="place">Place</label>
        <input type="text" name="place" placeholder="Viana do Castelo" id="name" class="form-control" value="<?=$education['place']?>">
        <label for="year_ini">Year of start</label>
        <input type="number" name="year_ini" placeholder="2022" id="year_ini" class="form-control" value="<?=$education['year_ini']?>">
        <label for="year_end">Year of end</label>
        <input type="number" name="year_end" placeholder="2022" id="year_end" class="form-control" value="<?=$education['year_end']?>">
        <label for="description">Description</label>
        <textarea  name="description" placeholder="I LIKE!" id="description" class="form-control" rows="6" cols="10">
            <?=$education['description'];?>
        </textarea>
        <button type="submit" class="btn btn-primary my-4">Submit</button>
    </form>
    <?php if ($msg): ?>
        <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer();?>

