<?php include('include/header.php') ?>


<?php

if (empty($_GET['id'])) {
        // Query to fetch a single user by Cookie

        $usrStmt = $pdo->prepare("SELECT * FROM users WHERE users.id = ? && users.email = ? && users.password = ?");
        $usrStmt->execute([$getId, $getEmail, $getPassword,]);
        $usrRow = $usrStmt->fetch(PDO::FETCH_OBJ);

        // Query to fetch all posts by the user
        $postsStmt = $pdo->prepare("SELECT * FROM posts WHERE usr_id = ?");
        $postsStmt->execute([$getId]);
        $postsRows = $postsStmt->fetchAll(PDO::FETCH_OBJ);

} else {
        $id = (INT) $_GET['id'];

        // Query to fetch a single user by ID

        $usrStmt = $pdo->prepare("SELECT * FROM users WHERE users.id = ?");
        $usrStmt->execute([$id]);
        $usrRow = $usrStmt->fetch(PDO::FETCH_OBJ);

        // Query to fetch all posts by the user
        $postsStmt = $pdo->prepare("SELECT * FROM posts WHERE usr_id = ?");
        $postsStmt->execute([$id]);
        $postsRows = $postsStmt->fetchAll(PDO::FETCH_OBJ);

}


$countFollower = $pdo->prepare("SELECT * FROM followers WHERE following_id = ?");
$countFollower->execute([$id]);
$countFollower = $countFollower->fetchAll(PDO::FETCH_COLUMN);
$rowCountFollower = count($countFollower);


$countFollowing = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ?");
$countFollowing->execute([$id]);
$countFollowing = $countFollowing->fetchAll(PDO::FETCH_COLUMN);
$rowCountFollowing = count($countFollowing);


if ($usrRow) {
        ?>

        <!-----------------------------------Banner/img Starts-------------------->
        <style>
                .banner {
                        margin-top: -1.5rem;
                        background-image: url(cover/<?= $usrRow->cover ?>);
                        background-repeat: no-repeat;
                        background-size: cover;
                        background-position: center;
                        height: 500px;
                        background-color: #575757;

                }
        </style>

        <div class="banner">
                <div class="banner-title text-light d-flex flex-column text-center justify-content-center align-items-center">
                        <div class="container">
                                <div class="row">
                                        <div class="col-12">
                                                <img src="profile/<?= $usrRow->profile ?>" class="rounded-circle" width="150px"
                                                        height="150px">
                                        </div>
                                </div>
                                <div class="row mt-2">
                                        <div class="col-12">
                                                <h2 class="">
                                                        <?= $usrRow->name ?>
                                                </h2>
                                        </div>
                                </div>
                                <div class="row my-1">
                                        <div class="col-12">
                                                <?php
                                                if (!empty($id) && $id != $getId) {
                                                        $checkQuery = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ? AND following_id = ?");
                                                        $checkQuery->execute([$getId, $usrRow->id]);

                                                        if ($checkQuery->rowCount() == 1) {

                                                                $isFollowing = true;
                                                        } else {
                                                                $isFollowing = false;
                                                        }
                                                        if ($isFollowing) {
                                                                echo '<button class="btn btn-outline-info btn-sm unfollow-button" data-user="' . $usrRow->id . '"><i class="fas fa-user-friends"></i> Following</button>';
                                                        } else {
                                                                echo '<button class="btn btn-outline-info btn-sm follow-button" data-user="' . $usrRow->id . '"><i class="fas fa-user-friends"></i> Follow</button>';
                                                        }
                                                } else {
                                                        echo '<a href="setting.php"><button class="btn btn-outline-primary btn-sm"><i class="fas fa-pencil-alt mr-2"></i> Edit</button></a>';
                                                }
                                                ?>
                                        </div>
                                </div>
                                <div class="row">
                                        <div class="col-12">
                                                <p class="text-light">
                                                        <?= $usrRow->bio ?>
                                                </p>

                                                <ul class="list-unstyled nav justify-content-center h5">
                                                        <a href="follower.php?id=<?= $usrRow->id ?>" class="text-light mx-4">
                                                                <li class="nav-item">Follower <br> <strong>
                                                                                <?= $rowCountFollower ?>
                                                                        </strong></li>
                                                        </a>
                                                        <a href="following.php?id=<?= $usrRow->id ?>" class="text-light mx-4">
                                                                <li class="nav-item">Following <br> <strong>
                                                                                <?= $rowCountFollowing ?>
                                                                        </strong></li>
                                                        </a>
                                                </ul>
                                        </div>
                                </div>
                        </div>
                </div>
        </div>

        <!--------------------Post Images----------------->


<div class="grid-template container my-4">

        <?php foreach ($postsRows as $post):
                if ($post->image !== null) { ?>

        <div class="text-right">
                <a href="img/<?= $post->image ?>" data-lightbox="id"><img src="img/<?= $post->image ?>"
                                class="img-fluid mb-2" style="max-width:600px; height: 255px;"></a>

                <a href="more.php?id=<?= $post->id ?>" class="ml-auto mx-2"><i class="fas fa-eye fa-lg"> View
                                Post</i></a>
        </div>

        <?php }endforeach ?>

</div>

<?php

                $pdo = null;
} else {
        include('include/404.php');
}
?>


<?php include('include/footer.php'); ?>