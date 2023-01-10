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
    $name = $_POST['name'];
    $actual_role = $_POST['actual_role'];
    //Validate if the request have a file
    //print_r($_POST);
   if(!empty($_FILES['myfile'])){
       if(is_uploaded_file($_FILES["myfile"]["tmp_name"])){
           $filename = date("YmdHis")."_".$_FILES["myfile"]["name"];
           $tempname = $_FILES["myfile"]["tmp_name"];
           $mimetype = $_FILES["myfile"]["type"];

           //Validate if the type is an image
           if($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/gif' || $mimetype == 'image/png'){
               if (move_uploaded_file($tempname, "../../../files/aboutme/".$filename)) {
                   $msg = "Image uploaded successfully";
                   $stmt = $pdo->prepare('UPDATE aboutme SET text=?, imagepath=?, my_name=?, actual_role=?, updated_on=CURDATE() WHERE id=1');
                   $stmt->execute([$description,$filename,$name,$actual_role]);
               }else{
                   die("Nao foi possivel fazer o upload da imagem");
               }
           }else{
               $msg = "Please upload an image!";
           }
       } else{
           $stmt = $pdo->prepare('UPDATE aboutme SET text=?, my_name=?, actual_role=?, updated_on=CURDATE() WHERE id=1');
           $stmt->execute([$description,$name,$actual_role]);

       }
       header("location: ./");
   }

}
?>

<?=template_header('ABOUT ME');?>
<div class="container py-4 px-4">
    <div class="row">
        <div class="col-md-6">
            <img class="img-fluid" src="../../../files/aboutme/<?=$aboutme['imagepath']?>"/>
        </div>
        <div class="col-md-6" id="myForm" style="display: block" >
            <form action="index.php" method="post" enctype="multipart/form-data" novalidate>
                <label for="name">Name</label>
                <input type="text" name="name" placeholder="Tiago Viana" id="name" class="form-control" value="<?=$aboutme['my_name']?>" required>
                <label for="actual_role">What do you do in the moment?</label>
                <input type="text" name="actual_role" placeholder="Student" id="actual_role" class="form-control" value="<?=$aboutme['actual_role']?>" required>
                <label class="custom-file-label" for="myfile" data-browse="Procurar fotografia">Faça upload da nova imagem</label>
                <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*">
                <label for="description">Description</label>
                <textarea  name="description" placeholder="I LIKE!" id="description" class="form-control" rows="6" cols="10"><?=$aboutme['text'];?></textarea>
                <button class="btn btn-primary float-end mt-5" type="submit">Update</button>
            </form>
        </div>
    </div>
</div>
<?=template_footer()?>
