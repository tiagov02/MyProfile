<?php
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    //header("location: ./education");
    print_r($_SESSION);
}
else{
    header("location ./auth");

}