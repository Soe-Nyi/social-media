<?php

// Retrieve user reactions for the current post (replace '123' with the actual post ID)
$reactionsQuery = $pdo->prepare("SELECT reaction_type FROM reactions WHERE post_id = ? AND user_id = ?");
$reactionsQuery->execute([$id, $getId]);
$userReactions = $reactionsQuery->fetchAll(PDO::FETCH_COLUMN);



$countReaction = $pdo->prepare("SELECT reaction_type FROM reactions WHERE post_id = ?");
$countReaction->execute([$id]);
$countReaction = $countReaction->fetchAll(PDO::FETCH_COLUMN);
$rowCount = count($countReaction);

// Initialize an array to store user reactions
$userReactionClasses = [
    'like' => '',
    'haha' => '',
    'love' => '',
    'sad' => '',
];


foreach ($userReactions as $reactionType) {
    $userReactionClasses[$reactionType] = ' clicked-' . $reactionType;
}

?>
<a href="#reacter" class="nav-link reactor" data-toggle="modal">
    <div class="react-count px-3" style="border-top: 1px solid gray;">
        <i class="fas fa-heart text-danger mr-1"></i>
        <?= $rowCount ?>
    </div>
</a>
<div class="reactions p-2">
    <button class="reaction-button btn<?= $userReactionClasses['like'] ?> btn-like" data-reaction="like" data-post-id="<?=$id?>">
        <i class="fas fa-thumbs-up"></i>
        <span class="reaction-label">Like</span>
    </button>
    <button class="reaction-button btn<?= $userReactionClasses['haha'] ?> btn-haha" data-reaction="haha" data-post-id="<?= $id ?>">
        <i class="far fa-laugh"></i>
        <span class="reaction-label">Haha</span>
    </button>
    <button class="reaction-button btn<?= $userReactionClasses['love'] ?> btn-love" data-reaction="love" data-post-id="<?= $id ?>">
        <i class="fas fa-heart"></i>
        <span class="reaction-label">Love</span>
    </button>
    <button class="reaction-button btn<?= $userReactionClasses['sad'] ?> btn-sad" data-reaction="sad" data-post-id="<?= $id ?>">
        <i class="far fa-sad-tear"></i>
        <span class="reaction-label">Sad</span>
    </button>
</div>

<!-- who react -->



<div class="modal fade" id="reacter">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <div class="modal-title h5">People who reacted</div>
                <button type="button" class="close p-1 m-1" data-dismiss="modal">&times;</button>
            </div>
            <div class="modal-body p-0">
                <?php
                $query = $pdo->prepare("SELECT
                                            users.id AS userid,
                                            users.profile AS userprofile,
                                            users.name AS username,
                                            reactions.reaction_type AS react_type
                                        FROM
                                            reactions
                                        INNER JOIN
                                            users
                                        ON
                                            reactions.user_id = users.id
                                        WHERE reactions.post_id = ?");

                $query->execute([$id]);
                $reactions = $query->fetchAll(PDO::FETCH_OBJ);

                // Display the data in a list
                
                foreach ($reactions as $reaction) {
                    echo '<ul class="list-unstyled bg-secondary p-2" style="border-bottom: 1px solid white;">';
                    echo '<li>';
                    echo '<div class="d-flex justify-content-between">';
                    echo '<a href="profile.php?id=' . $reaction->userid . '" class="">';
                    echo '<img src="profile/' . $reaction->userprofile . '" width="40" height="40" class="rounded-circle mr-3">'; // Display user profile
                    echo '<span class="mr-auto h6 mt-2 text-white">' . $reaction->username . '</span>';
                    echo '</a>';
                    // Display react icon based on $reaction->react_type
                    switch ($reaction->react_type) {
                        case 'like':
                            echo '<div class="ml-auto"><i class="fas fa-thumbs-up text-primary mr-2 mt-2" style="font-size: 20px;"></i></div>';
                            break;
                        case 'haha':
                            echo '<div class="ml-auto"><i class="far fa-laugh text-warning mr-2 mt-2" style="font-size: 20px;"></i></div>';
                            break;
                        case 'love':
                            echo '<div class="ml-auto"><i class="fas fa-heart text-danger mr-2 mt-2" style="font-size: 20px;"></i></div>';
                            break;
                        case 'sad':
                            echo '<div class="ml-auto"><i class="fas fa-sad-tear text-warning mr-2 mt-2" style="font-size: 20px;"></i></div>';
                            break;

                    }
                    echo '</div>';
                    echo '</li>';
                    echo '</ul>';
                }

                ?>
            </div>
        </div>
    </div>
</div>