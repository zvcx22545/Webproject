<!-- post area -->
<?php
require_once("autoload.php");
?>

<div class="post">
    <?php
    $image_class = new Image();
    $image = "images/istockphoto-1337144146-612x612.jpg";

    if (file_exists($ROW_USER['profile_image'])) {
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

    <?php 
if (!function_exists('makeClickableLinks')) {
  function makeClickableLinks($text) {
      $pattern = "/((http|https|ftp):\/\/)?([a-z0-9-]+\.)+[a-z]{2,4}(\.[a-z]{2})?(\:[0-9]+)?(\/([^\s]+)?)/i";
      $replacement = "<a href='$0' target='_blank'>$0</a>";
      return preg_replace($pattern, $replacement, $text);
  }
}

  ?>
    <div class="post-content">
    <?php echo makeClickableLinks($ROW['post']); ?>

        <br><br>
        <?php
        if (file_exists($ROW['image'])) {
            $post_image = $image_class->get_thumb_post($ROW['image']);
            echo "<img src='$post_image' style='width:85%;'/>";
        }
        ?>
    </div>
    
</div>