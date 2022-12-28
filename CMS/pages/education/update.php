<?php
require "../utils/templates.php";

require "../../DB/connectDB.php";

$pdo = pdo_connect_mysql();
//VER SESSION

    if(isset($_GET['id'])) {
        $stmt = $pdo->prepare('SELECT * FROM education WHERE id = ?');
        $stmt->execute([$_GET['id']]);
        $education = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$education) {
            exit('Language doesn\'t exist with that ID!');
        }
        if (!empty($POST)) {
               // Post data not empty insert a new record
               // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
               $place = isset($_POST['place']) ? $_POST['place'] : '';
               $description = isset($_POST['description']) ? $_POST['description'] : '';
               $year_ini = isset($_POST['year_ini']) ? $_POST['year_ini'] : '';
               $year_end = isset($_POST['year_end']) ? $_POST['year_end'] : '';
               // Insert new record into the languages table
               /**
                * INSERT INTO bd_sir.education (id, place, description, year_ini, year_end)
                */
               //$stmt = $pdo->prepare('INSERT INTO education(place, description, year_ini, year_end) VALUES (?, ?, ?, ?)');
               $stmt = $pdo->prepare('UPDATE education set place=?,description=?,year_ini=?,year_end=? WHERE id=?');
               $stmt->execute([$place, $description, $year_ini, $year_end, $_GET['id']]);
               // Output message
                $msg = 'UPDATED Successfully!';
            }
        }
?>

<?=template_header('Education');?>
<div class="form-group mx-5 my-5">
    <h2>Create language</h2>
    <form action="create.php" method="post">
        <label for="place">Place</label>
        <input type="text" name="place" placeholder="Viana do Castelo" id="name" class="form-control" value="<?=$education['place']?>">
        <label for="year_ini">Year of start</label>
        <input type="number" name="year_ini" placeholder="2022" id="year_ini" class="form-control" value="<?=$education['year_ini']?>">
        <label for="year_end">Year of end</label>
        <input type="number" name="year_end" placeholder="2022" id="year_end" class="form-control" value="<?=$education['year_end']?>">
        <label for="description">Description</label>
        <input type="text" name="description" placeholder="I LIKE!" id="description" class="form-control" value="<?=$education['description']?>">
        <button type="submit" class="btn btn-primary my-4">Submit</button>
    </form>
    <?php if (isset($msg)): ?>
        <p><?=$msg?></p>
    <?php endif; ?>
</div>

<?=template_footer();?>-->

