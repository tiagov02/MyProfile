<?php
pdo_connect_mysql();
function pdo_connect_mysql() {
    $DATABASE_HOST = 'localhost';
    $DATABASE_USER = 'sir';
    $DATABASE_PASS = 'Trab2SRS_ESTGIPVC#';
    $DATABASE_NAME = 'sir';
    try {
        return new PDO('mysql:host=' . $DATABASE_HOST . ';dbname='
            . $DATABASE_NAME . ';charset=utf8', $DATABASE_USER, $DATABASE_PASS);
    }
    catch (PDOException $exception)
    {

        exit($exception->getMessage());
    }
}
?>
