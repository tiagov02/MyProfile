<?php
session_start();
if($_SESSION['loggedin'] && $_SESSION['role'] == "Admin"):
require "../utils/templates.php";
require '../../DB/connectDB.php';

$pdo = pdo_connect_mysql();
$st_user = $pdo->prepare('SELECT * from users WHERE id=?');
$st_user->execute(array($_SESSION['id']));
$err = '';
$user = $st_user->fetch(PDO::FETCH_ASSOC);
$st_user_role = $pdo->prepare('SELECT * from user_roles WHERE id_user=?');
$st_user_role->execute(array($_SESSION['id']));
$user_role = $st_user_role->fetch(PDO::FETCH_ASSOC);

$sql = "UPDATE users SET password=:password WHERE id=:id";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST)){
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        if($password == $confirm_password){
            if($stmt = $pdo->prepare($sql)){
                $stmt->bindParam(":id", $_SESSION['id'], PDO::PARAM_STR);
                $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

                $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

                if($stmt->execute()){
                    header("location: ./");
                }
                else{
                    echo "Ups! Try again please.";
                }
                unset($stmt);
            }
        }
        else{
            $err = "Mismatching passwords";
        }
    }
}
?>
<?=template_header('title')?>

<div class="container py-4">
    <div class="row">
        <div class="col-md-3">
            <img class="img-fluid" src="../../../files/user.jpg"">
            <h4><?=$user['username']?></h4>
            <h4><?=$user_role['role']?></h4>
        </div>
        <div class="col-md-9">
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                <div class="form-outline mb-3">
                    <input type="password" name="password" class="form-control form-control-lg" value="<?php echo $password; ?>">
                    <label class="form-label" for="form3Example4">Password</label>
                </div>

                <!-- Password repeat input -->
                <div class="form-outline mb-3">
                    <input type="password" name="confirm_password" class="form-control form-control-lg <?php echo (!empty($err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                    <span class="invalid-feedback"><?php echo $err; ?></span>
                    <label class="form-label" for="form3Example4">Password repeat</label>
                </div>
                <button type="submit" class="btn btn-primary my-4">Submit</button>
            </form>
        </div>
    </div>
</div>
<?php else:
    header("location ../auth");
endif;
?>