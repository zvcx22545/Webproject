<!-- post area -->
<?php
require_once ("config/db.php");
$stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_id");
$stmt->bindParam(':user_id', $user_id);
$stmt->execute();
$row = $stmt->fetch(PDO::FETCH_ASSOC);

?>
<div class="post">
  <div class="post-top">
    <div class="dp">
      <img src="https://cdn.pixabay.com/photo/2014/11/30/14/11/cat-551554_1280.jpg" type="images" alt="">
    </div>
    <div class="post-info">
  <p class="name font-weight-bolder mt-3"><?php echo $ROW_USER['first_name'] . " " . $ROW_USER['last_name'] ?></p>
  <span class="time">
    <?php
    setlocale(LC_TIME, 'th_TH.utf8'); // ตั้งค่าให้เป็นภาษาไทยและใช้พื้นที่ที่ถูกต้อง
    $timestamp = strtotime($ROW['date']);
    $formattedDate = strftime(' %A %e %B %Y : เวลา %H.%M', $timestamp);
    echo $formattedDate;
    ?>
  </span>
</div>


    <i class="fas fa-ellipsis-h"></i>
  </div>
  <div class="post-content">
    <?php echo $ROW['post'] ?>
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

