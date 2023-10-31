<?php
session_start();
require_once 'config/db.php';
require_once 'user.php';
require_once 'image.php';

$response = [];

if (!isset($_SESSION['user_login'])) {
    $response['status'] = "error";
    $response['msg'] = 'กรุณาเข้าสู่ระบบ!!';
    echo json_encode($response);
    exit();
}

// แสดงข้อมูลของผู้ใช้ที่ล็อกอินเข้าระบบ
$user_session_id = $_SESSION['user_login'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_session_id");
$stmt->bindParam(':user_session_id', $user_session_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$row) {
    // Handle the case where user data is not found
    $response['status'] = "error";
    $response['msg'] = 'ไม่พบข้อมูลผู้ใช้!';
    echo json_encode($response);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"] != "") {
        $allowed_types = ["image/jpeg", "image/png", "image/svg+xml", "image/webp"];
        if (in_array($_FILES['file']['type'], $allowed_types)) {
            $allowed_size = (1024 * 1024) * 3;
            if ($_FILES['file']['size'] < $allowed_size) {
                $filename = "uploads/" . $_FILES["file"]["name"];
                move_uploaded_file($_FILES["file"]["tmp_name"], $filename);
                $image = new Image();
                $image->crop_image($filename,$filename,800,800);

                if (file_exists($filename)) {
                    $user_id = $row['userid'];
                    $sql = "UPDATE users SET profile_image = :filename WHERE userid = :user_id LIMIT 1";
                    $query = $conn->prepare($sql);
                    $query->bindParam(":filename", $filename, PDO::PARAM_STR);
                    $query->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                    $query->execute();

                    $response['status'] = "success";
                    $response['msg'] = "เปลี่ยนรูปภาพสำเร็จแล้ว!";
                } else {
                    $response['status'] = "error";
                    $response['msg'] = "File upload failed!";
                }
            } else {
                $response['status'] = "error";
                $response['msg'] = "ขนาดไฟล์ไม่เกิน 3mb หรือ ต่ำกว่า!";
            }
        } else {
            $response['status'] = "error";
            $response['msg'] = "กรุณาอัพโหลดไฟล์ Jpeg Svg Png Webp เท่านั้น!";
        }
    } else {
        $response['status'] = "error";
        $response['msg'] = "กรุณาเลือกรูปภาพของคุณ!";
    }

    header('Content-Type: application/json');
    echo json_encode($response);
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Travel to Knowledge</title>
    <link rel="stylesheet" href="./style/main.css">
    <link rel="stylesheet" href="./style/post.css">
    <link rel="stylesheet" href="./style/changeprofile.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body class="backgrounds">
    <header class="pt-1 px-4 w-100 navbar-expand-xxl bg-dark shadows fixed-top ">
        <?php

        ?>




        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start justify-content-start ">
            <div class="logo text-left col-12 col-lg-auto">Travel to Knowledge</div>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 navbars">
                <li><a href="./main.php" class="nav-link px-2"><i class="fa fa-home"></i></a></li>
                <li><a href="./travel.php" class="nav-link px-2 "><i class="fa-solid fa-mountain-sun"></i></a></li>
                <li><a href="#" class="nav-link px-2"><i class="fa-solid fa-utensils"></i></a></li>
                <li><a href="#" class="nav-link px-2"><i class="fa-solid fa-shirt"></i></a></li>
            </ul>
            <form class="d-flex mt-3 mt-lg-0 " role="search" method="POST">
                <input class="form-control me-2 rounded-pill" type="search" placeholder="Search" aria-label="Search">
                <button class="btn btn-outline-light me-2" type="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                        <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                    </svg></button>
            </form>
            <div class="text-center">
                <button type="button" class="btn btn-outline-light"><a class="nav-link" href="./logout.php" id="logout">Logout</a></button>
            </div>
            <div class="icon text-white me-2 px-3"><i class="fa-solid fa-sun" id="theme"></i></div>

        </div>

    </header>

    <!-- Cover area -->


    <!-- ส่วนของการอัปโหลด -->
    <div class="container-upload">
        <img src="" style="display: none;" id="profile_img" class=" rounded border text-center">
        <form action="" method="Post" enctype="multipart/form-data" id="change_profile_form">
            <input type="file" id="fileUpload" name="file" style="display: none;">
            <div class="upload-profile">
                <div class="uploadprofile">
                    <label for="fileUpload">
                        <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cloud-arrow-up text-center" viewBox="0 0 16 16">
                            <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z" />
                            <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                        </svg>
                    </label>
                    <input class="btn btn-outline-dark ms-auto" type="submit" id="post_button" value="Change">
                </div>
            </div>
        </form>
    </div>



    <!-- below cover aria-label -->


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="./javascript/view_profile.js?= time() ?>"></script>
    <script src="./javascript/change_image_profile.js"></script>
    <script src="./javascript/main.js"></script>
</body>

</html>