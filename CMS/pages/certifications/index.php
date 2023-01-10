<?php
session_start();
if($_SESSION['loggedin'] && $_SESSION['role'] == "Admin"):
require "../utils/templates.php";

require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;

// Prepare the SQL statement and get records from our languages table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT * FROM certifications ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch the records, so we can display them in our template.
$certs = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_records = $pdo->query('SELECT COUNT(*) FROM certifications')->fetchColumn();
?>
<?php
    template_header('Home')
    ?>

    <div class="container my-5">
        <?php if($num_records > 0):?>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Title</th>
                    <th scope="col">Description</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <!--REPLACE TO THE FOR CICLE-->

                <?php foreach ($certs as $row):?>
                    <tr>
                        <th scope="row"><?=$row['id']?></th>
                        <td><?=$row['title']?></td>
                        <td><?=$row['description']?></td>
                        <td class="actions">
                            <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#modaldelete<?=$row['id']?>">
                                <i class="bi bi-trash"></i>
                            </button>
                            <a href="update.php?id=<?=$row['id']?>"><i class="bi bi-pencil-square"></i></a>
                        </td>
                        <!-- Modal -->
                        <div class="modal fade" id="modaldelete<?=$row['id']?>" tabindex="-1" aria-labelledby="delete<?=$row['id']?>" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h1 class="modal-title fs-5" id="delete<?=$row['id']?>">Dou you sure if you want to delete?</h1>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        You've gonna delete this certification: <strong><?=$row['title']?></strong>!
                                        <h5>Please remember that this action is permanent!</h5>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                        <a type="button" class="btn btn-primary" href="delete.php?id=<?=$row['id']?>&confirm=yes">Save changes</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <a href="./create.php" class="btn btn-primary">Create Certification</a>

        <?php else:?>
            <strong><div class="empty-text">There are no records try <a href="create.php">add</a> one</div></strong>
        <?php endif;?>
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
