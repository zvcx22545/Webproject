<?php
require_once "autoload.php";
if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';

    header('location:login.php');
}
if (isset($_SESSION['user_login'])) {
    // แสดงข้อมูลของผู้ใช้ที่ล็อกอินเข้าระบบ
    $user_session_id = $_SESSION['user_login'];
    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_session_id");
    $stmt->bindParam(':user_session_id', $user_session_id);
    $stmt->execute();
    $row = $stmt->fetch(PDO::FETCH_ASSOC);
  
    // ตรวจสอบว่ามีผู้ใช้หรือไม่
    if ($row) {
        $user_id = $row['userid']; // ตอนนี้เราได้รับ userid ของผู้ใช้จากตาราง users
    } else {
        // ถ้าไม่พบข้อมูลผู้ใช้ในฐานข้อมูล ให้ทำการล็อกเอาท์และเปลี่ยนเส้นทาง
        $_SESSION['error'] = 'ผู้ใช้ไม่ถูกต้อง';
        header('location: logout.php'); // หรือให้เปลี่ยนเส้นทางไปที่หน้าอื่นที่เหมาะสม
        exit();
    }
  }
   else {
    // ถ้าไม่มีเซสชันของผู้ใช้ล็อกอิน เชิญผู้ใช้ล็อกอินก่อน
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
    header('location: login.php');
    exit();
  }
  ?>
<?php
include "header.php";

$ERROR ="";
$Post = new Post();
if (isset($_GET['id'])) {
    $ROW = $Post->get_one_post($_GET['id']);
    if (!$ROW) {
        $ERROR = "No such post was found!!!";
    } else {
        if ($ROW['user_id'] != $user_id) {
            $ERROR = "Access denied! You can't delete this post.";
        }
    }
} else {
    $ERROR = "No such post was found!!!";
}

// Store the return URL in a session variable

if ($_SERVER['REQUEST_METHOD'] == "POST") {
    // Call the edit_post function
    $Post->edit_post($_POST, $_FILES);

    // Redirect to the stored URL or Profilepage.php
    header("Location:Profilepage.php");
    // Stop the script
    exit;
}

?>

<body>


    <style>
        #delete_button {
            position: absolute;
            width: 80px;
            height: 50px;
            float: right;
            right: 0;
            bottom: 0;
            border: none;
            padding: 4px;
            font-size: 14px;
            box-shadow: 0px 1px 2px 1px;
        }

    </style>
<body class="backgrounds">
    <header class="pt-1 px-4 w-100 navbar-expand-xl bg-dark shadows fixed-top">
        <?php
        if (isset($_SESSION['user_login'])) {
            // แสดงข้อมูลของผู้ใช้ที่ล็อกอินเข้าระบบ
            $user_session_id = $_SESSION['user_login'];
            $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_session_id");
            $stmt->bindParam(':user_session_id', $user_session_id);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            // ตรวจสอบว่ามีผู้ใช้หรือไม่
            if ($row) {
                $user_id = $row['userid']; // ตอนนี้เราได้รับ userid ของผู้ใช้จากตาราง users
            } else {
                // ถ้าไม่พบข้อมูลผู้ใช้ในฐานข้อมูล ให้ทำการล็อกเอาท์และเปลี่ยนเส้นทาง
                $_SESSION['error'] = 'ผู้ใช้ไม่ถูกต้อง';
                header('location: logout.php'); // หรือให้เปลี่ยนเส้นทางไปที่หน้าอื่นที่เหมาะสม
                exit();
            }
        } else {
            // ถ้าไม่มีเซสชันของผู้ใช้ล็อกอิน เชิญผู้ใช้ล็อกอินก่อน
            $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
            header('location: login.php');
            exit();
        }


        ?>



        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start justify-content-start ">
            <div class="logo text-left col-12 col-lg-auto"><a href="./main.php" class="nav-link">Travel to Knowledge</a></div>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 navbars">
                <li><a href="./main.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'main.php' ? 'active' : ''; ?>"><i class="fa fa-home"></i></a></li>
                <li><a href="./travel.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'travel.php' ? 'active' : ''; ?>"><i class="fa-solid fa-mountain-sun"></i></a></li>
                <li><a href="./foodpage.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'foodpage.php' ? 'active' : ''; ?>"><i class="fa-solid fa-utensils"></i></a></li>
                <li><a href="./shirt.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'shirt.php' ? 'active' : ''; ?>"><i class="fa-solid fa-shirt"></i></a></li>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </ul>

            <div class="collapse navbar-collapse w-auto " id="navbarSupportedContent">

                <form class="d-flex mt-3 mt-lg-0 ms-auto" role="search">
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

        </div>

    </header>
    <?php
   
    ?>


        <div class="uploadprofile w-100 mt-lg-5 mx-auto">
            
            <form action="" method="Post" id="change_profile_form" class="text-center" enctype="multipart/form-data">
            <div class=" w-100"style="font-size:40px;">Edit Post</div>
                <div class="text-info text-center" style="font-weight:700;">
                    <br>
                    
                    <br>
                    <?php 
                     if($ERROR != "")
                     {
                         echo $ERROR;
                     }
                     else {
                        echo "Edit my post";
                        echo '<label for="exampleFormControlTextarea1" class="form-label"></label>';
                        echo '<textarea name="post" class="form-control h-50" id="exampleFormControlTextarea1" rows="1" placeholder="คุณกำลังคิดอะไรอยู่">' . $ROW['post'] . '</textarea>';
                        echo '<div class="container-content mb-3 mt-3">';
                        echo "<div><input type='hidden' name='postid' value='$ROW[postid]'></div>";
                        
                        $image_class = new Image();
                        if (file_exists($ROW['image'])) {
                            $post_image = $image_class->get_thumb_post($ROW['image']);
                            echo "<div><img id='preview_image' src='$post_image' style='width:600px;'/></div>
                            ";
                            echo "
                            <div class='my-3'>
                            <input class='form-control' name='file' type='file' id='select_post_img' onchange='previewImage()' style='display: none;'>
                            <label for='select_post_img' class='d-flex justify-content-center w-25 mx-auto'>
                              <svg xmlns='http://www.w3.org/2000/svg' width='30' height='30' fill='currentColor' class='bi bi-cloud-arrow-up text-center mx-auto' viewBox='0 0 16 16'>
                               <path fill-rule='evenodd' d='M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z' />
                                <path d='M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z' />
                                      </svg>
                                   </label>
                              </div>";
                        }
                        echo '</div>';
                        echo "<div class='d-flex justify-content-center align-items-center'><input type='submit' class='btn btn-outline-info mb-2 mt-2 mx-auto' id='save_button' value='Save'></div>";

                    }
                    
                    
                    ?>
                    <br>
                    <br><br>
                </div>
                

            </form>
        </div>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
<script src="./javascript/main.js"></script>
<script>
    function previewImage() {
        var preview = document.getElementById('preview_image');
        var file = document.querySelector('input[type=file]').files[0];
        var reader = new FileReader();

        reader.onloadend = function () {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }

    // Add event listener to the form submission
    document.getElementById('change_profile_form').addEventListener('submit', function(event) {
        // Call previewImage() function to update the preview before submitting the form
        previewImage();
    });
</script>


</body>