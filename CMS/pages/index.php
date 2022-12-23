<?php
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] == true){
    header("location: ./dashboard");
}
else{
    header("location ./auth");
}