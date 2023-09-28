<?php include('include/header.php') ?>

<body>
    <div class="container mt-4">

        <form action="users.php" class="form-inline ml-auto float-right" method="GET">
            <input type="text" name="s" id="search" placeholder="Search" class="form-control form-control-sm">
        </form>
        <h3>Suggesstion</h3>
        <div class="row mt-4">
            <!-- Users -->

            <?php
            if (empty($_GET['s'])) {
                $stmt = $pdo->prepare("SELECT DISTINCT u.*
                                            FROM users u
                                        LEFT JOIN followers f1 ON u.id = f1.follower_id
                                            LEFT JOIN followers f2 ON u.id = f2.following_id
                                        WHERE (f1.following_id = ? OR f2.follower_id = ? OR f1.following_id IS NULL)
                                            AND u.id != ?
                                        ORDER BY RAND() LIMIT 200");
                $stmt->execute([$getId, $getId, $getId]);
                $users = $stmt->fetchAll(PDO::FETCH_OBJ);
            } else {
                $search = $_GET['s'];
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id !=? && (name LIKE CONCAT('%', ?, '%') || bio LIKE CONCAT('%', ?, '%')) ORDER BY RAND() LIMIT 100");
                $stmt->execute([$getId, $search, $search]);
                $users = $stmt->fetchAll(PDO::FETCH_OBJ);
            }

            foreach ($users as $user): ?>
                <div class="col-lg-6 p-3 rounded py-auto mt-3" style="border: 0.2px solid white">
                    <div class="row">
                        <div class="col-2">
                            <a href="profile.php?id=<?= $user->id ?>">
                                <img src="profile/<?= $user->profile ?>" alt="<?= $user->name ?>"
                                    class="img-fluid rounded-circle" style="width: 60px; height: 60px;">
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="profile.php?id=<?= $user->id ?>" class="text-decoration-none">
                                <h5 style="font-weight:bold;" class="">
                                    <?= $user->name ?>
                                </h5>
                                <p>
                                    <?= $user->bio ?>
                                </p>
                            </a>
                        </div>
                        <div class="col-4">
                            <?php

                            $checkQuery = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ? AND following_id = ?");
                            $checkQuery->execute([$getId, $user->id]);

                            if ($checkQuery->rowCount() == 1) {

                                $isFollowing = true;
                            } else {
                                $isFollowing = false;
                            }
                            if ($isFollowing) {
                                echo '<button class="btn btn-outline-info btn-sm mt-1 unfollow-button" data-user="' . $user->id . '"><i class="fas fa-user-friends"></i> Following</button>';
                            } else {
                                echo '<button class="btn btn-outline-info btn-sm mt-1 follow-button" data-user="' . $user->id . '"><i class="fas fa-user-friends"></i> Follow</button>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>



        </div>
    </div>

    <?php $pdo = null; ?>
    <?php include('include/footer.php') ?>