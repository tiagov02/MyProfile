<?php
session_start();
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true ):

require "../utils/templates.php";

require "../../DB/connectDB.php";
$pdo = pdo_connect_mysql();

$username = $password = $confirm_password = "";
$username_err = $password_err = $confirm_password_err = "";

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(empty(trim($_POST["username"]))){
        $username_err = "Please fill username.";
    }
    elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        $username_err = "Wrong username pattern!";
    }
    else{
        $sql = "SELECT id FROM users WHERE username = :username";

        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $param_username = trim($_POST["username"]);

            if($stmt->execute()){
                if($stmt->rowCount() == 1){
                    $username_err = "Username already exists!";
                }
                else{
                    $username = trim($_POST["username"]);
                }
            }
            else{
                echo "Ups! Try again please.";
            }

            unset($stmt);
        }
    }

    if(empty(trim($_POST["password"]))){
        $password_err = "Please fill password.";
    }
    elseif(strlen(trim($_POST["password"])) < 6){
        $password_err = "Password need to be at least 6 chareters.";
    }
    else{
        $password = trim($_POST["password"]);
    }

    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "Please fill confirm password.";
    }
    else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Passwords missmatch!";
        }
    }

    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){

        $sql = "INSERT INTO users (username, password) VALUES (:username, :password)";

        if($stmt = $pdo->prepare($sql)){
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindParam(":password", $param_password, PDO::PARAM_STR);

            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); // Creates a password hash

            if($stmt->execute()){
                echo ("<script>alert(\"You create a user secessfulty\");</script>");
            }
            else{
                echo "Ups! Try again please.";
            }

            unset($stmt);
        }
    }

    unset($pdo);
}
    ?>

    <?=template_header('Education');?>
    <div class="form-group mx-5 my-5">
        <h2>Create language</h2>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <label for="username">Username</label>
            <input type="text" name="username" placeholder="insert username here" id="username" class="form-control form-control-lg <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $username_err; ?></span>
            <label for="password">Password</label>
            <input type="text" name="password" placeholder="password" id="password" class="form-control form-control-lg <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
            <span class="invalid-feedback"><?php echo $password_err; ?></span>
            <select class="form-select" aria-label="Default select example" name="role" required>
                <option selected>Open this select menu</option>
                <option value="Admin">Admin</option>
                <option value="Manager">Manager</option>
            </select>
            <button type="submit" class="btn btn-primary my-4">Submit</button>
        </form>
        <?php if (isset($msg)): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

    <?=template_footer();?>
<?php endif;?>