<?php
require_once './utils/request_data.php';
require_once '../libraries/MobileDetect.php';
//OBTAIN THE Data
$education = getEducationRows();
$techs = getTechRows();
$languages = getLanguageRows();
$skills = getSkillRows();
$certs = getCertificationRows();
$aboutme = getAboutMe();

//detect device type
$detect = new \Detection\MobileDetect();
$deviceType = ($detect->isMobile() ? ($detect->isTablet() ? 'tablet' : 'phone') : 'computer');
$ip = $_SERVER['REMOTE_ADDR'];
registerNewDevice($deviceType,$ip);
$email_err='';

if($_SERVER["REQUEST_METHOD"] == "POST"){
    if(!empty($_POST)){
        $email = $_POST['email'];
        $name = !isset($POST['name'])? '' : $_POST['name'];
        $msg = !isset($POST['msg'])? '' : "Sended by: ".$name."\r\n"."Email adress: ".$email."\r\n".$_POST['msg'];
        if(!filter_var($email,FILTER_VALIDATE_EMAIL)){
            $email_err="Please input a valid email";
        }else{
            register_email($email,$name,$msg);
            echo("<script>\"You send a sucessefully message!\"</script>");
            header("location: ./");
        }
    }
}
?>
<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Presentention</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css">
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-Zenh87qX5JnK2Jl0vWa8Ck2rdkQ2Bzep5IDxbcnCeuOxjzrPF/et3URy9Bv1WTRi"
        crossorigin="anonymous"/>
    <link rel="stylesheet" href="./assets/css/stylesheet.css" />
</head>
<body>
<header class="d-flex flex-wrap justify-content-center py-3 mb-4 border-bottom">
    <ul class="nav nav-pills">
        <li class="nav-item">
            <a href="#aboutme" class="nav-link" aria-current="page">About me</a>
        </li>
        <li class="nav-item"><a href="#skills" class="nav-link">Skills</a></li>
        <li class="nav-item">
            <a href="#languages" class="nav-link">Languages</a>
        </li>
        <li class="nav-item">
            <a href="#technologies" class="nav-link">Technologies</a>
        </li>
        <li class="nav-item">
            <a href="#education" class="nav-link">Education</a>
        </li>
        <li class="nav-item">
            <a href="#certs" class="nav-link">Certifications</a>
        </li>
        <li class="nav-item">
            <a href="#contactme" class="nav-link">Contact Me</a>
        </li>
    </ul>
</header>

