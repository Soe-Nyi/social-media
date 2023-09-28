<?php

include('../include/config.php');

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


$stmt = $pdo->prepare("(SELECT
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
                            posts.usr_id IN (
                                SELECT following_id
                                FROM followers
                                WHERE follower_id = ?
                            )
                    )
                    UNION ALL
                    (
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
                            posts.usr_id NOT IN (
                                SELECT following_id
                                FROM followers
                                WHERE follower_id = ?
                            )
                    )
                    ORDER BY
                        RAND()
                    LIMIT 20;");
$stmt->execute([$getId, $getId]);
$posts = $stmt->fetchAll(PDO::FETCH_OBJ);


foreach ($posts as $allpost) {
    $id = $allpost->id;
    ?>
    <div class="media">
        <a href="profile.php?id=<?= $allpost->usr_id ?>" class="">
            <img src="profile/<?= $allpost->user_profile ?>" alt="img" width="45px" height="45px"
                class="rounded-circle mr-3">
        </a>
        <div class="media-body mt-1">
            <a href="profile.php?id=<?= $allpost->usr_id ?>" class="text-decoration-none">
                <h5>
                    <?= $allpost->user_name ?>
                </h5>
            </a>
            <?php
            $longText = $allpost->content;

            $maxTextLength = 200;

            if (strlen($longText) > $maxTextLength) {
                $truncatedText = substr($longText, 0, $maxTextLength);
                $showMoreLink = true;
            } else {
                $truncatedText = $longText;
                $showMoreLink = false;
            }
            ?>

            <a href="more.php?id=<?= $allpost->id ?>" class="text-decoration-none">
                <p class="card-text text-justify mt-4 py-3"
                    style="border-top: 1px solid gray;border-bottom: 1px solid gray;">
                    <?= $truncatedText ?>
            </a>
            <?php
            if ($showMoreLink) { ?>
                <a href="more.php?id=<?= $allpost->id ?>" class="text-decoration-none">...See More</a>
            <?php }
            ?>
            </p>
            <div class="row no-gutters mb-3">
                <div class="p-1 text-center">
                    <a href="more.php?id=<?= $allpost->id ?>"><img src="img/<?= $allpost->image ?>" alt=""
                            class="img-fluid mb-2"></a>
                </div>
            </div>
        </div>
        <small>
            <?= timeAgo($allpost->created_at) ?>
        </small>
    </div>
    <?php include('../include/reaction.php'); ?>
    <hr>

    <?php
}
$pdo = null;
?>