<?php

require_once 'autoload.php';

if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';

    header('location:login.php');
}

include "header.php";


?>


<body class="backgrounds">
    <header class="pt-1 px-4 w-100 navbar-expand-xl bg-dark shadows  ">
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

        //posting start here
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            $post = new Post();
            $result = $post->create_post($user_id, $_POST, $_FILES); // ใช้ $user_id ซึ่งเป็น userid แทนที่จะใช้ $_SESSION['user_login']
            if ($result == "") {
                header("location:main.php");
                exit();
            } else {
                echo "have error posting";
                echo $result;
            }
        }

        // collect posts
        $post = new Post();
        $posts = $post->getAllPosts();  // ใช้ $user_id ซึ่งเป็น userid แทนที่จะใช้ $_SESSION['user_login']
        $image_class = new Image();

        if (isset($_POST['submit'])) {
            $postid = $_POST['search'];
    
            $sql = "SELECT * FROM posts WHERE postid = :postid";
            $stmt = $conn->prepare($sql);
            $stmt->execute(['postid' => $postid]);
            $row = $stmt->fetch();
        } else {
            header("location: index.php");
            exit();
        }
        ?>



        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start justify-content-start ">
            <div class="logo text-left col-12 col-lg-auto"><a href="./main.php" class="nav-link">Travel to Knowledge</a></div>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 navbars">
                <li><a href="./main.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'main.php' ? 'active' : ''; ?>"><i class="fa fa-home"></i></a></li>
                <li><a href="./travel.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'travel.php' ? 'active' : ''; ?>"><i class="fa-solid fa-mountain-sun"></i></a></li>
                <li><a href="./foodpage.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'foodpage.php' ? 'active' : ''; ?>"><i class="fa-solid fa-utensils"></i></a></li>
                <li><a href="./clothing.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'shirt.php' ? 'active' : ''; ?>"><i class="fa-solid fa-shirt"></i></a></li>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </ul>

            <div class="collapse navbar-collapse w-auto " id="navbarSupportedContent">

                <form class="d-flex mt-3 mt-lg-0 ms-auto" role="search"action="search.php" method="get">
                    <input class="form-control me-2 rounded-pill" type="search" placeholder="Search" aria-label="Search"name="search" id="search" autocomplete="off" required>
                    <button class="btn btn-outline-light me-2" type="submit" name="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
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
    <body>
        
    </body>
</html>

