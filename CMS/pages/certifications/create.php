<?php
session_start();
if($_SESSION['loggedin'] && $_SESSION['role'] == "Admin"):
require "../utils/templates.php";
require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST)){
        $description = !isset($_POST['description']) ? '' : $_POST['description'];
        $title = $_POST['title'];
        print_r($_POST);
        //Validate if the request have a file
        if(!empty($_FILES['myfile'])){
            if(is_uploaded_file($_FILES["myfile"]["tmp_name"])){
                $filename = date("YmdHis")."_".$_FILES["myfile"]["name"];
                $tempname = $_FILES["myfile"]["tmp_name"];
                $mimetype = $_FILES["myfile"]["type"];

                //Validate if the type is an image
                if($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/gif' || $mimetype == 'image/png'){
                    if (move_uploaded_file($tempname, "../../../files/certifications/".$filename)) {
                        $msg = "Image uploaded successfully";
                        $stmt = $pdo->prepare('insert into certifications (imagepath, description, title) values (?, ?, ?);');
                        $stmt->execute([$filename,$description,$title]);
                        //header("location: update.php?id=".$pdo->lastInsertId());
                        echo("<script>alert(\"Created sucessefyully!\")</script>");
                    }else{
                        die("Nao foi possivel fazer o upload da imagem");
                    }
                }else{
                    $msg = "Please upload an image!";
                }
            }
            else{
                die("Error in uploading!");
            }
        }
    }

}
?>
<?=template_header('ABOUT ME');?>
<div class="container py-4 px-4">
    <h2>Create Certification</h2>
    <div class="row">
        <div class="col-md-6" id="myForm" style="display: block" >
            <form action="create.php" method="post" enctype="multipart/form-data" novalidate>
                <label for="title">Title</label>
                <input type="text" name="title" placeholder="Place or title of the certification" id="title" class="form-control" required>
                <label class="custom-file-label" for="myfile" data-browse="Procurar fotografia">Faça upload da imagem</label>
                <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*" required>
                <label for="description">Description</label>
                <textarea name="description" placeholder="I LIKE!" id="description" class="form-control" rows="6" cols="10"></textarea>
                <button class="btn btn-primary float-end mt-5" type="submit">Update</button>
            </form>
        </div>
    </div>
</div>
<?=template_footer()?>
<?php else:
    header("location ../auth");
endif;
?>
