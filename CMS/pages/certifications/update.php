<?php
session_start();

require "../utils/templates.php";
require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

if(isset($_GET['id'])){
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $description = !isset($_POST['description']) ? '' : $_POST['description'];
        $title = !isset($POST['title']) ? '' : $_POST['title'];
        //Validate if the request have a file

        if (!empty($_POST)) {
            if (!empty($_FILES['myfile'])) {
                if (is_uploaded_file($_FILES["myfile"]["tmp_name"])) {
                    $filename = date("YmdHis") . "_" . $_FILES["myfile"]["name"];
                    $tempname = $_FILES["myfile"]["tmp_name"];
                    $mimetype = $_FILES["myfile"]["type"];

                    //Validate if the type is an image
                    if ($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/gif' || $mimetype == 'image/png') {
                        if (move_uploaded_file($tempname, "../../../files/aboutme/" . $filename)) {
                            $msg = "Image uploaded successfully";
                            $stmt = $pdo->prepare('UPDATE certifications SET imagepath=?, description=?, title=? WHERE id=?');
                            $stmt->execute([$filename, $description, $title,$_GET['id']]);
                            header("location: update.php?id=" . $pdo->lastInsertId());
                        } else {
                            die("Nao foi possivel fazer o upload da imagem");
                        }
                    } else {
                        $stmt = $pdo->prepare('UPDATE certifications SET description=?, title=? WHERE id=?');
                        $stmt->execute([$description, $title,$_GET['id']]);
                    }
                } else {
                    die("Error in uploading!");
                }
                header("location: ./");
            }
        }
    }
    $stmt = $pdo->prepare('SELECT * FROM certifications WHERE id = ?');
    $stmt->execute([$_GET['id']]);
    $cert = $stmt->fetch(PDO::FETCH_ASSOC);
    if (!$cert) {
        exit('Language doesn\'t exist with that ID!');
    }
}
?>
<?= template_header('ABOUT ME'); ?>
<div class="container py-4 px-4">
    <div class="row">
        <div class="col-md-6" id="myForm" style="display: block">
            <form action="update.php" method="post" enctype="multipart/form-data" novalidate>
                <label for="title">Title</label>
                <input type="text" name="title" placeholder="Place or title of the certification" id="title"
                       class="form-control" value="<?=$cert['title']?>" required>
                <label class="custom-file-label" for="myfile" data-browse="Procurar fotografia">Faça upload da imagem</label>
                <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*" required>
                <label for="description">Description</label>
                <textarea name="description" placeholder="I LIKE!" id="description" class="form-control" rows="6"
                          cols="10"></textarea>
                <button class="btn btn-primary float-end mt-5" type="submit">Update</button>
            </form>
        </div>
    </div>
</div>
<?= template_footer() ?>

