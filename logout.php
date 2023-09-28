<?php
include('include/config.php');
$key = $_GET['key'];
if ($key == base64_encode($getPassword)) {
    setcookie('id', '', -1, "/");
    setcookie('email', '', -1, "/");
    setcookie('password', '', -1, "/");
}

header('location: index.php');
?>