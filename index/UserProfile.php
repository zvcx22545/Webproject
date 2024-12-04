<!-- post area -->
<?php
require_once 'autoload.php';

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
} else {
  // ถ้าไม่มีเซสชันของผู้ใช้ล็อกอิน เชิญผู้ใช้ล็อกอินก่อน
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
  header('location: login.php');
  exit();
}
?>

<style>
  @import url('https://fonts.googleapis.com/css2?family=Prompt:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap');

  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Prompt", sans-serif;
  }

  .edit-btn {
    height: 38px;
    display: flex;
    justify-content: center;
    align-items: center;
    gap: 4px;
    letter-spacing: 3px;
  }

  .edit-btn:hover {
    color: white;
  }
</style>
<div class="post">
  <?php
  $image = "images/istockphoto-1337144146-612x612.jpg";
  // if (file_exists($row['profile_image'])) {
  //   $image_class = new Image();
  //   $image = $image_class->get_thumb_profile($row['profile_image']);
  // }
  if (file_exists($ROW_USER['profile_image'])) {
    $image = $image_class->get_thumb_profile($ROW_USER['profile_image']);
  }

  ?>

  <div class="post-top">
    <div class="mt-2 dp">
      <img class="img-fluid col-sm-12 col-md col-lg col-xl" src="<?php echo $image ?>" type="images" alt="">
    </div>
    <div class="post-info">

      <p class="name font-weight-bolder mt-3">
      <?php

      if($ROW_USER)
      {
        echo "<a class='location-name' href=\"Profilepage.php\">" . $ROW_USER['first_name'] ." " . $ROW_USER['last_name'] . "</a>";

      }
    // if (!empty($ROW['location_name'])) {
    //     $location = new Location();
    //     $locationInfo = $location->getLocationInfoByName($ROW['location_name']);
    //     if ($locationInfo && isset($locationInfo['map_link'])) {
    //         $mapLink = $locationInfo['map_link'];
    //         echo "<a class='location-name' href=\"$mapLink\">" . $ROW['location_name'] . "</a>";
    //     } else {
    //         echo $ROW['location_name'];
    //     }
    // } else {
    //     echo "No location provided";
    // }
    ?>


      </p>


      <span class="time">
        <?php
        setlocale(LC_TIME, 'th_TH.utf8'); // Ensure you're using Thai locale settings
        date_default_timezone_set('Asia/Bangkok'); // Set the default timezone to Bangkok
        
        $timestamp = strtotime($ROW['date']); // Assuming $ROW['date'] holds the date string
        
        // Map English days and months to Thai
        $dayOfWeekEnglish =  strftime('%A', $timestamp);
        $monthOfYearEnglish = strftime('%B', $timestamp);

        $dayOfWeekThaiMap = [
          'Sunday' => 'วันอาทิตย์',
          'Monday' => 'วันจันทร์',
          'Tuesday' => 'วันอังคาร',
          'Wednesday' => 'วันพุธ',
          'Thursday' => 'วันพฤหัสบดี',
          'Friday' => 'วันศุกร์',
          'Saturday' => 'วันเสาร์'
        ];
        $monthOfYearThaiMap = [
          'January' => 'มกราคม',
          'February' => 'กุมภาพันธ์',
          'March' => 'มีนาคม',
          'April' => 'เมษายน',
          'May' => 'พฤษภาคม',
          'June' => 'มิถุนายน',
          'July' => 'กรกฎาคม',
          'August' => 'สิงหาคม',
          'September' => 'กันยายน',
          'October' => 'ตุลาคม',
          'November' => 'พฤศจิกายน',
          'December' => 'ธันวาคม'
        ];

        $dayOfWeekThai = $dayOfWeekThaiMap[$dayOfWeekEnglish] ?? $dayOfWeekEnglish; // Default to English if not mapped
        $monthOfYearThai = $monthOfYearThaiMap[$monthOfYearEnglish] ?? $monthOfYearEnglish; // Default to English if not mapped
        
        $formattedDate = $dayOfWeekThai . date(' d ', $timestamp) . $monthOfYearThai . date(' Y : เวลา H:i', $timestamp);

        echo $formattedDate; // Display the formatted date
        ?>


      </span>
      <br>

      <div>
  
</div>

      

    </div>

    <div class="posts" data-postid="<?php echo $ROW['postid']; ?>">
      <i class="fa-solid fa-ellipsis" id="toggle-dropdown"></i>
        <ul class="content-button">
          <li>
            <button class="dropdown-item report-button" data-postid="<?php echo $ROW['postid']; ?>">
              <i class="fa-solid fa-flag"></i>
                <div class="text">Report</div>
            </button>
          </li>
          <hr class="divider">
      </ul>
    </div>
  </div>
  <?php 
