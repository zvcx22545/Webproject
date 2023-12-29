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
}
 else {
  // ถ้าไม่มีเซสชันของผู้ใช้ล็อกอิน เชิญผู้ใช้ล็อกอินก่อน
  $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
  header('location: login.php');
  exit();
}
?>

<div class="post">
  <?php
  $image = "images/istockphoto-1337144146-612x612.jpg";
  if (file_exists($row['profile_image'])) {
    $image_class = new Image();
    $image = $image_class->get_thumb_profile($row['profile_image']);

  }
  if(file_exists($ROW_USER['profile_image']))
  {
    $image  = $image_class->get_thumb_profile($ROW_USER['profile_image']);
  }

  ?>

  <div class="post-top">
    <div class="mt-2 dp">
      <img class="img-fluid col-sm-12 col-md col-lg col-xl" src="<?php echo $image ?>" type="images" alt="">
    </div>
    <div class="post-info">
      <p class="name font-weight-bolder mt-3"><a href="./Profilepage.php" class="nav-link"><?php echo $ROW_USER['first_name'] . " " . $ROW_USER['last_name'] ?></a></p>

      <span class="time">
        <?php
        setlocale(LC_TIME, 'th_TH.utf8'); // ตั้งค่าให้เป็นภาษาไทยและใช้พื้นที่ที่ถูกต้อง
        $timestamp = strtotime($ROW['date']);
        $formattedDate = strftime(' %A %e %B %Y : เวลา %H.%M', $timestamp);
        echo $formattedDate;
        ?>
      </span>
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
    </div>


      <!-- Trigger สำหรับ Dropdown -->
      <i class="fas fa-ellipsis-h dropdown-toggle" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false"></i>

      <!-- เมนู Dropdown -->
      <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
        <li><a class="dropdown-item" href="#edit">Edit</a></li>
        <li><a class="dropdown-item" href="#delete">Delete</a></li>
      </ul>
   

  </div>
  <div class="post-content">
    <?php echo $ROW['post'] ?>
    <br><br>
    <?php
    if (file_exists($ROW['image'])) {
      $post_image = $ROW['image'];
      echo "<img src='$post_image' style='width:100%;'/>";
    }
    ?>
  </div>
  <div class="post-bottom">
    <div class="action">
    <i class="bi bi-star-fill"></i>
      <span>Star</span>
    </div>
    <div class="action">
      <i class="far fa-comment"></i>
      <span>Comment</span>
    </div>

    <div class="containericon d-flex align-content-center">
    <?php
    $post = new Post();
    if($post->i_own_post($ROW['postid'],$user_id))
    {
      echo "
        <a href='delete.php?id=$ROW[postid]'><i class='bi bi-trash-fill btn btn-outline-danger mx-2'>Delete</i></a>";
      
    }
      ?>
    </div>
 
   
   
  </div>
</div>