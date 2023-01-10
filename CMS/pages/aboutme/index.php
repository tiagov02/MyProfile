<?php
session_start();
if($_SESSION['loggedin'] && $_SESSION['role'] == "Admin"):
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
    $github = $_POST['github'];
    $instagram = $_POST['instagram'];
    $whatsapp = $_POST['whatsapp'];
    $email = $_POST['email'];

   if(!empty($_FILES['myfile'])){
       if(is_uploaded_file($_FILES["myfile"]["tmp_name"])){
           $filename = date("YmdHis")."_".$_FILES["myfile"]["name"];
           $tempname = $_FILES["myfile"]["tmp_name"];
           $mimetype = $_FILES["myfile"]["type"];

           //Validate if the type is an image
           if($mimetype == 'image/jpg' || $mimetype == 'image/jpeg' || $mimetype == 'image/gif' || $mimetype == 'image/png'){
               if (move_uploaded_file($tempname, "../../../files/aboutme/".$filename)) {
                   $msg = "Image uploaded successfully";
                   $stmt = $pdo->prepare('UPDATE aboutme SET text=?, imagepath=?, my_name=?, actual_role=?,github=?,instagram=?,whatsapp=?,email=?, updated_on=CURDATE() WHERE id=1');
                   $stmt->execute([$description,$filename,$name,$actual_role,$github,$instagram,$whatsapp,$email]);
                   echo("<script>\"Updated sucessefyully!\"</script>");
                   header("location: ./");
               }else{
                   die("Nao foi possivel fazer o upload da imagem");
               }
           }else{
               $msg = "Please upload an image!";
           }
       } else{
           $stmt = $pdo->prepare('UPDATE aboutme SET text=?, my_name=?, actual_role=?,github=?,instagram=?,whatsapp=?,email=?, updated_on=CURDATE() WHERE id=1');
           $stmt->execute([$description,$name,$actual_role,$github,$instagram,$whatsapp,$email]);
           echo("<script>alert(\"Updated sucessefyully!\")</script>");
           header("location: ./");

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
                <label for="email">Email</label>
                <input type="email" name="email" placeholder="mail@mail.com" id="email" class="form-control" value="<?=$aboutme['email']?>" required>
                <label for="actual_role">What do you do in the moment?</label>
                <input type="text" name="actual_role" placeholder="Student" id="actual_role" class="form-control" value="<?=$aboutme['actual_role']?>" required>
                <label class="custom-file-label" for="myfile" data-browse="Procurar fotografia">Faça upload da nova imagem</label>
                <input type="file" class="form-control" id="myfile" name="myfile" accept="image/*">
                <label for="description">Description</label>
                <textarea  name="description" placeholder="I LIKE!" id="description" class="form-control" rows="6" cols="10"><?=$aboutme['text'];?></textarea>
                <label for="instagram">Instagram</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">@</span>
                    <input type="text" class="form-control" placeholder="Username" name="instagram" id="instagram" aria-label="Instagram" aria-describedby="basic-addon1" value="<?=$aboutme['instagram']?>" required>
                </div>
                <label for="whatsapp">Whatsapp</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">+351</span>
                    <input type="text" class="form-control" placeholder="Username" name="whatsapp" id="whatsapp" aria-label="Whatsapp" aria-describedby="basic-addon1" value="<?=$aboutme['whatsapp']?>" required>
                </div>
                <label for="github">Github</label>
                <div class="input-group mb-3">
                    <span class="input-group-text" id="basic-addon1">https://github.com/</span>
                    <input type="text" class="form-control" placeholder="Username" name="github" id="github" aria-label="Github" aria-describedby="basic-addon1" value="<?=$aboutme['github']?>" required>
                </div>
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