// Check if the function is not already defined
if (!function_exists('makeClickableLinks')) {
  // Function to convert URLs in text to clickable links and convert newlines to <br>
  function makeClickableLinks($text) {
      $text = nl2br(htmlspecialchars($text)); // Convert newlines to <br> tags and escape HTML
      // Improved URL matching pattern
      $pattern = "/((http|https|ftp):\/\/[a-zA-Z0-9\-\._~:\/\?#\[\]@!$&'\(\)*\+,;=]+)/i";
      $replacement = "<a href='$0' target='_blank'>$0</a>";
      return preg_replace($pattern, $replacement, $text);
  }
}
  ?>
  <div class="post-content">
    <div class="text-container" id="textContainer">
      
    <?php
      if ($ROW['is_profile_image']) {
        echo "<br>";
        echo "<span style='font-weight:normal;coloe:#aaa;'>updated profile image</span>";
      }
      if ($ROW['is_cover_image']) {
        echo "<br>";
        echo "<span style='font-weight:normal;coloe:#aaa;'>updated cover image</span>";
      }
      ?>
       <?php echo makeClickableLinks(htmlspecialchars($ROW['post'])); ?>
       <!-- <button id="showMoreBtn">ดูเพิ่มเติม...</button> -->
    </div>

    <br>
    <?php
    if (file_exists($ROW['image'])) {
      $image_class = new Image();
      $post_image = $image_class->get_thumb_post($ROW['image']);
      echo "<img src='$post_image' style='width:100%;'/>";
    }
    ?>
  </div>
  <?php
      $like_id = 0;
      $post = new Post();
      $history_like = $post->get_like_history($ROW['postid'], $user_id);
      if($history_like){
        $like_id = $history_like['id'];
      }
    ?>
  <div class="post-bottom">
    <button class="btn btn btn-light btn-like" data-id="<?php echo $ROW['postid'] ?>" data-likeid="<?php echo $like_id ?>">
      <?php
        if($like_id == 0){
          echo '<i class="bi bi-star"></i>';
        }else{
          echo '<i class="bi bi-star-fill"></i>';
        }
      ?>
      <span>Star</span>
      <span id="ele-<?php echo $ROW['postid'] ?>">
      <?php
        if($ROW['likes'] > 0) {
          echo "<span class='badge badge-dark like-count' id='post-".$ROW['postid']."'>".number_format($ROW['likes'])."</span>";
        }
      ?>
      </span>
    </button>
    <button class="btn btn btn-light btn-comment ms-auto" data-id="<?php echo $ROW['postid'] ?>">
      <i class="far fa-comment"></i>
      <span>Comment</span>
    </button>
    <div class="containericon d-flex align-content-center">
      <?php
      // $post = new Post();
      // if ($post->i_own_post($ROW['postid'], $user_id)) {
      //   echo "
      //   <a href='delete.php?id=$ROW[postid]'class='btn-post btn btn-outline-danger mx-2 d-flex edit-btn'>
      //   <div  style='font-size: 16px;'>Delete</div>
      //   <i class='bi bi-trash-fill  '></i>
      //   </a>
      //   <a href='edit.php?id=$ROW[postid]'class='btn-post d-flex btn btn-outline-info mx-2 edit-btn' style='text-decoration: none;'>
      //   <i class='fa-solid fa-pen-to-square '></i>
      //   <div  style='font-size: 16px;'>Edit</div>
      //   </a> 
      //   ";

      // }
      ?>
    </div>
  </div>
  <?php
    $comment = new Comment();
    $data = $comment->getAllComment($ROW['postid']);
    $commentsContainerStyle = "";
    if ($data) {
        $commentsContainerStyle = "style='height: 18vh; overflow-y: auto;'";
    }
?>
<div class='comments mt-2' <?php echo $commentsContainerStyle; ?>>
    <?php
    foreach ($data as $row) {
        $util = new Util();
        $create_date = $util->coverdate($row['create_date']);
        echo "<div class='card mb-1'>" .
            "<div class='card-body'>" .
            $row['content'] .
            "<br><span class='fw-light' style='font-size: 12px;'>" . $row['fullname'] . "</span>" .
            " <span class='fw-light' style='font-size: 10px;'>" . $create_date . "</span>" .
            "</div>" .
            "</div>";
    }
    ?>
</div>

</div>