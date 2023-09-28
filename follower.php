<?php include('include/header.php'); ?>
<?php

if (empty($_GET['s'])) {

    if (empty($_GET['id']) && isset($getId)) {
        $id = $getId;
    } else {
        $id = (INT) $_GET['id'];
    }
    $stmt = $pdo->prepare("SELECT
                                followers.*,
                                users.*
                            FROM
                                followers
                            INNER JOIN
                                users
                            ON
                                followers.follower_id = users.id
                            WHERE
                                followers.following_id = ?
                            ORDER BY ID DESC");
    $stmt->execute([$id]);
    $followers = $stmt->fetchAll(PDO::FETCH_OBJ);

} else {
    $search = $_GET['s'];

    if (empty($_GET['id']) && isset($getId)) {
        $id = $getId;
    } else {
        $id = (INT) $_GET['id'];
    }
    $stmt = $pdo->prepare("SELECT
                                followers.*,
                                users.*
                            FROM
                                followers
                            INNER JOIN
                                users
                            ON
                                followers.follower_id = users.id
                            WHERE
                                followers.following_id = ? && (name LIKE CONCAT('%', ?, '%') || bio LIKE CONCAT('%', ?, '%'))
                            ORDER BY ID DESC");
    $stmt->execute([$id, $search, $search]);
    $followers = $stmt->fetchAll(PDO::FETCH_OBJ);

}

?>

<body>
    <div class="container mt-4">

        <form action="follower.php<?php if (!empty($id)) { ?>?id=<?= $id ?>&<?php } ?>"
            class="form-inline ml-auto float-right" method="GET">
            <input type="text" name="s" id="search" placeholder="Search" class="form-control form-control-sm">
        </form>
        <h5>Followers</h5>
        <div class="row mt-4">
            <!-- Users -->

            <?php foreach ($followers as $follower): ?>
                <div class="col-lg-6 p-3 rounded pb-0" style="border: 0.2px solid white">
                    <div class="row">
                        <div class="col-2">
                            <a href="profile.php?id=<?= $follower->id ?>">
                                <img src="profile/<?= $follower->profile ?>" alt="<?= $follower->name ?>"
                                    class="img-fluid rounded-circle" style="max-width: 60px; max-height: 60px;">
                            </a>
                        </div>
                        <div class="col-6">
                            <a href="profile.php?id=<?= $follower->id ?>" class="text-decoration-none">
                                <h5 style="font-weight:bold;" class="">
                                    <?= $follower->name ?>
                                </h5>
                                <p>
                                    <?= $follower->bio ?>
                                </p>
                            </a>
                        </div>
                        <div class="col-4">
                            <?php

                            $checkQuery = $pdo->prepare("SELECT * FROM followers WHERE follower_id = ? AND following_id = ?");
                            $checkQuery->execute([$getId, $follower->id]);

                            if ($checkQuery->rowCount() == 1) {

                                $isFollowing = true;
                            } else {
                                $isFollowing = false;
                            }
                            if ($isFollowing) {
                                echo '<button class="btn btn-outline-info btn-sm mt-1 unfollow-button" data-user="' . $follower->id . '"><i class="fas fa-user-friends"></i> Following</button>';
                            } else {
                                echo '<button class="btn btn-outline-info btn-sm mt-1 follow-button" data-user="' . $follower->id . '"><i class="fas fa-user-friends"></i> Follow</button>';
                            }
                            ?>
                        </div>
                    </div>
                </div>

            <?php endforeach ?>



        </div>
    </div>

    <script>
        $(document).ready(function () {

            $(".follow-button").click(function () {
                var user = $(this).data("user");

                $.ajax({
                    type: "POST",
                    url: "ajax/follow.php",
                    data: { user: user, action: 'follow' },
                    success: function (response) {

                        if (response === "success") {
                            $(".follow-button[data-user='" + user + "']")
                                .removeClass("follow-button")
                                .addClass("unfollow-button")
                                .html('<i class="fas fa-user-friends"></i> Following');
                        }
                    }
                });
            });


            $(".unfollow-button").click(function () {
                var user = $(this).data("user");

                $.ajax({
                    type: "POST",
                    url: "ajax/follow.php",
                    data: { user: user, action: 'unfollow' },
                    success: function (response) {


                        if (response === "success") {
                            $(".unfollow-button[data-user='" + user + "']")
                                .removeClass("unfollow-button")
                                .addClass("follow-button")
                                .html('<i class="fas fa-user-friends"></i> Follow');
                        }
                    }
                });
            });
        });
    </script>

    <?php $pdo = null; ?>
    <?php include('include/footer.php') ?>