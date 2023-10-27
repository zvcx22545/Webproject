<?php
session_start();
require_once 'config/db.php';
include 'post.php';
require_once 'user.php';

if (!isset($_SESSION['user_login'])) {
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';

  header('location:login.php');
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
    <!-- <script defer src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script> -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

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

    //posting start here
    if ($_SERVER['REQUEST_METHOD'] == "POST") {
      $post = new Post();
      $result = $post->create_post($user_id, $_POST); // ใช้ $user_id ซึ่งเป็น userid แทนที่จะใช้ $_SESSION['user_login']
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
    $posts = $post->get_posts($user_id);  // ใช้ $user_id ซึ่งเป็น userid แทนที่จะใช้ $_SESSION['user_login']

?>



        <div
            class="container-fluid d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start justify-content-start ">
            <div class="logo text-left col-12 col-lg-auto">Travel to Knowledge</div>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 navbars">
                <li><a href="./main.php"
                        class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'main.php' ? 'active' : ''; ?>"><i
                            class="fa fa-home"></i></a></li>
                <li><a href="./travel.php"
                        class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'travel.php' ? 'active' : ''; ?>"><i
                            class="fa-solid fa-mountain-sun"></i></a></li>
                <li><a href="./foodpage.php"
                        class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'foodpage.php' ? 'active' : ''; ?>"><i
                            class="fa-solid fa-utensils"></i></a></li>
                <li><a href="./shirt.php"
                        class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'shirt.php' ? 'active' : ''; ?>"><i
                            class="fa-solid fa-shirt"></i></a></li>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                    data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent"
                    aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </ul>

            <div class="collapse navbar-collapse w-auto " id="navbarSupportedContent">

                <form class="d-flex mt-3 mt-lg-0 ms-auto" role="search">
                    <input class="form-control me-2 rounded-pill" type="search" placeholder="Search"
                        aria-label="Search">
                    <button class="btn btn-outline-light me-2" type="submit"><svg xmlns="http://www.w3.org/2000/svg"
                            width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg></button>
                </form>
                <div class="text-center">
                    <button type="button" class="btn btn-outline-light"><a class="nav-link" href="./logout.php"
                            id="logout">Logout</a></button>
                </div>
                <div class="icon text-white me-2 px-3"><i class="fa-solid fa-sun" id="theme"></i></div>

            </div>

        </div>

    </header>

    <div class="container ">

        <div class="left-panel">
            <ul>
                <li>
                    <div class="dp">

                        <img src="https://cdn.pixabay.com/photo/2014/11/30/14/11/cat-551554_1280.jpg"
                            alt="Profile Image">

                    </div>
                    <a href="./Profilepage.php" class="nav-link ms-2">
                        <p style="font-weight:700;"><?php echo $row['first_name'] . " " . $row['last_name'] ?></p>
                    </a>

                </li>
                <li>
                    <i class="fa fa-user-friends"></i>
                    <p>Friends</p>
                </li>
                <li>
                    <i class="fa fa-play-circle"></i>
                    <p>Videos</p>
                </li>
                <li>
                    <i class="fa fa-flag"></i>
                    <p>Pages</p>
                </li>
                <li>
                    <i class="fa fa-users"></i>
                    <p>Groups</p>
                </li>
                <li>
                    <i class="fa fa-bookmark"></i>
                    <p>Bookmark</p>
                </li>
                <li>
                    <i class="fab fa-facebook-messenger"></i>
                    <p>Inbox</p>
                </li>
                <li>
                    <i class="fas fa-calendar-week"></i>
                    <p>Events</p>
                </li>
                <li>
                    <i class="fa fa-bullhorn"></i>
                    <p>Ads</p>
                </li>
                <li>
                    <i class="fas fa-hands-helping"></i>
                    <p>Offers</p>
                </li>
                <li>
                    <i class="fas fa-briefcase"></i>
                    <p>Jobs</p>
                </li>
                <li>
                    <i class="fa fa-star"></i>
                    <p>Favourites</p>
                </li>
            </ul>

            <div class="footer-links">
                <a href="#">Privacy</a>
                <a href="#">Terms</a>
                <a href="#">Advance</a>
                <a href="#">More</a>
            </div>
        </div>

        <div class="container-post">
            <!-- พื่นที่สำหรับสร้างโพสต์ -->
            <div class="post create" style="margin-top:70px;">
                <div class="post-top">
                    <div class="dp">
                        <img src="https://cdn.pixabay.com/photo/2014/11/30/14/11/cat-551554_1280.jpg" type="images"
                            alt="">
                    </div>

                    <input type="text" placeholder="คุณอยากจะโพสต์อะไร" data-bs-toggle="modal"
                        data-bs-target="#postModal" readonly style="cursor: pointer;" />

                    <!-- พื้นที่สำหรับสร้างโพสต์ -->
                    <style>
                    #exampleFormControlTextarea1 {
                        height: 150px !important;
                    }
                    </style>
                    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title me-3">คุณอยากโพสต์อะไร</h5>
                                    <select id="categoryDropdown"
                                        class="form-control option-container text-center rounded-pill mt-1 w-50">
                                        <option value="" disabled selected>หมวดหมู่</option>
                                        <option value="clothing">Clothing</option>
                                        <option value="travel">Travel</option>
                                        <option value="food">Food</option>
                                    </select>

                                    <button type="button" class="btn-close mr-lg-2" data-bs-dismiss="modal"
                                        aria-label="Close"></button>

                                </div>

                                <div class="modal-body">
                                    <img src="" style="display: none;" id="post_img" class="w-100 rounded border">
                                    <form method="post" enctype="multipart/form-data">
                                        <div class="my-3">

                                            <input class="form-control" name="post_img" type="file"
                                                id="select_post_img">
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label"></label>
                                            <textarea name="post" class="form-control h-50"
                                                id="exampleFormControlTextarea1" rows="1"
                                                placeholder="คุณกำลังคิดอะไรอยู่"></textarea>
                                        </div>


                                        <button name="post_button" type="submit" class="btn btn-primary"
                                            id="post_button" value="Post">Post</button>

                                    </form>
                                </div>

                            </div>
                        </div>
                    </div>
                    <script src="./javascript/custom.js?v=<?= time() ?>"></script>


                </div>

                <div class="post-bottom">
                    <!-- <div class="action">
            <i class="fa fa-video"></i>
            <span>Live video</span>
          </div> -->
                    <div class="action mx-auto">
                        <i class="fa fa-image"></i>
                        <span>Photo</span>
                    </div>
                    <!-- <div class="action">
            <i class="fa fa-smile"></i>
            <span>Feeling/Activity</span>
          </div> -->
                </div>
            </div>
            <!-- post area -->
            <?php
      if ($posts) {

        foreach ($posts as $ROW) {
          $user = new User();
          $ROW_USER = $user->getUsers($ROW['user_id']);
          include 'function.php';
        }
      }

      # code...

      ?>

        </div>
    </div>


    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
    <script src="./javascript/main.js"></script>
</body>

</html>