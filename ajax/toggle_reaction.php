<?php
include('../include/config.php');

$postId = (INT) $_POST['postId'];
$reactionType = $_POST['reactionType'];

// Check if the user has already reacted to the post
$checkQuery = $pdo->prepare("SELECT * FROM reactions WHERE post_id = ? AND user_id = ?");
$checkQuery->execute([$postId, $getId]);

$checkUpdate = $checkQuery->fetch(PDO::FETCH_OBJ);

if ($checkQuery->rowCount() > 0) {

    if ($checkUpdate->reaction_type == $reactionType) {

        // User has already reacted, so remove the reaction
        $deleteQuery = $pdo->prepare("DELETE FROM reactions WHERE post_id = ? AND user_id = ? AND reaction_type = ?");
        $deleteQuery->execute([$postId, $getId, $reactionType]);
        echo ('removed');
    } else {
        $updateQuery = $pdo->prepare("UPDATE `reactions` SET reaction_type = ? WHERE post_id = ? AND user_id = ?");
        $updateQuery->execute([$reactionType, $postId, $getId]);
    }
} else {
    // User has not reacted, so add the reaction
    $insertQuery = $pdo->prepare("INSERT INTO reactions (post_id, user_id, reaction_type) VALUES (?, ?, ?)");
    $insertQuery->execute([$postId, $getId, $reactionType]);
}

$pdo = null;
?>