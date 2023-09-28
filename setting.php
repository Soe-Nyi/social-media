<?php
include('include/config.php');
if (isset($_POST['change']) && isset($getId) && isset($getPassword)) {
    $userId = $getId;
    $name = htmlspecialchars(trim(substr($_POST['name'], 0, 30)));
    $bio = htmlspecialchars(trim(substr($_POST['bio'], 0, 110)));
    $email = htmlspecialchars(trim(substr($_POST['email'], 0, 30)));

    if (empty($_POST['password'])) {
        $password = $getPassword;
    } else {
        $password = md5(trim($_POST['password']));
    }

    $profileFileName = $getProfile;
    $coverFileName = $getCover;

    if (isset($_FILES['profile']) && $_FILES['profile']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = 'profile/';
        $imageType = exif_imagetype($_FILES['profile']['tmp_name']);
        $allowedImageTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP];

        if (in_array($imageType, $allowedImageTypes)) {
            $profileFileName = uniqid() . '_' . $_FILES['profile']['name'];
            $profilePath = $uploadDir . $profileFileName;

            if (move_uploaded_file($_FILES['profile']['tmp_name'], $profilePath)) {

            } else {
                $error = error_get_last();
                echo 'Error uploading profile image: ' . $error['message'];
            }
        } else {
            echo 'Invalid profile image type. Only JPEG, PNG, and WEBP are allowed.';
        }
    }

    if (isset($_FILES['cover']) && $_FILES['cover']['error'] === UPLOAD_ERR_OK) {

        $uploadDir = 'cover/';
        $imageType = exif_imagetype($_FILES['cover']['tmp_name']);
        $allowedImageTypes = [IMAGETYPE_JPEG, IMAGETYPE_PNG, IMAGETYPE_WEBP];

        if (in_array($imageType, $allowedImageTypes)) {
            $coverFileName = uniqid() . '_' . $_FILES['cover']['name'];
            $coverPath = $uploadDir . $coverFileName;

            if (move_uploaded_file($_FILES['cover']['tmp_name'], $coverPath)) {

            } else {
                $error = error_get_last();
                echo 'Error uploading cover image: ' . $error['message'];
            }
        } else {
            echo 'Invalid cover image type. Only JPEG, PNG, and WEBP are allowed.';
        }
    }


    $stmt = $pdo->prepare("UPDATE users SET name = ?, profile = ?, cover = ?, bio = ?, email = ?, password = ? WHERE id = ?");
    $stmt->execute([$name, $profileFileName, $coverFileName, $bio, $email, $password, $userId]);

    if (isset($_POST['darkmode']) || $_POST['darkmode'] == '1') {
        $theme = 1;
    } else {
        $theme = 0;
    }

    setcookie('email', $email, time() + (86400 * 30), "/");
    setcookie('password', $password, time() + (86400 * 30), "/");
    setcookie('theme', $theme, time() + (86400 * 30), "/");
    //header('location: setting.php');
    echo('<script>window.history.back();</script>');
}

?>
<?php include('include/header1.php') ?>
<div class="container mt-5">
    <div class="row justify-content-center">
        <?php include('include/leftCol1.php') ?>

        <div class="col-lg-5">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title text-center">Edit Profile</h4>
                    <form method="POST" enctype="multipart/form-data">
                        <div class="my-3 text-center">

                            <input type="file" name="profile" id="image-input" class="form-control-file"
                                accept="image/png, image/jpg, image/wepb" style="display: none;">

                            <input type="file" name="cover" id="image-input2" class="form-control-file"
                                accept="image/png, image/jpg, image/wepb" style="display: none;">

                            <label for="image-input2" class="card-img-top img-fluid" style="background-color: #575757;">
                                <img id="selected-image2" src="cover/<?= $getCover ?>"
                                    style="min-height: 150px;max-height: 200px;" alt="" class="card-img-top img-fluid">
                            </label>

                            <label for="image-input" class="mt-n5">
                                <img id="selected-image" src="profile/<?= $getProfile ?>" alt="Profile Image"
                                    class="rounded-circle" style="width: 150px; height: 150px;">
                            </label>
                        </div>
                        <div class="mb-3">
                            <input type="text" maxlength="30" name="name" class="form-control" value="<?= $getName ?>"
                                id="username" placeholder="Change Name">
                        </div>
                        <div class="mb-3">
                            <textarea name="bio" maxlength="110" class="form-control" id="bio"
                                placeholder="Bio"><?= $getBio ?></textarea>
                        </div>
                        <div class="mb-3">
                            <input type="text" maxlength="30" name="email" class="form-control" value="<?= $getEmail ?>"
                                id="email" placeholder="Change Email">
                        </div>
                        <div class="mb-3">
                            <input type="text" name="password" class="form-control" id="password"
                                placeholder="Change Password">
                        </div>
                        <div class="mb-3 form-check">
                            <input type="checkbox" name="darkmode" class="form-check-input" id="darkmode" <?php if (isset($_COOKIE['theme']) && $_COOKIE['theme'] == '1') {
                                echo 'checked value="0"';
                            } else {
                                echo 'value="1"';
                            } ?>>
                            <label class="form-check-label" for="darkmode">Change Dark Mode</label>
                        </div>
                        <button type="submit" name="change" class="btn btn-primary btn-block">Save Change</button>
                    </form>
                </div>
            </div>
            <a href="logout.php?key=<?= base64_encode($getPassword) ?>"><button type="button"
                    class="btn btn-danger btn-block my-4">Logout</button></a>
        </div>
        <?php include('include/rightCol1.php') ?>
    </div>
   
</div>

<style>
    #previewImage {
        border: 2px solid #ddd;
    }
</style>

<script>

    document.getElementById('image-input').addEventListener('change', function () {

        const selectedImage = document.getElementById('selected-image');

        if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                selectedImage.src = e.target.result;
            };

            reader.readAsDataURL(this.files[0]);
        }
    });


    document.getElementById('image-input2').addEventListener('change', function () {

        const selectedImage = document.getElementById('selected-image2');

        if (this.files && this.files[0]) {
            const reader = new FileReader();

            reader.onload = function (e) {
                selectedImage.src = e.target.result;
            };

            reader.readAsDataURL(this.files[0]);
        }
    });
</script>

<?php include('include/footer.php') ?>