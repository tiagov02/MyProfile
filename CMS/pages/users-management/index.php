<?php
session_start();

require "../utils/templates.php";

require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

$page = isset($_GET['page']) && is_numeric($_GET['page']) ? (int)$_GET['page'] : 1;
// Number of records to show on each page
$records_per_page = 20;

// Prepare the SQL statement and get records from our languages table, LIMIT will determine the page
$stmt = $pdo->prepare('SELECT id,username FROM users ORDER BY id LIMIT :current_page, :record_per_page');
$stmt->bindValue(':current_page', ($page-1)*$records_per_page, PDO::PARAM_INT);
$stmt->bindValue(':record_per_page', $records_per_page, PDO::PARAM_INT);
$stmt->execute();

// Fetch the records, so we can display them in our template.
$education = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Get the total number of languages, this is so we can determine whether there should be a next and previous button
$num_records = $pdo->query('SELECT COUNT(*) FROM users')->fetchColumn();
?>
<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ):
    template_header('Home')
    ?>

    <div class="container my-5">
        <?php if($num_records > 0):?>
            <table class="table">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">Username</th>
                    <th scope="col">Role</th>
                    <th scope="col"></th>
                </tr>
                </thead>
                <tbody>
                <!--REPLACE TO THE FOR CICLE-->

                <?php foreach ($education as $row):?>
                    <tr>
                        <th scope="row"><?=$row['id']?></th>
                        <td><?=$row['username']?></td>
                        <td>
                            <?php
                            $role="NoRole";
                            $rolesql="SELECT id_user, role from user_roles WHERE id_user=:id";
                            if($statement = $pdo->prepare($rolesql)){
                                $statement->bindParam(":id", $row['id'],PDO::PARAM_INT);
                                if($statement->execute()){
                                    if($statement->rowCount()==1){
                                        if($line = $statement->fetch()){
                                            $role=$line['role'];
                                        }
                                    }
                                }
                            }
                            echo $role;
                            ?>
                        </td>
                        <td class="actions">
                            <a href="update.php?id=<?=$row['id']?>"><i class="bi bi-pencil"></i></a>
                            <a href="delete.php?id=<?=$row['id']?>" ><i class="bi bi-trash"></i></a>
                        </td>

                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
            <a href="./create.php" class="btn btn-primary">Create a Language</a>

        <?php else:?>
            <strong><div class="empty-text">There are no records in education try <a href="create.php">add</a> one</div></strong>
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

