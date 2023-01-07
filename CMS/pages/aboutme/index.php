<?php
session_start();

require "../utils/templates.php";
require "../../DB/connectDB.php";


$pdo = pdo_connect_mysql();

$aboutme = $pdo->query('SELECT * FROM aboutme WHERE id = 1')->fetch(PDO::FETCH_ASSOC);

if (!$aboutme) {
    die("We have a little problem, please come back in a few moment or let the administrator know");
}

if($_SERVER["REQUEST_METHOD"] == "POST"){
    $description = !isset($_POST['description']) ? '' : $_POST['description'];

    //Validate if the request have a file
   if(!empty($_FILES)){
       if(is_uploaded_file($_FILES["myfile"]["tmp_name"])){
           $filename = date("YmdHis")."_".$_FILES["myfile"]["name"];
           $tempname = $_FILES["myfile"]["tmp_name"];
           $mimetype = $_FILES["myfile"]["type"];

           //Validate if the type is an image
           if($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/gif' || $mimetype == 'image/png'){
               if (move_uploaded_file($tempname, "../../../files/aboutme/".$filename)) {
                   $msg = "Image uploaded successfully";
                   $stmt = $pdo->prepare('UPDATE aboutme SET text=?, imagepath=?, updated_on=CURDATE() WHERE id=1');
                   $stmt->execute([$description,$filename]);
               }else{
                   die("Nao foi possivel fazer o upload da imagem");
               }
           }
       }
   }
   else{
       $stmt = $pdo->prepare('UPDATE aboutme SET text=?, updated_on=CURDATE() WHERE id=1');
       $stmt->execute([$description]);
   }
}
?>

<?=template_header('ABOUT ME');?>
<div class="container py-4 px-4">
    <div class="row bg-danger">
        <div class="col-md-6">
            <img class="img-fluid" src="../../../files/aboutme/<?=$aboutme['imagepath']?>"/>
        </div>
        <div class="col-md-6" id="myForm" style="display: block" >
            <form action="index.php" method="post" enctype="multipart/form-data" novalidate >
                <label class="custom-file-label" for="movie_image" data-browse="Procurar fotografia">Faça upload da nova imagem</label>
                <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*">
                <label for="description">Description</label>
                <textarea  name="description" placeholder="I LIKE!" id="description" class="form-control" rows="6" cols="10"><?=$aboutme['text'];?></textarea>
                <button class="btn btn-primary float-end mt-5" type="submit">Update</button>

            </form>
        </div>
    </div>
</div>
<?=template_footer()?>
