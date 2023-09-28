<?php
include('../include/config.php');


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_COOKIE['id'])) {

    $userId = $_COOKIE['id'];

    
    if (isset($_FILES['postImage']) && $_FILES['postImage']['error'] === UPLOAD_ERR_OK) {
        
        $uploadDir = '../img/';

        
        $imageType = exif_imagetype($_FILES['postImage']['tmp_name']);

        
        $allowedImageTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG];

        if (in_array($imageType, $allowedImageTypes)) {
            
            $imageFileName = uniqid() . '_' . $_FILES['postImage']['name'];
            $imagePath = $uploadDir . $imageFileName;

            
            if (move_uploaded_file($_FILES['postImage']['tmp_name'], $imagePath)) {
                
                $postContent = htmlspecialchars(trim($_POST['postContent']));

                $stmt = $pdo->prepare("INSERT INTO posts (usr_id, content, image) VALUES (?, ?, ?)");
                $stmt->execute([$userId, $postContent, $imageFileName]);

            } else {
                
                $error = error_get_last();
                echo 'Error uploading file: ' . $error['message'];
            }
        } else {
            echo 'Invalid image type. Only JPEG and PNG are allowed.';
        }
    } else {
        $postContent = htmlspecialchars(trim($_POST['postContent']));

        $stmt = $pdo->prepare("INSERT INTO posts (usr_id, content) VALUES (?, ?)");
        $stmt->execute([$userId, $postContent]);
    }

    $pdo = null;
} else {
    echo 'Invalid request';
}
?>