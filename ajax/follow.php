<?php
include('../include/config.php');

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["user"])) {

    $followingId = $_POST["user"];

    if ($_POST['action'] == 'follow') {

        followUser($getId, $followingId);

        echo ("success");
    } else {
        unfollowUser($getId, $followingId);

        echo ("success");
    }
}
$pdo = null;
?>