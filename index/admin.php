<?php
session_start();
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
  header('location:login.php');
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <link rel="stylesheet" href="./style/admin.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />

</head>

<body>
    <div class="container">
        <?php
          if(isset($_SESSION['admin_login'])) {
              $admin_id = $_SESSION['admin_login'];
              $stmt = $conn->query("SELECT * FROM users WHERE id =  $admin_id");
              $stmt->execute();
              $row = $stmt->fetch(PDO::FETCH_ASSOC);


          }
?>
        <h1 class="welc">Welcome Admin</h1>
        <nav>
            <ul class="navbar">
                <li><a href="#" id="home"><i class="fa-solid fa-house"></i></a></li>
                <li><a href="#" id="approvalpost">Approval Post</a></li>
                <li><a href="#" id="approvalplace">Approval Place</a></li>
                <li><a href="./logout.php" id="logout">Log Out</a></li>
                <div class="search-container">
                    <input type="text" id="searchInput" placeholder="Search">
                    <button id="searchButton">Search</button>
                </div>
            </ul>
        </nav>
    </div>

</body>

</html>