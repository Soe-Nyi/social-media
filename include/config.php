<?php
session_start();
$pdo = new PDO('mysql:host=localhost;dbname=social-media', 'root', '');
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (isset($_COOKIE['id']) && isset($_COOKIE['email']) && isset($_COOKIE['password'])) {

    // Get User Data

    $id = $_COOKIE['id'];
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];

    $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ? && email = ? && password = ?");
    $stmt->execute([$id, $email, $password]);
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    $getId = $row->id;
    $getEmail = $row->email;
    $getName = $row->name;
    $getProfile = $row->profile;
    $getCover = $row->cover;
    $getBio = $row->bio;
    $getPassword = $row->password;


    // Get Random User Data

    $id = $_COOKIE['id'];
    $email = $_COOKIE['email'];
    $password = $_COOKIE['password'];

    $stmt = $pdo->prepare("SELECT * FROM users ORDER BY RAND()");
    $stmt->execute([]);
    $row = $stmt->fetch(PDO::FETCH_OBJ);

    $RandUserId = $row->id;
    $RandUserEmail = $row->email;
    $RandUserName = $row->name;
    $RandUserProfile = $row->profile;
    $RandUserCover = $row->cover;
    $RandUserBio = $row->bio;
    $RandUserPassword = $row->password;


    // Check Login Security

    if ($id != $getId && $email != $getEmail && $password != $getPassword) {

        setcookie('id', '', -1, "/");
        setcookie('email', '', -1, "/");
        setcookie('password', '', -1, "/");

        header('location: index.php');

        $pdo = null;
    }



    // Function to follow another user
    function followUser($followerId, $followingId)
    {
        global $pdo;

        // Check if the follow relationship already exists
        $checkQuery = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ? AND following_id = ?");
        $checkQuery->execute([$followerId, $followingId]);

        if ($checkQuery->rowCount() == 0) {
            // Insert the follow relationship
            $insertQuery = $pdo->prepare("INSERT INTO followers (follower_id, following_id) VALUES (?, ?)");
            $insertQuery->execute([$followerId, $followingId]);
        }
    }

    // Function to unfollow another user
    function unfollowUser($followerId, $followingId)
    {
        global $pdo;

        // Check if the follow relationship already exists
        $checkQuery = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ? AND following_id = ?");
        $checkQuery->execute([$followerId, $followingId]);

        if ($checkQuery->rowCount() == 1) {
            // Insert the follow relationship
            $insertQuery = $pdo->prepare("DELETE FROM followers WHERE follower_id = ? AND following_id = ?");
            $insertQuery->execute([$followerId, $followingId]);
        }
    }


    // Function to get notifications for a user
    function getNotifications($userId)
    {
        global $pdo;

        // Select posts by users the current user is following
        $notificationQuery = $pdo->prepare("SELECT 'New Follower' AS notification_type, u.id AS actorID, u.name AS actor, NULL AS postID, f.timestamp AS action_time
                                                FROM followers f
                                            JOIN users u ON u.id = f.follower_id
                                                WHERE f.following_id = ? 
                                            UNION ALL
                                                SELECT 'New Post' AS notification_type, u.id AS actorID, u.name AS actor, p.id AS postID, p.created_at AS action_time
                                            FROM posts p
                                                JOIN followers f ON p.usr_id = f.following_id
                                            JOIN users u ON u.id = p.usr_id
                                                WHERE f.follower_id = ?
                                            UNION ALL
                                                SELECT 'New Reaction' AS notification_type, r.user_id AS actorID, u.name AS actor, r.post_id AS postID, r.timestamp AS action_time
                                            FROM reactions r
                                                JOIN users u ON u.id = r.user_id
                                            WHERE r.post_id IN (SELECT id FROM posts WHERE usr_id = ?) && r.user_id != ?
                                                ORDER BY action_time DESC;");
        $notificationQuery->execute([$userId, $userId, $userId, $userId]);

        return $notificationQuery->fetchAll(PDO::FETCH_OBJ);
    }
    $notifications = getNotifications($getId);









}

?>