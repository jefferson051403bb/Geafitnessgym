<?php
// FRONT-END PURPOSE

define('SITE_URL', 'http://v40sc4sog0wc8swo4sgo04s4.146.190.103.211.sslip.io/gymko/');
define('ABOUT_IMG_PATH', SITE_URL . 'images/about/');
define('CAROUSEL_IMG_PATH', SITE_URL . 'images/carousel/');
define('TRAINORS_IMG_PATH', SITE_URL . 'images/trainors/');

// BACK-END PURPOSE

define('UPLOAD_IMAGE_PATH', $_SERVER['DOCUMENT_ROOT'] . '/gymko/images/');
define('ABOUT_FOLDER', 'about/');
define('CAROUSEL_FOLDER', 'carousel/');
define('USERS_FOLDER', 'users/');
define('TRAINORS_FOLDER', 'trainors/');

function adminLogin()
{
    session_start();
    if (!(isset($_SESSION['adminLogin']) && $_SESSION['adminLogin'] === true)) {
        echo "<script>
            window.location.href='index.php';
        </script>";
        exit;
    }
}

function redirect($url)
{
    echo "<script>
        window.location.href='$url';
    </script>";
    exit;
}

function alert($type, $msg)
{
    $bs_class = ($type == "success") ? "alert-success" : "alert-danger";
    echo <<<alert
        <div class="alert $bs_class alert-dismissible fade show custom-alert text-center" role="alert">
            <strong class="me-3">$msg</strong>
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    alert;
}

function uploadImage($image, $folder)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    // Check if the MIME type is valid
    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img'; // Invalid image format
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . "." . $ext;

        $img_path = UPLOAD_IMAGE_PATH . $folder . $rname;

        // Check if the folder exists; if not, create it
        if (!is_dir(UPLOAD_IMAGE_PATH . $folder)) {
            mkdir(UPLOAD_IMAGE_PATH . $folder, 0777, true);
        }

        // Move the uploaded file to the destination path
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname; // Image upload successful
        } else {
            return 'upd_failed'; // Image upload failed
        }
    }
}

function deleteImage($image, $folder)
{
    $img_path = UPLOAD_IMAGE_PATH . $folder . $image;
    if (file_exists($img_path) && unlink($img_path)) {
        return true;
    } else {
        return false;
    }
}

function uploadUserImage($image)
{
    $valid_mime = ['image/jpeg', 'image/png', 'image/webp'];
    $img_mime = $image['type'];

    // Check if the MIME type is valid
    if (!in_array($img_mime, $valid_mime)) {
        return 'inv_img'; // Invalid image format
    } else {
        $ext = pathinfo($image['name'], PATHINFO_EXTENSION);
        $rname = 'IMG_' . random_int(11111, 99999) . ".jpeg";

        $img_path = UPLOAD_IMAGE_PATH . USERS_FOLDER . $rname;

        // Check if the folder exists; if not, create it
        if (!is_dir(UPLOAD_IMAGE_PATH . USERS_FOLDER)) {
            mkdir(UPLOAD_IMAGE_PATH . USERS_FOLDER, 0777, true);
        }

        // Save the image
        if (move_uploaded_file($image['tmp_name'], $img_path)) {
            return $rname;
        } else {
            return 'upd_failed';
        }
    }
}
?>
