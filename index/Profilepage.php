<?php
session_start();
require_once 'config/db.php';
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
  <link rel="stylesheet" href="./style/profilepage.css">
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
        <li><a href="./main.php" class="nav-link px-2"><i class="fa fa-home"></i></a></li>
        <li><a href="./travel.php" class="nav-link px-2 "><i class="fa-solid fa-mountain-sun"></i></a></li>
        <li><a href="#" class="nav-link px-2"><i class="fa-solid fa-utensils"></i></a></li>
        <li><a href="#" class="nav-link px-2"><i class="fa-solid fa-shirt"></i></a></li>
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

  <!-- Cover area -->
  <div class="background-profile">
    <div class="bg-top text-center">
      <img src="https://cdn.pixabay.com/photo/2017/09/20/04/46/salt-moutain-2767408_1280.jpg" style="width: 100%;">
      <img src="./images/posts/cat-551554_1920.jpg" id="profile_pic">
      <br>
      <div class="Name-profile"> <?php echo $row['first_name']." ".$row['last_name'] ?></div>
      <br>
      <div id="menu_buttons"> Timeline </div>
      <div id="menu_buttons"> About </div>
      <div id="menu_buttons"> Photos</div>
      <div id="menu_buttons"> Settings</div>
    </div>
    <!-- below cover aria-label -->
    <div class="d-flex">
      <!-- <div style="min-height:400px;flex:1;"></div> -->
      <!-- post area -->
      <div style="min-height:400px;flex:1;" class="container-area-profile">
        <!-- post area -->
      <div class="post w-100">
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
    </div>
    </div>
  </div>


  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>
  <script src="./javascript/main.js"></script>
</body>

</html>