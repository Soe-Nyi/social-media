<?php include('include/header.php'); ?>

<!------------------------------(Starts Column SEction)-------------------->

<div class="container mt-3">
    <div class="row">

        <?php include('include/leftCol.php') ?>
        <!------------------------------------------------(Satrt Middle Column)---------------------------->


        <div class="col-12 col-lg-5">

            <div class="middle-column">
                <div class="card shadow-sm">

                    <div class="card-header">
                        <h4 class="card-title">
                            Notifications
                        </h4>

                    </div>
                    <?php
                    foreach ($notifications as $notification) {
                        $notificationType = $notification->notification_type;
                        $actor = $notification->actor;
                        $actionTime = $notification->action_time;

                        // Define the icons and action text based on the notification type
                        $iconClass = '';
                        $actionText = '';

                        if ($notificationType === 'New Follower') {
                            $iconClass = 'fas fa-user-friends'; // Icon for new followers
                            $actionText = 'followed you';
                            $link = "profile.php?id=$notification->actorID";
                        } elseif ($notificationType === 'New Post') {
                            $iconClass = 'fas fa-pencil-alt'; // Icon for new posts
                            $actionText = 'posted a new post';
                            $link = "more.php?id=$notification->postID";
                        } elseif ($notificationType === 'New Reaction') {
                            $iconClass = 'fas fa-thumbs-up'; // Icon for new posts
                            $actionText = 'react to your post';
                            $link = "more.php?id=$notification->postID";
                        }

                        // Format the action time
                    
                        $now_timestamp = strtotime(date('Y-m-d H:i:s', strtotime(date('Y-m-d H:i:s')) + (4.5 * 3600)));
                        $post_timestamp = strtotime($actionTime);
                        $diff_timestamp = $now_timestamp - $post_timestamp;

                        if ($diff_timestamp < 60) {
                            $timeAgoText = 'just now';
                        } else if ($diff_timestamp >= 60 && $diff_timestamp < 3600) {
                            $minutes = round($diff_timestamp / 60);
                            $timeAgoText = ($minutes == 1) ? '1 min ago' : $minutes . ' mins ago';
                        } else if ($diff_timestamp >= 3600 && $diff_timestamp < 86400) {
                            $hours = round($diff_timestamp / 3600);
                            $timeAgoText = ($hours == 1) ? '1 hour ago' : $hours . ' hours ago';
                        } else if ($diff_timestamp >= 86400 && $diff_timestamp < (86400 * 30)) {
                            $days = round($diff_timestamp / 86400);
                            $timeAgoText = ($days == 1) ? '1 day ago' : $days . ' days ago';
                        } else if ($diff_timestamp >= (86400 * 30) && $diff_timestamp < (86400 * 365)) {
                            $months = round($diff_timestamp / (86400 * 30));
                            $timeAgoText = ($months == 1) ? '1 month ago' : $months . ' months ago';
                        } else {
                            $years = round($diff_timestamp / (86400 * 365));
                            $timeAgoText = ($years == 1) ? '1 year ago' : $years . ' years ago';
                        }
                        ?>
                        <a href="<?= $link ?>">
                            <div class="media pt-3">
                                <i class="<?= $iconClass ?> mx-2 mt-1"></i>
                                <div class="media-body">
                                    <p>
                                        <span class="h6 mr-2">
                                            <a href="profile.php?id=<?= $notification->actorID ?>" class="text-info">
                                                <?= $actor ?>
                                            </a>
                                        </span>
                                        <?= $actionText ?>
                                    </p>
                                </div>
                                <small class="mr-2 text-muted">
                                    <?= $timeAgoText ?>
                                </small>
                            </div>
                        </a>
                    <?php } ?>
                </div>


            </div>
            <br>
        </div>


        <!------------------------------------------------(End Middle Column)---------------------------->
        <?php include('include/rightCol.php') ?>


    </div>
    <?php include('include/footer.php'); ?>