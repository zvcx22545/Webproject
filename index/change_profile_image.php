<?php
require_once "autoload.php";

$response = [];

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
    header('location:login.php');
}
// แสดงข้อมูลของผู้ใช้ที่ล็อกอินเข้าระบบ
$user_session_id = $_SESSION['user_login'];
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_session_id");
$stmt->bindParam(':user_session_id', $user_session_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

if ($row) {
    $user_id = $row['userid']; // ตอนนี้เราได้รับ userid ของผู้ใช้จากตาราง users
} else {
    // ถ้าไม่พบข้อมูลผู้ใช้ในฐานข้อมูล ให้ทำการล็อกเอาท์และเปลี่ยนเส้นทาง
    $_SESSION['error'] = 'ผู้ใช้ไม่ถูกต้อง';
    header('location: logout.php'); // หรือให้เปลี่ยนเส้นทางไปที่หน้าอื่นที่เหมาะสม
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_FILES["file"]["name"]) && $_FILES["file"]["name"] != "") {
        $allowed_types = ["image/jpeg", "image/png", "image/webp"];
        if (in_array($_FILES['file']['type'], $allowed_types)) {
            $allowed_size = (1024 * 1024) * 3;
            if ($_FILES['file']['size'] < $allowed_size) {
                //everything is fine
                $folder = "uploads/" . $row['userid'] . "/";

                //create folder
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                }
                $image = new Image();
                $filename = $folder . $image->generate_filename(15) . ".jpg";
                move_uploaded_file($_FILES["file"]["tmp_name"], $filename);
                $change = "profile";

                // check for mode

                if (isset($_GET['change'])) {
                    $change = $_GET['change'];
                }

                if ($change == "cover") {
                    if (file_exists($row['cover_image'])) {
                        unlink($row['cover_image']);
                    }
                    $image->resize_image($filename, $filename, 1500, 1500);
                } else {
                    if (file_exists($row['profile_image'])) {
                        unlink($row['profile_image']);
                    }
                    $image->crop_image($filename, $filename, 1500, 1500);
                }

                if (file_exists($filename)) {
                    $user_id = $row['userid'];
                    if ($change == "cover") {
                        $sql = "UPDATE users SET cover_image = :filename WHERE userid = :user_id LIMIT 1";
                        $_POST['is_cover_image'] = 1;
                    } else {
                        $sql = "UPDATE users SET profile_image = :filename WHERE userid = :user_id LIMIT 1";
                        $_POST['is_profile_image'] = 1;
                    }

                    $query = $conn->prepare($sql);
                    $query->bindParam(":filename", $filename, PDO::PARAM_STR);
                    $query->bindParam(":user_id", $user_id, PDO::PARAM_INT);
                    $query->execute();
                    $post = new Post();
                    $_POST['is_profile_image'] = 1;
                    $post->create_post($user_id, $_POST, $filename);
                    $response['status'] = "success";
                    $response['msg'] = "เปลี่ยนรูปภาพสำเร็จแล้ว!";
 
                    //create a post

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
            $response['msg'] = "กรุณาอัพโหลดไฟล์ Jpeg  Png Webp เท่านั้น!";
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
<?php
    include "header.php";
?>
<body class="backgrounds">
    <header class="pt-1 px-4 w-100 navbar-expand-xxl bg-dark shadows fixed-top ">

        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start justify-content-start ">
            <div class="logo text-left col-12 col-lg-auto"><a href="./main.php" class="nav-link">Travel to Knowledge</a></div>

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
        <div class="text-center d-flex justify-content-center align-content-center">
            <img src="" style="display: none;" id="profile_img" class=" rounded border">
        </div>
        <form action="" method="Post" enctype="multipart/form-data" id="change_profile_form" class="text-center mt-2 d-flex justify-content-center align-content-center">
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
    <script src="./javascript/main.js"></script>
</body>
<script>
    
</script>
</html>