<?php
require "../../utils/templates.php";

require "../../DB/connectDB.php";

$pdo = pdo_connect_mysql();
//VER SESSION
//CORRECT THE VARIABLES DONT SEND TO DB
if($_SERVER["REQUEST_METHOD"] == "POST"){
    if (!empty($_POST)) {
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
        $stmt = $pdo->prepare('INSERT INTO education(place, description, year_ini, year_end) VALUES (?, ?, ?, ?)');
        $stmt->execute([ $place, $description, $year_ini, $year_end]);
        // Output message
        $msg = 'Created Successfully!';
    }
}
?>

<?=template_header('Education');?>
    <div class="content update">
        <h2>Create language</h2>
        <form action="create.php" method="post">
            <label for="place">Place</label>
            <input type="text" name="place" placeholder="Viana do Castelo" id="name">
            <label for="year_ini">Year of start</label>
            <input type="number" name="level" placeholder="2022" id="year_ini">
            <label for="year_end">Year of end</label>
            <input type="number" name="level" placeholder="2022" id="year_end">
            <label for="description">Description</label>
            <input type="text" name="level" placeholder="I LIKE!" id="description">
            <input type="submit" value="Create">
        </form>
        <?php if ($msg): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer();?>