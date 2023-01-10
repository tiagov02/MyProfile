<?php
session_start();

require "../utils/templates.php";

require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

$msg = '';
// Check if the language id exists, for example update.php?id=1 will get the language with the id of 1
if (isset($_GET['id'])) {
    if($_SERVER["REQUEST_METHOD"] == "POST") {
        if (!empty($_POST)) {
            if (!empty($_FILES)) {
                $name = isset($_POST['name']) ? $_POST['name'] : '';
                $description = isset($_POST['description']) ? $_POST['description'] : '';

                // Update the record
                $stmt = $pdo->prepare('UPDATE technologies SET name=?, description=? WHERE id = ?');
                $stmt->execute([$name, $description, $_GET['id']]);
                $msg = 'Updated Successfully!';
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

                    if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/gif' || $mimetype == 'image/png') {
                        if (move_uploaded_file($tempname, "../../../files/techs/" . $filename)) {
                            $msg = "Image uploaded successfully";
                            $stmt = $pdo->prepare('UPDATE technologies SET name=?, description=?, filename=? WHERE id = ?');

                            $stmt->execute([$name, $description, $filename]);
                        } else {
                            die("Nao foi possivel fazer o upload da imagem");
                        }
                    } else {
                        $msg = "Please upload an image!";
                    }
                }else{
                    // Update the record
                    $stmt = $pdo->prepare('UPDATE technologies SET name=?, description=? WHERE id = ?');
                    $stmt->execute([$name, $description, $_GET['id']]);
                    $msg = 'Updated Successfully!';
                }
            }
        }
    }
    // Get the language from the languages table
    $stmt = $pdo->prepare('SELECT * FROM technologies WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $technologie = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$technologie) {
        exit('Technologie doesn\'t exist with that ID!');
    }
} else {
    exit('No ID specified!');
}
?>

<?=template_header('Education');?>
    <div class="container py-4 px-4">
        <h2>Update Tecnhologie</h2>
        <div class="row">
            <div class="col-md-6">
                <img class="img-fluid" src="../../../files/techs/<?=$technologie['filename']?>"/>
            </div>
            <div class="col-md-6" id="myForm" style="display: block" >
                <div class="form-group mx-5 my-5">
                    <h2>Create language</h2>
                    <form action="update.php?id=<?=$_GET['id']?>'" method="post" enctype="multipart/form-data" novalidate>
                        <label for="name">Name</label>
                        <input type="text" name="name" placeholder="Asp.net core 6" id="name" class="form-control" value="<?=$technologie['name']?>">
                        <label class="custom-file-label" for="myfile" data-browse="Procurar fotografia">Do upload the new image</label>
                        <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*">
                        <label for="description">Description</label>
                        <textarea name="description" placeholder="I worked..." id="description" class="form-control" rows="6" cols="10">
                            <?=$technologie['description']?>
                        </textarea>
                        <button type="submit" class="btn btn-primary my-4">Submit</button>
                    </textarea>
                        <button type="submit" class="btn btn-primary my-4">Submit</button>
                    </form>
                    <?php if ($msg): ?>
                        <p><?=$msg?></p>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

<?=template_footer();?>