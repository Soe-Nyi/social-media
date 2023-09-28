<?php include('include/header.php'); ?>


<!-------------------------------------------Start Grids layout for lg-xl-3 columns and (xs-lg 1 columns)--------------------------------->

<div class="container">
    <div class="row">
        <?php include('include/leftCol.php') ?>

        <!---------------------------------------Middle columns  start---------------->

        <div class="col-12 col-lg-5">

            <div class="middle-column">

                <div class="card">

                    <div class="card-header">
                        <form id="postForm" enctype="multipart/form-data">

                            <div class="row">
                                <div class="col-10 pr-1">

                                    <textarea name="postContent" id="postContent" class="form-control form-control-md"
                                        placeholder="Enter text" request></textarea>
                                </div>

                                <div class="col-2 px-0">

                                    <input type="file" name="postImage" id="image-input"
                                        accept="image/png, image/jpg, image/wepb" style="display: none;">

                                    <button type="button" class="btn btn-sm btn-primary input-group-text mb-1"
                                        onclick="document.getElementById('image-input').click();">

                                        <i class="fas fa-camera"></i>
                                    </button>

                                    <button type="submit" class="btn btn-sm btn-success input-group-text">
                                        <i class="fas fa-paper-plane"></i>
                                    </button>

                                </div>
                            </div>
                            <div class="row text-center" id="image-container">
                                <img src="" id="selected-image" style="max-width: 100%; max-height: 200px;" class="m-3">
                            </div>
                        </form>
                    </div>

                    <div id="loadingSpinner" class="spinner-border text-danger" role="status" style="display: none;">
                        <span class="visually-hidden"></span>
                    </div>

                    <div class="card-body" id="postContainer">

                        <?php
                        if (!empty($_GET['s'])) {
                            $search = htmlspecialchars(urlencode($_GET['s']));
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

                            $stmt = $pdo->prepare("SELECT
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
                                                        users.name LIKE CONCAT('%', ?, '%') OR posts.content LIKE CONCAT('%', ?, '%')
                                                    ORDER BY RAND() LIMIT 20");
                            $stmt->execute([$search, $search]);
                            $posts = $stmt->fetchAll(PDO::FETCH_OBJ);

                            foreach ($posts as $allpost) {
                                $id = $allpost->id;
                                ?>
                                <input type="hidden" data-id="<?= $id ?>">
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

                                        <p class="card-text text-justify">
                                            <?= $truncatedText ?>
                                            <?php
                                            if ($showMoreLink) { ?>
                                                <a href="more.php?id=<?= $allpost->id ?>"
                                                    class="text-decoration-none text-primary">...See
                                                    More</a>
                                            <?php }
                                            ?>
                                        </p>
                                        <div class="row no-gutters mb-3">
                                            <div class="p-1 text-center">
                                                <a href="profile.php?<?= $allpost->id ?>">
                                                    <img src="img/<?= $allpost->image ?>" alt="" class="img-fluid mb-2"></a>
                                            </div>
                                        </div>
                                    </div>
                                    <small>
                                        <?= timeAgo($allpost->created_at) ?>
                                    </small>
                                </div>
                                <?php include('include/reaction.php'); ?>
                                <hr>

                                <?php
                            }
                        } ?>
                    </div>
                </div>
            </div>
        </div>
        <br>

        <!------------------------Middle column Ends---------------->

        <?php include('include/rightCol.php') ?>
        <script>

            document.getElementById('image-input').addEventListener('change', function () {
                const imageContainer = document.getElementById('image-container');
                const selectedImage = document.getElementById('selected-image');

                if (this.files && this.files[0]) {
                    const reader = new FileReader();

                    reader.onload = function (e) {
                        selectedImage.src = e.target.result;
                        imageContainer.style.display = 'block';
                    };

                    reader.readAsDataURL(this.files[0]);
                }
            });
        </script>

        <!-- ajax for fetch_data -->

        <script>
            $(document).ready(function () {

                $('#postForm').submit(function (e) {
                    var content = $('#postContent').val();
                    var image = $('#image-input').val();


                    e.preventDefault();

                    var formData = new FormData(this);

                    if (content.trim() !== '' || image.trim() !== '') {

                        $.ajax({
                            type: 'POST',
                            url: 'ajax/upload_post.php',
                            data: formData,
                            processData: false,
                            contentType: false,
                            success: function (response) {
                                $('#postContent').val('');
                                $('#image-input').val('');
                                $('#selected-image').hide();
                                console.log('Response from server:', response);
                                fetchAndDisplayPosts();
                            }
                        });
                    }
                });
                <?php
                if (empty($_GET['s'])) {
                    ?>

                    function fetchAndDisplayPosts() {

                        $('#loadingSpinner').show();

                        $.ajax({
                            type: 'GET',
                            url: 'ajax/fetch_data.php',
                            success: function (response) {

                                $('#loadingSpinner').hide();


                                $('#postContainer').html(response);
                                initializeReactionButtons();
                            },
                            error: function () {

                                $('#loadingSpinner').hide();


                                $('#postContainer').html('Error loading posts.');
                            }
                        });
                    }

                    fetchAndDisplayPosts();
                <?php } ?>
            });

        </script>

    </div>


    <!------------------------Light BOx OPtions------------->

    <?php $pdo = null; ?>
    <?php include('include/footer.php'); ?>