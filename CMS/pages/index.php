<?php
session_start();
if(isset($_SESSION['loggedin']) && $_SESSION['loggedin'] === true){
    header("location: ./education");
}
else{
    header("location: ./auth");
}