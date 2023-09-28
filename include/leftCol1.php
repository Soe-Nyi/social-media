<?php
$countFollower = $pdo->prepare("SELECT * FROM followers WHERE following_id = ?");
$countFollower->execute([$getId]);
$countFollower = $countFollower->fetchAll(PDO::FETCH_COLUMN);
$rowCountFollower = count($countFollower);


$countFollowing = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ?");
$countFollowing->execute([$getId]);
$countFollowing = $countFollowing->fetchAll(PDO::FETCH_COLUMN);
$rowCountFollowing = count($countFollowing);

?>
<!--------------------------left columns  start-->

<div class="col-12 col-lg-3">

    <div class="left-column">


        <div class="card card-left1 mb-4">
            <img src="cover/<?= $getCover ?>" style="max-height: 160px;background-color: #575757;" alt=""
                class="card-img-top img-fluid">
            <div class="card-body text-center">
                <a href="profile.php?id=<?= $getId ?>"><img src="profile/<?= $getProfile ?>" width="110px"
                        height="110px" class="rounded-circle mt-n5"></a>
                <h5 class="card-title mt-2">
                    <?= $getName ?>
                </h5>
                <p>
                    <?= $getBio ?>
                </p>
                <ul class="list-unstyled nav justify-content-center">
                    <a href="#" class="text-decoration-none mx-3">
                        <li class="nav-item">Follower <br> <strong>
                                <?= $rowCountFollower ?>
                            </strong></li>
                    </a>
                    <a href="#" class="text-decoration-none mx-3">
                        <li class="nav-item">Following <br> <strong>
                                <?= $rowCountFollowing ?>
                            </strong></li>
                    </a>
                </ul>
            </div>
        </div>


        <div class="card shadow-sm card-left3 mb-4 d-none d-lg-block">

            <div class="card-body">
                <h5 class="card-title">Photos<small class="ml-2"><a href="profile.php?id=<?=$getId?>"> More</a></small></h5>

                <div class="row">

                    <?php

                    $stmt = $pdo->prepare("SELECT image FROM posts WHERE usr_id = ?");
                    $stmt->execute([$getId]);
                    $imgrow = $stmt->fetchAll(PDO::FETCH_OBJ);

                    if ($stmt->rowCount() > 0) {
                        foreach ($imgrow as $img) {
                            if ($img->image !== null) {
                                ?>
                                <div class="col-lg-6 p-1">
                                    <a href="img/<?= $img->image ?>" data-lightbox="id"><img src="img/<?= $img->image ?>"
                                            class="img-fluid my-2"></a>
                                </div>
                            <?php }
                        }
                    } ?>

                </div>

            </div>

        </div>
    </div>
</div>

<!--------------------------Ends Left columns-->