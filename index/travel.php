<?php
session_start();
require_once 'config/db.php';
require_once 'function.php';


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
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body class="backgrounds">
  <header class="pt-1 px-4 w-100 navbar-expand-xxl bg-dark shadows fixed-top">
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
    <li><a href="./main.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'main.php' ? 'active' : ''; ?>"><i class="fa fa-home"></i></a></li>
    <li><a href="./travel.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'travel.php' ? 'active' : ''; ?>"><i class="fa-solid fa-mountain-sun"></i></a></li>
    <li><a href="./foodpage.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'foodpage.php' ? 'active' : ''; ?>"><i class="fa-solid fa-utensils"></i></a></li>
    <li><a href="./shirt.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'shirt.php' ? 'active' : ''; ?>"><i class="fa-solid fa-shirt"></i></a></li>
</ul>
      <form class="d-flex mt-3 mt-lg-0 " role="search">
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

  <div class="container ">
    <div class="left-panel">
      <ul>
        <li>
          <div class="dp">
            <a class="" href="./Profilepage.php">
              <img src="https://cdn.pixabay.com/photo/2014/11/30/14/11/cat-551554_1280.jpg" alt="Profile Image">
            </a>
          </div>
          <p>Name</p>

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
      <div class="post create" style="margin-top:75px;">
        <div class="post-top">
          <div class="dp">
            <img src="https://cdn.pixabay.com/photo/2014/11/30/14/11/cat-551554_1280.jpg" type="images" alt="">
          </div>

          <input type="text" placeholder="คุณอยากจะโพสต์อะไร" data-bs-toggle="modal" data-bs-target="#postModal" readonly style="cursor: pointer;" />


        </div>

        <div class="post-bottom">
          <div class="action">
            <i class="fa fa-video"></i>
            <span>Live video</span>
          </div>
          <div class="action">
            <i class="fa fa-image"></i>
            <span>Photo/Video</span>
          </div>
          <div class="action">
            <i class="fa fa-smile"></i>
            <span>Feeling/Activity</span>
          </div>
        </div>
      </div>
      <!-- post area -->
      <div class="post">
        <div class="post-top">
          <div class="dp">
            <img src="https://cdn.pixabay.com/photo/2014/11/30/14/11/cat-551554_1280.jpg" type="images" alt="">
          </div>
          <div class="post-info">
            <p class="name mt-3">User</p>
            <span class="time">1 week ago</span>
          </div>
          <i class="fas fa-ellipsis-h"></i>
        </div>
        <div class="post-content">
          Happy birthday dear
          <img src="https://cdn.pixabay.com/photo/2016/02/10/16/37/cat-1192026_1280.jpg" alt="Mountains">
        </div>
        <div class="post-bottom">
          <div class="action">
            <i class="far fa-thumbs-up"></i>
            <span>Like</span>
          </div>
          <div class="action">
            <i class="far fa-comment"></i>
            <span>Comment</span>
          </div>
          <div class="action">
            <i class="fa fa-share"></i>
            <span>Share</span>
          </div>
        </div>
      </div>
      <!-- post area -->
      <div class="post">
        <div class="post-top">
          <div class="dp">
            <img src="https://cdn.pixabay.com/photo/2014/11/30/14/11/cat-551554_1280.jpg" type="images" alt="">
          </div>
          <div class="post-info">
            <p class="name mt-3">User</p>
            <span class="time">1 week ago</span>
          </div>
          <i class="fas fa-ellipsis-h"></i>
        </div>
        <div class="post-content">
          Happy birthday dear
          <img src="https://cdn.pixabay.com/photo/2018/03/27/17/25/cat-3266673_1280.jpg" alt="">
        </div>
        <div class="post-bottom">
          <div class="action">
            <i class="far fa-thumbs-up"></i>
            <span>Like</span>
          </div>
          <div class="action">
            <i class="far fa-comment"></i>
            <span>Comment</span>
          </div>
          <div class="action">
            <i class="fa fa-share"></i>
            <span>Share</span>
          </div>
        </div>
      </div>

    </div>
  </div>


  <?php
  include('footer.php');
  ?>
  <!-- <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="postModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="postModalLabel">สร้างโพสต์</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <textarea class="form-control" placeholder="พิมพ์ข้อความของคุณที่นี่..."></textarea>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
        <button type="button" class="btn btn-primary">โพสต์</button>
      </div>
    </div>
  </div>
</div> -->
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="./javascript/main.js"></script>
</body>

</html>