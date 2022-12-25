<?php

require "../utils/templates.php";

require "../../DB/connectDB.php";

$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;

// Prepare the SQL statement and get records from our languages table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM education ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch the records, so we can display them in our template.
$education = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_records = $pdo->query('SELECT COUNT(*) FROM education')->fetchColumn();
?>
<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ):
    template_header('Home')
    ?>

    <div>
        <table class="table">
            <thead class="thead-dark">
            <tr>
                <th scope="col">#</th>
                <th scope="col">Place</th>
                <th scope="col">Year of Iniciation</th>
                <th scope="col">Year of end</th>
                <th scope="col">Description</th>
            </tr>
            </thead>
            <tbody>
            <!--REPLACE TO THE FOR CICLE-->
            <?php if($num_records > 0):
                foreach ($education as $row):?>
                    <tr>
                        <th scope="row"><?=$row['id']?></th>
                        <td><?=$row['place']?></td>
                        <td><?=$row['year_ini']?></td>
                        <td><?=$row['year_end']?></td>
                        <td><?=$row['description']?></td>

                    </tr>
                    <?php endforeach; ?>
            <?php endif;?>
            </tbody>
        </table>
    </div>

    <div class="pagination">
        <?php if ($page > 1): ?>
            <a href="index.php?page=<?=$page-1?>"><i class="fas fa-angle-double-left fa-sm"></i></a>
        <?php endif; ?>
        <?php if ($page*$records_per_page < $num_records): ?>
            <a href="index.php?page=<?=$page+1?>"><i class="fas fa-angle-double-right fa-sm"></i></a>
        <?php endif; ?>
    </div>
    <?=template_footer()?>
<?php else:
    header(" location: ../auth");
endif;
?>
