<?php
require_once "autoload.php";
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
<?php
include "header.php";

$ERROR ="";
$Post = new Post();
if(isset($_GET['id'])){
  $ROW = $Post->get_one_post($_GET['id']);
  if(!$ROW){
    $ERROR = "NO such post was found!!!";
  }
  else{
    if($ROW['user_id'] != $user_id){
        $ERROR = "Accesss denind ! you can't  delete file!";
    }
  }
}else
{
  $ERROR = "NO such post was found!!!";
}
if($_SERVER['REQUEST_METHOD'] == "POST"){
    $Post->delete_post($_POST['postid']);
    header("Location: Profilepage.php");
    die;
}
?>

<body>


    <style>
        #delete_button {
            position: absolute;
            width: 80px;
            height: 50px;
            float: right;
            right: 0;
            bottom: 0;
            border: none;
            padding: 4px;
            font-size: 14px;
            box-shadow: 0px 1px 2px 1px;
        }

        .uploadprofile {
            min-height: 200px;
            position: relative;
        }
    </style>
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


        ?>



        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start justify-content-start ">
            <div class="logo text-left col-12 col-lg-auto"><a href="./main.php" class="nav-link">Travel to Knowledge</a></div>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 navbars">
                <li><a href="./main.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'main.php' ? 'active' : ''; ?>"><i class="fa fa-home"></i></a></li>
                <li><a href="./travel.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'travel.php' ? 'active' : ''; ?>"><i class="fa-solid fa-mountain-sun"></i></a></li>
                <li><a href="./foodpage.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'foodpage.php' ? 'active' : ''; ?>"><i class="fa-solid fa-utensils"></i></a></li>
                <li><a href="./shirt.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'shirt.php' ? 'active' : ''; ?>"><i class="fa-solid fa-shirt"></i></a></li>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </ul>

            <div class="collapse navbar-collapse w-auto " id="navbarSupportedContent">

                <form class="d-flex mt-3 mt-lg-0 ms-auto" role="search">
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

        </div>

    </header>
    <?php
   
    ?>
    <div class="container">

        <div class="uploadprofile w-100 mt-lg-5 d-flex justify-content-center">
            
            <form action="" method="Post" id="change_profile_form" class="text-center">
            <div class=" w-100"style="font-size:40px;">Delete Post</div>
                <div class=" text-danger  text-center" style="font-weight:700;">
                    <br>
                    
                    <br>
                    <?php 
                     if($ERROR != "")
                     {
                         echo $ERROR;
                     }
                    else{
                    echo "Are you sure you want to delete post?";
                    $user = new User();
                   $ROW_USER = $user->getUsers($ROW['user_id']);
                        include "post_delete.php";

                      echo  "<input class='btn btn-outline-danger ms-auto mb-2 me-2 mt-5' type='hidden' name='postid' value=' $ROW[postid]'>";
                       echo "<input class='btn btn-outline-danger ms-auto mb-2 me-2 mt-5' type='submit' id='delete_button' value='Delete'>";
                    }
                    ?>
                    <br>
                    <br><br>
                </div>
                

            </form>
        </div>
    </div>
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
<script src="./javascript/main.js"></script>
</body>