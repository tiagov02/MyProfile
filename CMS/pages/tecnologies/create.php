<?php
session_start();

require "../utils/templates.php";
require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!empty($_FILES)) {

        if (!empty($_POST)) {
            if (is_uploaded_file($_FILES["myfile"]["tmp_name"])) {
                // Post data not empty insert a new record
                // Check if POST variable "name" exists, if not default the value to blank, basically the same for all variables
                $name = isset($_POST['name']) ? $_POST['name'] : '';
                $description = isset($_POST['description']) ? $_POST['description'] : '';
                // Insert new record into the languages table


                // Output message
                $msg = 'Created Successfully!';
                $filename = date("YmdHis") . "_" . $_FILES["myfile"]["name"];
                $tempname = $_FILES["myfile"]["tmp_name"];
                $mimetype = $_FILES["myfile"]["type"];

                //Validate if the type is an image
                if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/gif' || $mimetype == 'image/png') {
                    if (move_uploaded_file($tempname, "../../../files/techs/" . $filename)) {
                        $msg = "Image uploaded successfully";
                        $stmt = $pdo->prepare('insert into technologies (name, description,filename) values (?, ?,?)');

                        $stmt->execute([$name, $description,$filename]);
                    } else {
                        die("Nao foi possivel fazer o upload da imagem");
                    }
                } else {
                    $msg = "Please upload an image!";
                }
            }
        }
    }
}
?>

<?=template_header('Education');?>
    <div class="form-group mx-5 my-5">
        <h2>Create Technologie</h2>
        <form action="create.php" method="post" enctype="multipart/form-data" novalidate>
            <label for="name">Name</label>
            <input type="text" name="name" placeholder="Asp.net core 6" id="name" class="form-control">
            <label class="custom-file-label" for="myfile" data-browse="Procurar fotografia">Do upload the new image</label>
            <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*">
            <label for="description"></label>
            <textarea name="description" placeholder="I worked..." id="description" class="form-control" rows="6" cols="10"></textarea>
            <button type="submit" class="btn btn-primary my-4">Submit</button>
        </form>
        <?php if (isset($msg)): ?>
            <p><?=$msg?></p>
        <?php endif; ?>
    </div>

<?=template_footer();?>