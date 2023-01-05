<?php

require "../utils/templates.php";

session_start();

?>
<?php if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] == true ): ?>
<?=template_header('Home')?>

<div class="content">
    <h2>Dashboard</h2>
    <p>Hello to my CMS!</p>
</div>

<?=template_footer()?>
<?php else:
    header(" location: ../auth");
endif;
?>
