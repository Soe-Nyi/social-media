<?php
include('../include/config.php');


if (isset($_POST['message'])) {
    $message = trim(htmlspecialchars($_POST['message']));

    // Insert the new message into the database (customize as per your database structure)
    $query = "INSERT INTO messages (usr_id, message) VALUES (?, ?)";
    $stmt = $pdo->prepare($query);
    $stmt->execute([$getId, $message]);
}

?>