<main class="my-color">
    <div>
        <h1 class="d-flex justify-content-center"><?=$aboutme['my_name']?></h1>
        <h2 class="d-flex justify-content-center"><?=$aboutme['actual_role']?></h2>
        <div class="d-flex justify-content-center">
            <svg
                xmlns="http://www.w3.org/2000/svg"
                width="16"
                height="16"
                fill="currentColor"
                class="bi bi-envelope-at-fill"
                viewBox="0 0 16 16"
            >
                <path
                    d="M2 2A2 2 0 0 0 .05 3.555L8 8.414l7.95-4.859A2 2 0 0 0 14 2H2Zm-2 9.8V4.698l5.803 3.546L0 11.801Zm6.761-2.97-6.57 4.026A2 2 0 0 0 2 14h6.256A4.493 4.493 0 0 1 8 12.5a4.49 4.49 0 0 1 1.606-3.446l-.367-.225L8 9.586l-1.239-.757ZM16 9.671V4.697l-5.803 3.546.338.208A4.482 4.482 0 0 1 12.5 8c1.414 0 2.675.652 3.5 1.671Z"
                />
                <path
                    d="M15.834 12.244c0 1.168-.577 2.025-1.587 2.025-.503 0-1.002-.228-1.12-.648h-.043c-.118.416-.543.643-1.015.643-.77 0-1.259-.542-1.259-1.434v-.529c0-.844.481-1.4 1.26-1.4.585 0 .87.333.953.63h.03v-.568h.905v2.19c0 .272.18.42.411.42.315 0 .639-.415.639-1.39v-.118c0-1.277-.95-2.326-2.484-2.326h-.04c-1.582 0-2.64 1.067-2.64 2.724v.157c0 1.867 1.237 2.654 2.57 2.654h.045c.507 0 .935-.07 1.18-.18v.731c-.219.1-.643.175-1.237.175h-.044C10.438 16 9 14.82 9 12.646v-.214C9 10.36 10.421 9 12.485 9h.035c2.12 0 3.314 1.43 3.314 3.034v.21Zm-4.04.21v.227c0 .586.227.8.581.8.31 0 .564-.17.564-.743v-.367c0-.516-.275-.708-.572-.708-.346 0-.573.245-.573.791Z"
                />
            </svg>
            <a href="mailto:<?=$aboutme['email']?>"> <?=$aboutme['email']?> </a>
        </div>
    </div>
    <div class="mt-4 container">
        <div class="row">
            <div class="px-4 col-sm-6">
                <img src="../files/aboutme/<?=$aboutme['imagepath']?>" class="img-fluid" />
            </div>
            <div class="col-sm-6" id="aboutme">
                <h3>About Me</h3>
                <p>
                    <?=$aboutme['text']?>
                </p>
                <p class="text-end text-body-secondary">Updated on: <?=$aboutme['updated_on']?></p>
            </div>
        </div>
    </div>
        <div class="mt-4 container">
            <div class="row">
                <div class="col-sm-6" id="skills">
                    <?php if($skills){?><h3>My Skills</h3><?php }?>

                    <ul>
                        <?php foreach ($skills as $skill):?>
                        <li><?=$skill['description']?></li>
                        <?php endforeach;?>
                    </ul>

                </div>

                <div class="col-sm-6" id="languages">
                    <?php if($languages){?><h3>Languages</h3><?php }?>
                    <ul>
                        <?php foreach ($languages as $lang):?>
                        <li><?=$lang['name']?> - <?=$lang['level']?></li>
                        <?php endforeach;?>
                    </ul>

                </div>
            </div>
        </div>
        <div class="mt-4 container bg-terciary" id="technologies">
            <?php if($techs){?><h3 class="text-center">My Technologies</h3><?php }?>
            <div class="accordion" id="accordionExample">
                <?php foreach ($techs as $tec):?>
                <div class="accordion-item">
                    <h2 class="accordion-header" id="heading<?=$tec['id']?>">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse<?=$tec['id']?>" aria-expanded="false" aria-controls="collapse<?=$tec['id']?>">
                            <?=$tec['name']?>
                        </button>
                    </h2>
                    <div id="collapse<?=$tec['id']?>" class="accordion-collapse collapse" aria-labelledby="heading<?=$tec['id']?>" data-bs-parent="#accordionExample" style="">
                        <div class="accordion-body">
                            <div class="row">
                                <div class="col-2"><img class="img-fluid" src="../files/techs/<?=$tec['filename']?>"></div>
                                <div class="col-10"><?=$tec['description']?></div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach;?>
            </div>
        </div>
    <div class="container">
        <div class="row">
            <div class="mt-8 col-sm-12" id="education">
                <?php if($education){?><h3 class="d-flex justify-content-center">Education</h3><?php }?>
                <div class="timeline-main">
                    <ul class="stepper stepper-vertical timeline timeline-animated pl-0">
                        <?php foreach ($education as $row):?>
                        <li>
                            <a href="#!">
                                <span class="circle default-color z-depth-1-half"><i class="fas fa-heart" aria-hidden="true"></i></span>
                            </a>
                            <div class="step-content z-depth-1 ml-2 p-4">
                                <h4 class="font-weight-bold"><?=$row['place']?></h4>
                                <p class="text-muted mt-3">
                                    <i class="far fa-clock" aria-hidden="true"></i>
                                    <?=$row['year_end']!=0? $row['year_ini']."-".$row['year_end'] : $row['year_ini']."-"."Actuality"?>
                                </p>
                                <p class="mb-0"><?=$row['description']?></p>
                            </div>
                        </li>
                        <?php endforeach;?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="container">

        <div class="row">
            <div class="my-margin-from-form mt-8 col-lg-12" id="certs">
                <h1 class="d-flex justify-content-center">
                    <?php if($certs){?><strong>Certifications</strong><?php }?>
                </h1>
            </div>
        </div>
            <?php foreach ($certs as $cert):?>
            <div class="row">
                <div class="my-margin-from-form mt-8 col-lg-12">
                    <h3><?=$cert['title']?></h3>
                    <p><?=$cert['description']?></p>
                    <div class="text-center">
                        <img src="../files/certifications/<?=$cert['imagepath']?>" class="px-4 img-fluid"/>
                    </div>
                </div>
            </div>
        <?php endforeach;?>
    </div>


        <div class="my-pd form-color container" id="contactme">
            <form action="index.php" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label ">Name</label>
                    <input name="name" type="text" class="form-control" id="name">
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label <?=!empty($email_err)? '' : 'is-invalid'?>">Email address</label>
                    <input name="email" type="email" class="form-control" id="email"/>
                    <span class="invalid-feedback"><?php echo $email_err; ?></span>
                </div>
                <div class="mb-3">
                    <label for="msg" class="form-label">E-mail</label>
                    <textarea class="form-control" name="msg" id="msg" rows="6"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</main>
