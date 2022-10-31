<?php
session_start();
require __DIR__ . "/../vendor/autoload.php";

use Src\Users;

if (!isset($_POST['id'])) {
    header("Location:main.php");
    die();
}
$id = $_POST['id'];
if (!(new Users)->existeId($id)) {
    header("Location:main.php");
    die();
}
(new Users)->delete($id);
$_SESSION['txt'] = "Registro Borrado con éxito";
header("Location:main.php");
