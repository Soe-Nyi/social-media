<?php include('config.php'); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.3.1/css/bootstrap.min.css">
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.2/css/all.css">
    <link rel="stylesheet" href="style.css">

    <!------------------LIght BOx for Gallery-------------->
    <link rel="stylesheet" href="lightbox.min.css">
    <script type="text/javascript" src="lightbox-plus-jquery.min.js"></script>
    <!------------------LIght BOx for Gallery-------------->
    <title>Social Media</title>

    <style>
        <?php
        if ($_COOKIE['theme'] == 1) {
            ?>
            body,
            .card-header,
            .card-body,
            .form-control,
            input,
            .media,
            .modal-content,
            .text-decoration-none {
                background-color: #202020;
                color: white;
                border: 0.2 solid white;
            }

        <?php } ?>
        .navbar {
            position: fixed;
            width: 100%;
            transition: top 0.3s;
            z-index: 1000;
        }
    </style>

    <script>
        var prevScrollPos = window.pageYOffset;
        window.onscroll = function () {
            var currentScrollPos = window.pageYOffset;
            if (prevScrollPos > currentScrollPos) {
                document.querySelector(".navbar").style.top = "0";
            } else {
                document.querySelector(".navbar").style.top = "-80px"; // Adjust this value as needed
            }
            prevScrollPos = currentScrollPos;
        }
    </script>

</head>
<!-- 
                @soenyinyiaung.2005
                @soenyinyiaung
                @soenyi
                @Soe-Nyi -->

<body>


    <!-------------------------------NAvigation Starts------------------>

    <nav class="navbar navbar-expand-md navbar-dark py-1" style="background-color:#3097D1">
        <a href="index.html" class="navbar-brand">
            <i class="fas fa-heart fa-lg mx-4" style="font-size:30px;color: #ff0059;"></i></a>

        <button class="navbar-toggler" data-toggle="collapse" data-target="#responsive"><span
                class="navbar-toggler-icon"></span></button>


        <div class="collapse navbar-collapse" id="responsive">
            <ul class="navbar-nav ml-4 mr-auto text-capitalize">
                <li class="nav-item">
                    <a href="home.php" class="nav-link"><i class="fas fa-home" style="font-size:20px;"></i> Home</a>
                </li>
                <li class="nav-item">
                    <a href="profile.php" class="nav-link"><i class="fas fa-user-circle" style="font-size:20px;"></i>
                        Profile</a>
                </li>
                <li class="nav-item">
                    <a href="notification.php" class="nav-link"><i class="fas fa-bell" style="font-size:20px;"></i>
                        Notification</a>
                </li>
                <li class="nav-item">
                    <a href="setting.php" class="nav-link"><i class="fas fa-cog" style="font-size:20px;"></i>
                        Setting</a>
                </li>
            </ul>

            <form action="home.php" class="form-inline ml-auto" method="GET">
                <input type="text" name="s" id="search" placeholder="Search" class="form-control form-control-sm">
                <a href="notification.php" style="color:#CBE4F2;font-size:22px;"><i
                        class="far fa-bell mx-3 d-none d-md-block"></i></a>
                <a href="https://www.facebook.com/soenyinyiaung.2005" target="_blank"
                    style="color:#CBE4F2;font-size:22px;"><i class="fas fa-question-circle fa--spin mx-2"></i></a>
            </form>


            <a href="profile.php"><img src="profile/<?= $getProfile ?>" alt=""
                    class="rounded-circle mx-3 d-none d-md-block" width="32px" height="32px"></a>
        </div>
    </nav>

    <!---------------------------------------------Ends navigation------------------------------>

    <!---------------------------MOdal Section  satrts------------------->


    <!-- Chat Modal -->
    <div class="modal fade" id="modalview">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <div class="modal-title h4">Chat</div>
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                    <ul class="list-unstyled" id="chat-box">

                    </ul>
                    <div class="input-group mb-3">
                        <input type="text" id="message-input" class="form-control" placeholder="Type your message">
                        <div class="input-group-append">
                            <button class="btn btn-primary" id="send-button">Send</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div style="height: 4.5em;"></div>

    <!-------------------------------MOdal Ends---------------------------->