<!---------------------------Statrs Right Columns----------------->

<div class="col-12 col-lg-4">


    <div class="right-column">

        <div class="card shadow-sm mb-4">

            <div class="card-body p-3">

                <h6 class="card-title ">Users <a href="users.php" class="ml-1"><small>.View All</small> </a>
                </h6>

                <?php
                $stmt = $pdo->prepare("SELECT * FROM users WHERE id !=? ORDER BY RAND() LIMIT 10");
                $stmt->execute([$getId]);
                $users = $stmt->fetchAll(PDO::FETCH_OBJ);

                foreach ($users as $user):
                    ?>

                <div class="row no-gutters d-none d-lg-flex">

                    <div class="col-2 p-1">
                        <a href="profile.php?id=<?= $user->id ?>" >
                            <img src="profile/<?= $user->profile ?>" alt="<?= $user->name ?>" alt="img" width="40px"
                                height="40px" class="rounded-circle mb-4">
                        </a>
                    </div>
                    <div class="col-6 p-1 text-left">
                        <a href="profile.php?id=<?= $user->id ?>" class="text-decoration-none">
                            <p>
                                <?= $user->name ?>
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

                <?php endforeach ?>

            </div>
        </div>

    </div>
</div>


<!--------------------------Ends Right columns-->