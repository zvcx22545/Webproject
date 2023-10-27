<?php
session_start();
require_once 'config/db.php';
require_once 'user.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
    header('location:login.php');
    exit();
}

$response = [];

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"] != "") {
        $filename = $_FILES["file"]["name"];
        move_uploaded_file($_FILES["file"]["tmp_name"], "uploads/" . $filename);
        $response['status'] = "success";
        $response['msg'] = "Image uploaded successfully!";
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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous">
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body class="backgrounds">
    <header class="pt-1 px-4 w-100 navbar-expand-xxl bg-dark shadows fixed-top ">
        <?php
        if (isset($_SESSION['user_login'])) {
            $user_id = $_SESSION['user_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }


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

    <div class="container-upload ">
        <form action="" method="Post" enctype="multipart/form-data" id="change_profile_form">

            <div class="uploadprofile ">
                <input type="file" name="file">
                <input class="btn btn-outline-dark ms-auto" type="submit" id="post_button" value="Change">
            </div>
        </form>
    </div>


    <!-- below cover aria-label -->


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="./javascript/change_image_profile.js"></script>
    <script src="./javascript/main.js"></script>
</body>

</html>