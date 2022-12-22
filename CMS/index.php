<?php
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: ./pages");
}
else{
    header("location: ./auth");
}
?>
