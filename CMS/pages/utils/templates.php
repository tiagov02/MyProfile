<?php


if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
    header("location: ../../auth/login.php");
    exit;
}

function template_header($title) {
    $username  = $_SESSION["username"];

    echo <<<EOT
<!DOCTYPE html>
<html>
	<head>
		<meta charset="utf-8">
		<title>My CMS</title>
		<!-- CSS only -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-rbsA2VBKQhggwzxH7pPCaAqO46MgnOM80zW1RWuH61DGLwZJEdK2Kadq2F9CUG65" crossorigin="anonymous">

		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
		<link href="../style.css" rel="stylesheet" type="text/css">

	</head>
	<body>
    <nav class="navtop">
    	<div>
    		<h1>Hello $username</h1>
    		<a href="../dashboard"><i class="fas fa-address-book"></i>Dashboard</a>
    		<a href="../aboutme"><i class="fas fa-address-book"></i>About Me</a>
    		<a href="../certifications"><i class="fas fa-address-book"></i>Certifications</a>
    		<a href="../education"><i class="fas fa-address-book"></i>Education</a>
    		<a href="../irs-simulator"><i class="fas fa-address-book"></i>IRS Simulator</a>
    		<a href="../languages"><i class="fas fa-address-book"></i>Languages</a>
    		<a href="../messages"><i class="fas fa-address-book"></i>Messages</a>
    		<a href="../skills"><i class="fas fa-address-book"></i>Skills</a>
    		<a href="../tecnologies"><i class="fas fa-address-book"></i>Technologies</a>
    		<a href="../USERS-MANAGEMENT"><i class="fas fa-address-book"></i>Users Management</a>
			<a href="../../auth/logout.php">Logout</a>
    	</div>
    </nav>
EOT;
}
function template_footer() {
    echo <<<EOT
    </body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-kenU1KFdBIe4zVF0s0G1M5b4hcpxyD9F7jL+jjXkk+Q2h455rYXK/7HAuoJl+0I4" crossorigin="anonymous"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script src="../myfunctions.js"></script></html>
EOT;
}
?>