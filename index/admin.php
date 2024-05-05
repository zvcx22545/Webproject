<?php
require_once 'autoload.php';
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
    <link rel="stylesheet" href="./style/sidebar.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="hold-transition sidebar-mini">
    <div class="container">
        <?php
          if(isset($_SESSION['admin_login'])) {
              $admin_id = $_SESSION['admin_login'];
              $stmt = $conn->query("SELECT * FROM users WHERE id =  $admin_id");
              $stmt->execute();
              $row = $stmt->fetch(PDO::FETCH_ASSOC);


          }
?>
     
        <div class="container">
        <div class="left bg-base">
                <!-- ส่วนทางซ้าย -->
                <h1 class="logo"></h1>
                    <div class="main">
                        <br>
                        <ul class="menu">
                             <a href=""><button class="active" id="teamButton"  onclick="changePage('team')"><i class="bi bi-people"></i>อนุมัติสถานที่</button></a>
                        </ul>
                        <ul class="menu">
                             <a href=""><button class="none-active" id="competitionButton" onclick="changePage('competition')"><i class="bi bi-boxes"></i>จัดการโพสต์</button></a>
                        </ul>
                        <ul class="menu">
                        </ul>
                            <button class="logout" type="button"><a href="./logout.php"><p><i class="bi bi-arrow-bar-right"></i>Log out</p></a>
                            </button>
                </div>
            </div>
        <div class="right">
            <!-- ส่วนทางขวา -->
            <nav> <h1 id="pageTitle" class="text-2xl">อนุมัติสถานที่</h1><h1></h1></nav>
             
            <div class="admin-data">
            <div class="top-data">
                <div class="listMenu">
                    <h4>ทั้งหมด : </h4>
                </div>>
         </div>
             <div class="tableMember">
                <table>
                    <tr>
                      <th class="col0">No.</th>
                      <th class="col1">ชื่อทีม</th>
                      <th class="col4">สนามการแข่งขัน</th>
                      <th class="col2">การชำระเงิน</th>
                      <th class="col2">จำนวนผู้สมัคร</th>
                      <th>รายละเอียด</th>
                      <th class="col2">สถานะ</th>
                    </tr>
                    <tr>
                      <td>1</td>
                      <td>tester</td>
                      <td>สนาม CM Trafford Arena</td>
                      <td>1,000.00</td>
                      <td>4</td>
                      <td><button id="myBtn">ดูรายละเอียด</button></td>
                      <td id="status">รอดำเนินการ</td>
                    </tr>
                    
                  </table>

             </div>
        </div>
    </div>


    </div>
        </body>
<!-- SCRIPTS -->
<script src="./javascript/no-table.js"></script>
<script src="./javascript/details.js"></script>
<script src="./javascript/search.js"></script>
<script src="./javascript/preview.js"></script>
<!-- <script src="./javascript/admin-page.js"></script> -->



</html>