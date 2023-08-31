<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['user_login'])) {
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
  header('location:login.php');
}


?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=, initial-scale=1.0">
  <title>Travel to Knowledge</title>
  <link rel="stylesheet" href="./style/main.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
</head>

<body>
  <div class="container">
    <?php
          if(isset($_SESSION['user_login'])) {
              $user_id = $_SESSION['user_login'];
              $stmt = $conn->query("SELECT * FROM users WHERE id = $user_id");
              $stmt->execute();
              $row = $stmt->fetch(PDO::FETCH_ASSOC);

          }


?>
    <div class="logo">Travel to Knowledge</div>

    <div class="navigation">
      <nav>
        <ul class="navbar">
          <li><a href="#" id="home"><i class="fa-solid fa-house"></i></a></li>
          <li><a href="#" id="clothing">เสื้อผ้า</a></li>
          <li><a href="#" id="categories">อาหาร</a></li>
          <li><a href="/index/travel/travel.html" id="categories">แหล่งท่องเที่ยว</a></li>
          <li><a href="./logout.php" id="logout">Log Out</a></li>
          <div class="search-container">
            <input type="text" id="searchInput" placeholder="Search">
            <button id="searchButton">Search</button>
          </div>
        </ul>
      </nav>
    </div>
    <div class="btn">
      <button class="btn__post btn--p" id="postButton">Post</button>
      <button class="btn__profile btn--pro" id="profileButton">Profile</button>

    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="#"></script>
</body>

</html>