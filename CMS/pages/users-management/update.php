<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ):

require "../utils/templates.php";

require "../../DB/connectDB.php";
$pdo = pdo_connect_mysql();

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";
if(isset($_GET['id'])) {
    $sql = "SELECT id,username FROM users WHERE id=:id";

    $stmt = $pdo->prepare($sql);
    $stmt->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    $sql2 = "SELECT role FROM user_roles WHERE id_user=:id";

    $st = $pdo->prepare($sql2);
    $st->bindParam(":id", $_GET['id'], PDO::PARAM_INT);
    $st->execute();
    $role = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(!empty($_POST)){
            print_r($_POST);
            if (isset($_POST["password"])) {
                if (strlen(trim($_POST["password"])) < 6) {
                    $password_err = "Password need to be at least 6 chareters.";
                } else {
                    $password = trim($_POST["password"]);
                    $confirm_password = trim($_POST['confirm_password']);
                    $sql = "UPDATE users SET password =:password WHERE id=:id;";
                    if ($password !== $confirm_password) {
                        $confirm_password_err = "Passwords missmatch!";
                    } elseif ($stmt = $pdo->prepare($sql)) {
                        $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);
                        $stmt->bindParam(":id", $_GET['id']);
                        $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                        if ($stmt->execute()) {
                            echo("<script>alert(\"You update a user secessfulty\");</script>");
                            //header("location: ./");
                        }
                    }
                }
            }elseif (isset($_POST['role'])){
                $pdo->prepare("update user_roles set role=? WHERE id_user=?")->execute([ $_POST['role'], $_GET['id']]);
                echo("<script>alert(\"You update a user secessfulty\");</script>");
                header("location: ./");
            }
        }
    }

unset($pdo);
?>
<?=template_header('Users')?>
        <div class="container py-4">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?=$_GET['id']?>" method="post">
        <label><?=$user['username']?></label>
        <!--PWD-->
        <label for="password">Password</label>
        <input type="text" name="password" placeholder="password" id="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
        <span class="invalid-feedback"><?php echo $password_err; ?></span>
        <!--CONF PQD-->
        <label for="confirm_password">Password</label>
        <input type="text" name="confirm_password" placeholder="confirm password" id="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>">
        <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
        <button type="submit" class="btn btn-primary my-4">Submit</button>
    </form>
        </div>
    <div class="container">
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>?id=<?=$_GET['id']?>" method="post">
        <label for="role">Selecione a role do user</label>
        <select class="form-select" aria-label="Default select example" name="role" value="<?=$role['role']?>"required>
            <option value="Admin" <?php if ($role == "Admin") { echo ' selected';}?>>Admin</option>
            <option value="Manager" <?php if ($role == "Manager") { echo ' selected';}?>>Manager</option>
        </select>
        <button type="submit" class="btn btn-primary my-4">Submit</button>
    </form>
    </div>
    <?=template_footer();?>
    <?php
    }
    else{
        echo("<script>alert(\"you dont set any id\")</script>");
        header("location: index.php");
    }
    else:
        echo("<script>alert(\"you are not logged in\");</script>");
        header("location: ../auth");
        die();
    ?>
<?php endif;?>