<!-- For Follow Btn -->

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


<!-- for reaction -->

<script>

    function initializeReactionButtons() {
        $(document).ready(function () {
            $('.reaction-button.btn').click(function () {

                $('.reaction-button.btn').removeClass(function (index, className) {
                    return (className.match(/(^|\s)clicked-\S+/g) || []).join(' ');
                });


                var reactionType = $(this).data('reaction');
                var postId = $(this).data('post-id');


                $(this).toggleClass('clicked-' + reactionType);

                var clickedButton = $(this);


                $.ajax({
                    type: 'POST',
                    url: 'ajax/toggle_reaction.php',
                    data: { postId: postId, reactionType: reactionType },
                    success: function (response) {
                        if (response === 'added') {

                            $('.reaction-button.btn').removeClass('reacted');

                            clickedButton.addClass('reacted');
                        } else if (response === 'removed') {

                            clickedButton.removeClass('reacted');
                        }
                    }
                });
            });
        });
    }

    initializeReactionButtons();
</script>

<script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.3/dist/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>

</html>