<footer class="my-color">
    <div class="my-margin d-flex flex-row justify-content-center text-center">
        <div class="contact">
            <a href="https://instagram.com/<?=$aboutme['instagram']?>" target="_blank">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="40"
                    height="40"
                    fill="currentColor"
                    class="bi bi-instagram"
                    viewBox="0 0 16 16">
                    <path
                        d="M8 0C5.829 0 5.556.01 4.703.048 3.85.088 3.269.222 2.76.42a3.917 3.917 0 0 0-1.417.923A3.927 3.927 0 0 0 .42 2.76C.222 3.268.087 3.85.048 4.7.01 5.555 0 5.827 0 8.001c0 2.172.01 2.444.048 3.297.04.852.174 1.433.372 1.942.205.526.478.972.923 1.417.444.445.89.719 1.416.923.51.198 1.09.333 1.942.372C5.555 15.99 5.827 16 8 16s2.444-.01 3.298-.048c.851-.04 1.434-.174 1.943-.372a3.916 3.916 0 0 0 1.416-.923c.445-.445.718-.891.923-1.417.197-.509.332-1.09.372-1.942C15.99 10.445 16 10.173 16 8s-.01-2.445-.048-3.299c-.04-.851-.175-1.433-.372-1.941a3.926 3.926 0 0 0-.923-1.417A3.911 3.911 0 0 0 13.24.42c-.51-.198-1.092-.333-1.943-.372C10.443.01 10.172 0 7.998 0h.003zm-.717 1.442h.718c2.136 0 2.389.007 3.232.046.78.035 1.204.166 1.486.275.373.145.64.319.92.599.28.28.453.546.598.92.11.281.24.705.275 1.485.039.843.047 1.096.047 3.231s-.008 2.389-.047 3.232c-.035.78-.166 1.203-.275 1.485a2.47 2.47 0 0 1-.599.919c-.28.28-.546.453-.92.598-.28.11-.704.24-1.485.276-.843.038-1.096.047-3.232.047s-2.39-.009-3.233-.047c-.78-.036-1.203-.166-1.485-.276a2.478 2.478 0 0 1-.92-.598 2.48 2.48 0 0 1-.6-.92c-.109-.281-.24-.705-.275-1.485-.038-.843-.046-1.096-.046-3.233 0-2.136.008-2.388.046-3.231.036-.78.166-1.204.276-1.486.145-.373.319-.64.599-.92.28-.28.546-.453.92-.598.282-.11.705-.24 1.485-.276.738-.034 1.024-.044 2.515-.045v.002zm4.988 1.328a.96.96 0 1 0 0 1.92.96.96 0 0 0 0-1.92zm-4.27 1.122a4.109 4.109 0 1 0 0 8.217 4.109 4.109 0 0 0 0-8.217zm0 1.441a2.667 2.667 0 1 1 0 5.334 2.667 2.667 0 0 1 0-5.334z"
                    />
                </svg>
            </a>
        </div>
        <div class="contact">
            <a href="https://wa.me/351<?=$aboutme['whatsapp']?>" target="_blank">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="40"
                    height="40"
                    fill="currentColor"
                    class="bi bi-whatsapp"
                    viewBox="0 0 16 16">
                    <path
                        d="M13.601 2.326A7.854 7.854 0 0 0 7.994 0C3.627 0 .068 3.558.064 7.926c0 1.399.366 2.76 1.057 3.965L0 16l4.204-1.102a7.933 7.933 0 0 0 3.79.965h.004c4.368 0 7.926-3.558 7.93-7.93A7.898 7.898 0 0 0 13.6 2.326zM7.994 14.521a6.573 6.573 0 0 1-3.356-.92l-.24-.144-2.494.654.666-2.433-.156-.251a6.56 6.56 0 0 1-1.007-3.505c0-3.626 2.957-6.584 6.591-6.584a6.56 6.56 0 0 1 4.66 1.931 6.557 6.557 0 0 1 1.928 4.66c-.004 3.639-2.961 6.592-6.592 6.592zm3.615-4.934c-.197-.099-1.17-.578-1.353-.646-.182-.065-.315-.099-.445.099-.133.197-.513.646-.627.775-.114.133-.232.148-.43.05-.197-.1-.836-.308-1.592-.985-.59-.525-.985-1.175-1.103-1.372-.114-.198-.011-.304.088-.403.087-.088.197-.232.296-.346.1-.114.133-.198.198-.33.065-.134.034-.248-.015-.347-.05-.099-.445-1.076-.612-1.47-.16-.389-.323-.335-.445-.34-.114-.007-.247-.007-.38-.007a.729.729 0 0 0-.529.247c-.182.198-.691.677-.691 1.654 0 .977.71 1.916.81 2.049.098.133 1.394 2.132 3.383 2.992.47.205.84.326 1.129.418.475.152.904.129 1.246.08.38-.058 1.171-.48 1.338-.943.164-.464.164-.86.114-.943-.049-.084-.182-.133-.38-.232z"
                    />
                </svg>
            </a>
        </div>
        <div class="contact">
            <a href="https://github.com/<?=$aboutme['github']?>" target="_blank">
                <svg
                    xmlns="http://www.w3.org/2000/svg"
                    width="40"
                    height="40"
                    fill="currentColor"
                    class="bi bi-github"
                    viewBox="0 0 16 16"
                >
                    <path
                        d="M8 0C3.58 0 0 3.58 0 8c0 3.54 2.29 6.53 5.47 7.59.4.07.55-.17.55-.38 0-.19-.01-.82-.01-1.49-2.01.37-2.53-.49-2.69-.94-.09-.23-.48-.94-.82-1.13-.28-.15-.68-.52-.01-.53.63-.01 1.08.58 1.23.82.72 1.21 1.87.87 2.33.66.07-.52.28-.87.51-1.07-1.78-.2-3.64-.89-3.64-3.95 0-.87.31-1.59.82-2.15-.08-.2-.36-1.02.08-2.12 0 0 .67-.21 2.2.82.64-.18 1.32-.27 2-.27.68 0 1.36.09 2 .27 1.53-1.04 2.2-.82 2.2-.82.44 1.1.16 1.92.08 2.12.51.56.82 1.27.82 2.15 0 3.07-1.87 3.75-3.65 3.95.29.25.54.73.54 1.48 0 1.07-.01 1.93-.01 2.2 0 .21.15.46.55.38A8.012 8.012 0 0 0 16 8c0-4.42-3.58-8-8-8z"
                    />
                </svg>
            </a>
        </div>
    </div>
    <p class="text-center">&copy; 2022, José Tiago Viana</p>
</footer>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-OERcA2EqjJCMA+/3y+gxIOqMEjwtxJY7qPCqsdltbNJuaOe923+mo//f6V8Qbsw3" crossorigin="anonymous"></script>
</body>
</html>