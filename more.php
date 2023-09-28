<?php include('include/header.php') ?>

<?php

if (!empty($_GET['id'])) {


    $id = (INT) $_GET['id'];

    // Get Single Post

    $stmt = $pdo->prepare("
        SELECT
            posts.*,
            users.profile AS user_profile,
            users.name AS user_name
        FROM
            posts
        INNER JOIN
            users
        ON
            posts.usr_id = users.id
        WHERE
            posts.id = ?
");
    $stmt->execute([$id]);
    $postRow = $stmt->fetch(PDO::FETCH_OBJ);

    if ($postRow) {


        function timeAgo($date)
        {
            $now_timestamp = strtotime(date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + (4.5 * 3600)));
            $post_timestamp = strtotime($date);
            $diff_timestamp = $now_timestamp - $post_timestamp;

            if ($diff_timestamp < 60) {
                return 'just now';
            } else if ($diff_timestamp >= 60 && $diff_timestamp < 3600) {
                $minutes = round($diff_timestamp / 60);
                return ($minutes == 1) ? '1 min ago' : $minutes . ' mins ago';
            } else if ($diff_timestamp >= 3600 && $diff_timestamp < 86400) {
                $hours = round($diff_timestamp / 3600);
                return ($hours == 1) ? '1 hour ago' : $hours . ' hours ago';
            } else if ($diff_timestamp >= 86400 && $diff_timestamp < (86400 * 30)) {
                $days = round($diff_timestamp / 86400);
                return ($days == 1) ? '1 day ago' : $days . ' days ago';
            } else if ($diff_timestamp >= (86400 * 30) && $diff_timestamp < (86400 * 365)) {
                $months = round($diff_timestamp / (86400 * 30));
                return ($months == 1) ? '1 month ago' : $months . ' months ago';
            } else {
                $years = round($diff_timestamp / (86400 * 365));
                return ($years == 1) ? '1 year ago' : $years . ' years ago';
            }
        }

        ?>

        <div class="container pb-5">
            <div class="row">
                <div class="col">
                    <div class="card">
                        <div class="card-header">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <input type="hidden" data-id="<?= $id ?>">
                                    <a href="profile.php?id=<?= $postRow->usr_id ?>"
                                        class="text-decoration-none d-flex align-items-center">
                                        <img src="profile/<?= $postRow->user_profile ?>" width="50px" height="50px"
                                            class="rounded-circle mr-3">
                                        <h3>
                                            <?= $postRow->user_name ?>
                                        </h3>
                                    </a>
                                </div>
                                <div class="ml-auto">
                                    <small>
                                        <?= timeAgo($postRow->created_at) ?>
                                    </small>
                                </div>
                            </div>
                        </div>


                        <div class="card-body">


                            <div class="media">

                                <div class="media-body mt-3">

                                    <p class="card-text text-justify">

                                        <?= $postRow->content ?>

                                    </p>


                                    <div class="row no-gutters mb-3">
                                        <div class="p-1 text-center">

                                            <a href="img/<?= $postRow->image ?>" data-lightbox="id"><img
                                                    src="img/<?= $postRow->image ?>" alt="" class="img-fluid mb-2"
                                                    style="min-height: 200px;max-height:400px;min-width:500px"></a>

                                        </div>

                                    </div>

                                </div>
                            </div>

                            <?php include('include/reaction.php') ?>

                        </div>

                    </div>
                </div>
            </div>
        </div>





        <?php
        $pdo = null;
    } else {
        include('include/404.php');
    }
} else {
    include('include/404.php');
}
?>


<?php include('include/footer.php') ?>