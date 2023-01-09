<?php
session_start();

require "../utils/templates.php";


?>
<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"]): ?>

<?=template_header('Home')?>

<div class="content">
    <h2>Dashboard</h2>
    <p>Hello to my CMS!</p>
</div>
    <div id="myChart" style="width:100%; max-width:600px; height:500px;"></div>

<?=template_footer()?>
<?php else:
    header(" Location: ../auth");
    die();
endif;
?>
