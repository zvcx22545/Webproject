<?php

require_once 'autoload.php';



if (!isset($_SESSION['user_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';

    header('location:login.php');
}

include "header.php";



?>


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
                $_SESSION['user_id'] = $user_id;
            } else if ($row) {
                $first_name = $row['first_name'];
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

        //posting start here
        if ($_SERVER['REQUEST_METHOD'] == "POST") {
            if (isset($_POST['post_button'])) {
                // ประมวลผลของ Modal แรก
                $post = new Post();
                $result = $post->create_post($user_id, $_POST, $_FILES);
                if ($result['status'] == 'success') {
                    if (!empty($result['location_name'])) {
                        $_SESSION['post_location'] = true;
                    } else {
                        $_SESSION['post_success'] = true;
                    }
                    header("location: main.php");
                    exit();
                } else {
                    echo "have error posting";
                    echo $result['message'];
                }
            }
            if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['addlocation'])) {
                // Ensure $user_id and $first_name are set correctly
                if (isset($_SESSION['user_login'])) {
                    $user_session_id = $_SESSION['user_login'];
                    $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_session_id");
                    $stmt->bindParam(':user_session_id', $user_session_id);
                    $stmt->execute();
                    $row = $stmt->fetch(PDO::FETCH_ASSOC);
                    if ($row) {
                        $user_id = $row['userid']; // Ensure this is correct
                        $first_name = $row['first_name']; // Ensure this is correct
                        // Check if location_name already exists
                        $location = isset($_POST['location_name']) ? $_POST['location_name'] : "";
                        $Maplink = isset($_POST['Maplink']) ? $_POST['Maplink'] : "";
                        if (empty($location) || empty($Maplink)) {
                            // Display SweetAlert2 for empty location name or map link
                            echo '<script type="text/javascript">';
                            echo 'Swal.fire("Error", "กรุณากรอกชื่อสถานที่และลิงค์ Google Map", "error");';
                            echo '</script>';
                        } else {
                            // Check if location name or map link already exists
                            $query_check = $conn->prepare("SELECT * FROM locations WHERE location_name = :location_name OR map_link = :map_link");
                            $query_check->bindParam(":location_name", $location);
                            $query_check->bindParam(":map_link", $Maplink);
                            $query_check->execute();
                            $result = $query_check->fetchAll(PDO::FETCH_ASSOC);
                            if ($result) {
                                foreach ($result as $row) {
                                    if ($row['location_name'] === $location) {
                                        // Display SweetAlert2 if location name already exists
                                        echo '<script type="text/javascript">';
                                        echo 'Swal.fire("Error", "มีชื่อสถานที่นี้อยู่แล้ว", "error");';
                                        echo 'setTimeout(function(){ window.location.href = "main.php"; }, 2000);'; // Redirect to main.php after 2 seconds
                                        echo '</script>';
                                        exit; // Exit after displaying error message
                                    } elseif ($row['map_link'] === $Maplink) {
                                        // Display SweetAlert2 if map link already exists
                                        echo '<script type="text/javascript">';
                                        echo 'Swal.fire("Error", "มีลิงค์สถานที่นี้อยู่แล้ว", "error");';
                                        echo 'setTimeout(function(){ window.location.href = "main.php"; }, 2000);'; // Redirect to main.php after 2 seconds
                                        echo '</script>';
                                        exit; // Exit after displaying error message
                                    }
                                }
                            } else {
                                // Add location if validation passes
                                $Addlocations = new Location();
                                $result = $Addlocations->Addlocation($user_id, $_POST, $_FILES, $first_name);
                                if ($result === true) {
                                    // Display success message using SweetAlert2
                                    echo '<script type="text/javascript">';
                                    echo 'Swal.fire("Success", "เพิ่มสถานที่สำเร็จ!กรุณารอAdminตรวจสอบสถานที่", "success");';
                                    echo '</script>';
                                } else {
                                    // Display error message using SweetAlert2
                                    echo '<script type="text/javascript">';
                                    echo 'Swal.fire("Error", "' . $result . '", "error");';
                                    echo '</script>';
                                }
                            }
                        }
                    } else {
                        // Handle case where user is not found
                        echo '<script type="text/javascript">';
                        echo 'Swal.fire("Error", "User not found", "error");';
                        echo '</script>';
                    }
                } else {
                    // Handle case where user session is not set
                    echo '<script type="text/javascript">';
                    echo 'Swal.fire("Error", "User session not set", "error");';
                    echo '</script>';
                }
            }
        }




        // collect posts
        $post = new Post();
        $posts = $post->getAllPosts();  // ใช้ $user_id ซึ่งเป็น userid แทนที่จะใช้ $_SESSION['user_login']
        $image_class = new Image();
        // GetLocation
        $location = new Location;
        $locations = $location->GetApprovedLocation();
        ?>



        <div class="container-fluid d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start justify-content-start ">

            <div class="logo text-left col-12 col-lg-auto"><a href="./main.php" class="nav-link">Travel to Knowledge</a>
            </div>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 navbars">
                <li><a href="./main.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'main.php' ? 'active' : ''; ?>"><i class="fa fa-home"></i></a></li>
                <li><a href="./travel.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'travel.php' ? 'active' : ''; ?>"><i class="fa-solid fa-mountain-sun"></i></a></li>
                <li><a href="./foodpage.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'foodpage.php' ? 'active' : ''; ?>"><i class="fa-solid fa-utensils"></i></a></li>
                <li><a href="./clothing.php" class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'shirt.php' ? 'active' : ''; ?>"><svg id="Layer_1" data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 122.88 108.82"><defs><style>.cls-1{fill-rule:evenodd;}</style></defs><title>services</title><path class="cls-1" d="M3.1,56.47H21.3a3.11,3.11,0,0,1,3.1,3.1v37.2a3.11,3.11,0,0,1-3.1,3.1H3.1A3.11,3.11,0,0,1,0,96.77V59.57a3.11,3.11,0,0,1,3.1-3.1ZM28.42,96.23V60H47.77c6.92,1.24,13.84,5,20.75,9.35H81.2c5.73.34,8.74,6.16,3.17,10-4.45,3.26-10.31,3.07-16.32,2.54-4.15-.21-4.33,5.36,0,5.38,1.5.12,3.13-.23,4.56-.24,7.5,0,13.68-1.44,17.46-7.36L92,75.16l18.85-9.35c9.44-3.1,16.14,6.77,9.19,13.63a247,247,0,0,1-42,24.71c-10.4,6.33-20.81,6.11-31.21,0l-18.4-7.92ZM62,7.65a1.15,1.15,0,0,0-.39-.21.72.72,0,0,0-.32,0,1.11,1.11,0,0,0-.73.38l-2.53,3a1.53,1.53,0,0,1-1.9.37c-.34-.18-.7-.35-1.06-.5s-.79-.31-1.17-.44-.77-.24-1.22-.37-.83-.23-1.22-.32A1.54,1.54,0,0,1,50.3,8.12L49.92,4a1.29,1.29,0,0,0-.12-.42,1.22,1.22,0,0,0-.23-.29.72.72,0,0,0-.32-.17.92.92,0,0,0-.41,0l-5.31.52a1.42,1.42,0,0,0-.41.12,1.17,1.17,0,0,0-.34.28,1.08,1.08,0,0,0-.18.33v0a.89.89,0,0,0,0,.33l.37,3.89a1.54,1.54,0,0,1-1.12,1.63c-.32.11-.68.24-1.09.41s-.76.34-1.08.51l-.06,0c-.34.18-.7.37-1,.57l-.1,0c-.34.2-.67.41-1,.62a1.55,1.55,0,0,1-1.82-.08L32.24,9.57a1.28,1.28,0,0,0-.35-.2.69.69,0,0,0-.3,0,1.31,1.31,0,0,0-.41.13l-.06,0a1.34,1.34,0,0,0-.25.23L27.52,13.8a1.3,1.3,0,0,0-.23.41.87.87,0,0,0,0,.32v.07a.9.9,0,0,0,.1.34l0,.05a1.16,1.16,0,0,0,.24.26l3,2.53A1.52,1.52,0,0,1,31,19.69a11.4,11.4,0,0,0-.49,1,12.37,12.37,0,0,0-.44,1.17c-.12.37-.25.77-.38,1.22s-.23.84-.32,1.22A1.53,1.53,0,0,1,28,25.54l-4.13.38a1.23,1.23,0,0,0-.41.12,1.13,1.13,0,0,0-.3.24.9.9,0,0,0-.17.32,1,1,0,0,0,0,.4l.52,5.31a1.22,1.22,0,0,0,.12.42,1.11,1.11,0,0,0,.27.34,1.35,1.35,0,0,0,.33.18,1.09,1.09,0,0,0,.37,0l3.89-.37A1.53,1.53,0,0,1,30.06,34c.11.32.25.69.42,1.09s.33.75.51,1.09l.07.14c.16.31.34.65.54,1l.67,1.1a1.55,1.55,0,0,1-.1,1.8L29.4,43.63a1.5,1.5,0,0,0-.18.32.9.9,0,0,0,0,.29,1.16,1.16,0,0,0,.12.42,1,1,0,0,0,.26.31c1.38,1.15,2.8,2.28,4.17,3.44a1.05,1.05,0,0,0,.3.15.94.94,0,0,0,.38,0h0a1.42,1.42,0,0,0,.44-.12l.05,0a2.47,2.47,0,0,0,.27-.21l2.5-3a1.53,1.53,0,0,1,1.91-.38,11.47,11.47,0,0,0,1.06.5c.39.17.78.31,1.17.44s.76.25,1.22.38.83.23,1.22.32a1.53,1.53,0,0,1,1.19,1.44L45.86,52a1.1,1.1,0,0,0,.13.41.93.93,0,0,0,.23.3,1.11,1.11,0,0,0,.32.17,1.09,1.09,0,0,0,.41,0l5.3-.52a1.28,1.28,0,0,0,.43-.12l0,0A1.24,1.24,0,0,0,53,52a1.28,1.28,0,0,0,.21-.37.72.72,0,0,0,0-.36l-.36-3.9a1.53,1.53,0,0,1,1-1.6c.39-.13.78-.28,1.16-.44l.12,0c.32-.14.64-.3,1-.48l.06,0c.38-.19.75-.39,1.08-.59l1.11-.67a1.52,1.52,0,0,1,1.79.11l3.38,2.76a1.35,1.35,0,0,0,.33.18h0a.69.69,0,0,0,.32,0,1,1,0,0,0,.41-.11,1.22,1.22,0,0,0,.3-.27c1.15-1.38,2.28-2.8,3.44-4.17a.89.89,0,0,0,.15-.29,1.15,1.15,0,0,0,0-.38v0a1.5,1.5,0,0,0-.12-.44,1.21,1.21,0,0,0-.25-.32l-3-2.44a1.52,1.52,0,0,1-.39-1.92,11.47,11.47,0,0,0,.5-1.06c.17-.41.32-.8.44-1.16s.24-.78.37-1.23.23-.82.32-1.22a1.53,1.53,0,0,1,1.47-1.19L72,30a1.29,1.29,0,0,0,.42-.12,1.54,1.54,0,0,0,.29-.23,1.11,1.11,0,0,0,.17-.32v0a1.13,1.13,0,0,0,0-.38l-.52-5.3a1.31,1.31,0,0,0-.12-.41l0-.06a1.26,1.26,0,0,0-.25-.28,1.08,1.08,0,0,0-.33-.18h0a.89.89,0,0,0-.33,0L67.4,23a1.55,1.55,0,0,1-1.6-1c-.13-.37-.27-.76-.45-1.16s-.35-.82-.52-1.15l0-.07a11.26,11.26,0,0,0-.56-1c-.2-.34-.43-.68-.66-1a1.54,1.54,0,0,1,.09-1.85l2.74-3.39a1.15,1.15,0,0,0,.2-.35.67.67,0,0,0,0-.29,1.38,1.38,0,0,0-.13-.42l0-.07a1.17,1.17,0,0,0-.21-.24L62.55,7.93A1.46,1.46,0,0,1,62,7.65Zm41.38,24.6a1.54,1.54,0,0,0-1.15-.36,1.62,1.62,0,0,0-1.06.57l-1.53,1.85a10.69,10.69,0,0,0-1.51-.64c-.54-.17-1-.32-1.58-.45l-.24-2.58a1.57,1.57,0,0,0-.55-1.06,1.45,1.45,0,0,0-1.14-.33l-3.26.32a1.61,1.61,0,0,0-1,.54A1.51,1.51,0,0,0,90,31.26l.22,2.37a9.37,9.37,0,0,0-1.53.65,11.4,11.4,0,0,0-1.4.82l-2.06-1.66a1.42,1.42,0,0,0-1.12-.37,1.6,1.6,0,0,0-1.06.58l-2,2.49a1.55,1.55,0,0,0,.21,2.21L83,39.88a9.6,9.6,0,0,0-.63,1.51c-.18.54-.33,1-.46,1.58l-2.58.24a1.6,1.6,0,0,0-1.06.55A1.46,1.46,0,0,0,78,44.91l.32,3.25a1.58,1.58,0,0,0,.55,1.05,1.47,1.47,0,0,0,1.14.36l2.37-.22A9.79,9.79,0,0,0,83,50.87a15.71,15.71,0,0,0,.82,1.44l-1.66,2a1.41,1.41,0,0,0-.36,1.12,1.58,1.58,0,0,0,.57,1L84.9,58.6a1.5,1.5,0,0,0,1.15.33,1.68,1.68,0,0,0,1.08-.54l1.54-1.88a9.25,9.25,0,0,0,1.51.64,14.89,14.89,0,0,0,1.58.45L92,60.19a1.61,1.61,0,0,0,.55,1.05,1.49,1.49,0,0,0,1.15.34l3.25-.32A1.62,1.62,0,0,0,98,60.71a1.51,1.51,0,0,0,.36-1.15l-.23-2.37a8.69,8.69,0,0,0,1.53-.65,14.52,14.52,0,0,0,1.43-.81l2,1.66a1.51,1.51,0,0,0,1.15.36,1.54,1.54,0,0,0,1.06-.57l2.08-2.52a1.53,1.53,0,0,0,.34-1.15,1.64,1.64,0,0,0-.55-1.08l-1.88-1.52A8.9,8.9,0,0,0,106,49.4a15.43,15.43,0,0,0,.45-1.57l2.59-.24a1.57,1.57,0,0,0,1-.55,1.48,1.48,0,0,0,.34-1.15l-.32-3.25a1.62,1.62,0,0,0-.55-1,1.51,1.51,0,0,0-1.15-.37l-2.37.23a11.13,11.13,0,0,0-.65-1.53,8.72,8.72,0,0,0-.82-1.4l1.67-2.06a1.46,1.46,0,0,0,.36-1.12,1.62,1.62,0,0,0-.57-1.06l-2.5-2.05-.08,0ZM93.5,39.08a6.73,6.73,0,0,1,2.52.25,6.58,6.58,0,0,1,2.15,1.16,6.36,6.36,0,0,1,1.55,1.89,6,6,0,0,1,.72,2.41,6.71,6.71,0,0,1-.25,2.52,6.21,6.21,0,0,1-3,3.71,6.17,6.17,0,0,1-2.41.71,6.51,6.51,0,0,1-2.52-.25,6.61,6.61,0,0,1-2.16-1.15,6.53,6.53,0,0,1-1.54-1.9A5.92,5.92,0,0,1,87.79,46a6.28,6.28,0,0,1,3.3-6.22,5.92,5.92,0,0,1,2.41-.72ZM62.56,4.5a4.64,4.64,0,0,1,1,.45,1.48,1.48,0,0,1,.6.3L68.19,8.6a4.19,4.19,0,0,1,.94,1.09l.08.13a4.23,4.23,0,0,1,.48,1.52A3.72,3.72,0,0,1,69.52,13a4.19,4.19,0,0,1-.71,1.29l-2.06,2.56.13.21a13.49,13.49,0,0,1,.71,1.36q.36.7.6,1.29l.08.2,2.7-.26a3.85,3.85,0,0,1,1.56.14l.08,0a4.19,4.19,0,0,1,1.28.69l.14.12a4.18,4.18,0,0,1,.89,1.1l.08.13a4.2,4.2,0,0,1,.43,1.45c0,1.34.34,3.94.52,5.34a4,4,0,0,1-.11,1.51l0,.09a4,4,0,0,1-.75,1.41l0,0a4.06,4.06,0,0,1-1.19,1,4.42,4.42,0,0,1-1.52.46l-3.18.28-.08.29c-.11.4-.25.85-.43,1.36s-.33,1-.5,1.37l-.08.17,2.19,1.77a4.14,4.14,0,0,1,1,1.29A4.28,4.28,0,0,1,71.62,41v.05a3.93,3.93,0,0,1-.13,1.6A4.14,4.14,0,0,1,70.82,44l-3.49,4.22a4,4,0,0,1-1.21,1,3.92,3.92,0,0,1-1.53.48A4.07,4.07,0,0,1,63,49.57l-.08,0a4.29,4.29,0,0,1-1.26-.68l-2.59-2.11-.26.15c-.44.26-.87.49-1.28.69s-.76.38-1.17.56L56,48.3,56.28,51a3.91,3.91,0,0,1-.17,1.65A4.26,4.26,0,0,1,55.35,54l-.06.06a4.39,4.39,0,0,1-1.13.91l-.1,0a4.28,4.28,0,0,1-1.44.43c-1.34,0-3.94.35-5.34.53a4.23,4.23,0,0,1-1.6-.13,4,4,0,0,1-1.41-.76l-.05,0a4.38,4.38,0,0,1-.95-1.2,4.15,4.15,0,0,1-.46-1.52l-.29-3.17-.28-.08-1.36-.43c-.48-.16-1-.33-1.37-.51l-.19-.08-1.8,2.19a4,4,0,0,1-1.17.91l-.11.07a4.6,4.6,0,0,1-1.39.4H34.8a4,4,0,0,1-1.61-.13,4.2,4.2,0,0,1-1.33-.68l-4.23-3.49a4.12,4.12,0,0,1-1-1.21,4.17,4.17,0,0,1-.48-1.51A3.6,3.6,0,0,1,26.32,43,4,4,0,0,1,27,41.73l2.11-2.59L29,38.89c-.22-.37-.43-.77-.64-1.19l0,0c-.25-.46-.46-.9-.65-1.35l-.09-.23-2.68.25a3.87,3.87,0,0,1-1.64-.16,4,4,0,0,1-1.28-.7l-.15-.11a4.36,4.36,0,0,1-1-1.25,4.21,4.21,0,0,1-.43-1.44c0-1.35-.35-3.91-.53-5.33A4.1,4.1,0,0,1,20,25.73a4,4,0,0,1,.76-1.41l0,0a4.42,4.42,0,0,1,1.2-1,4.15,4.15,0,0,1,1.52-.45l3.17-.29.08-.29c.12-.39.26-.85.43-1.35s.34-1,.51-1.38l.08-.19L25.7,17.63a4.22,4.22,0,0,1-1-1.11l-.06-.1A3.92,3.92,0,0,1,24.22,15l0-.08a4,4,0,0,1,.16-1.61,4.18,4.18,0,0,1,.78-1.41l3.35-4.09a3.92,3.92,0,0,1,1.1-.93l.12-.08a4,4,0,0,1,1.52-.48,3.59,3.59,0,0,1,1.63.17,4.28,4.28,0,0,1,1.29.71l2.57,2.07L37,9.07c.41-.24.83-.46,1.25-.67s.88-.44,1.29-.62l.24-.09L39.51,5a3.85,3.85,0,0,1,.14-1.56l0-.08a4.19,4.19,0,0,1,.69-1.28L40.49,2a4.28,4.28,0,0,1,1.23-1A4.13,4.13,0,0,1,43.17.55c1.34,0,3.94-.34,5.34-.52a4,4,0,0,1,1.6.13,4,4,0,0,1,1.41.75l0,0a4.34,4.34,0,0,1,1,1.19A4.42,4.42,0,0,1,53,3.66l.28,3.18.29.08c.39.11.85.25,1.36.42l1.37.51.2.09,1.73-2.09a4.08,4.08,0,0,1,1.22-1A4.15,4.15,0,0,1,61,4.35a3.77,3.77,0,0,1,1.61.15ZM46.71,16.11a13.72,13.72,0,0,1,2.31,0,12.18,12.18,0,0,1,2.36.47h0a12.34,12.34,0,0,1,2.12.89l.09.05a12.59,12.59,0,0,1,1.8,1.21l0,0a12.48,12.48,0,0,1,2.89,3.55,10.57,10.57,0,0,1,.92,2.19,10.93,10.93,0,0,1,.44,2.36v0a12.65,12.65,0,0,1,0,2.3,11.2,11.2,0,0,1-.46,2.36l0,.1a12.25,12.25,0,0,1-.86,2,13.25,13.25,0,0,1-1.25,1.9l-.1.11a12.2,12.2,0,0,1-3.47,2.81,11.49,11.49,0,0,1-2.2.92,12.34,12.34,0,0,1-2.35.44,14.2,14.2,0,0,1-2.35,0,12,12,0,0,1-2.36-.47h0a12.58,12.58,0,0,1-2.11-.89,13.6,13.6,0,0,1-1.9-1.26l0,0a12.25,12.25,0,0,1-1.6-1.62,13.21,13.21,0,0,1-1.3-1.92,11.35,11.35,0,0,1-.91-2.2,10.93,10.93,0,0,1-.44-2.36v0a12.65,12.65,0,0,1,0-2.3,11.2,11.2,0,0,1,.46-2.36h0a12,12,0,0,1,.89-2.12l.05-.09a11.65,11.65,0,0,1,1.21-1.81l.08-.1a11.28,11.28,0,0,1,1.56-1.53,13.15,13.15,0,0,1,1.92-1.29,11.3,11.3,0,0,1,2.19-.92,12.59,12.59,0,0,1,2.36-.44Zm2,3.07a9.62,9.62,0,0,0-1.78,0h0a8.82,8.82,0,0,0-1.73.32,8.2,8.2,0,0,0-1.59.66,10.44,10.44,0,0,0-1.47,1A9.3,9.3,0,0,0,41,22.26l0,0a9.32,9.32,0,0,0-.9,1.35l0,.08a9.46,9.46,0,0,0-.66,1.59A8.85,8.85,0,0,0,39,27.06a10.57,10.57,0,0,0,0,1.78v0a8.36,8.36,0,0,0,.33,1.74A7.85,7.85,0,0,0,40,32.2a9.54,9.54,0,0,0,1,1.46,8.38,8.38,0,0,0,1.18,1.2,9.55,9.55,0,0,0,1.41.93,10.11,10.11,0,0,0,1.6.67,8,8,0,0,0,1.73.34,9.94,9.94,0,0,0,1.81,0,9.06,9.06,0,0,0,1.74-.32A8,8,0,0,0,52,35.82a9.64,9.64,0,0,0,1.47-1,9.3,9.3,0,0,0,1.14-1.12l0,0a9.49,9.49,0,0,0,1-1.44,10.86,10.86,0,0,0,.65-1.52v-.06a9,9,0,0,0,.35-1.74,10.57,10.57,0,0,0,0-1.78v0a8.36,8.36,0,0,0-.33-1.74,8.1,8.1,0,0,0-.66-1.59,9.08,9.08,0,0,0-1-1.46,8.38,8.38,0,0,0-1.18-1.2,9.64,9.64,0,0,0-1.33-.89l-.08,0a10,10,0,0,0-1.6-.67,8.06,8.06,0,0,0-1.72-.34ZM16.25,85.85a3.56,3.56,0,1,1-3.55,3.56,3.56,3.56,0,0,1,3.55-3.56Z"/></svg></a></li>
                <button class="navbar-toggler" type="button">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </ul>

            <div class="collapse navbar-collapse w-auto" id="navbarSupportedContent">

                <form class="d-flex mt-3 mt-lg-0 ms-auto search" role="search" action="search.php" method="POST">
                    <input class="form-control me-2 rounded-pill" type="search" placeholder="ค้นหาสถานที่" aria-label="Search" name="search" id="search" autocomplete="off" required>
                    <button class="btn btn-outline-light me-2" type="submit" name="submit"><svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                            <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg></button>

                    <div class="list-groups" id="show-list">

                    </div>
                </form>


                <div class="text-center">
                    <button type="button" class="btn btn-outline-light"><a class="nav-link" href="./logout.php" id="logout">Logout</a></button>
                </div>
                <div class="icon text-white me-2 px-3"><i class="fa-solid fa-sun" id="theme"></i></div>

            </div>

        </div>
        

    </header>

    <div class="container ">
        <script>
            <?php if (isset($_SESSION['post_location']) && $_SESSION['post_location']) : ?>
                var postlocationSuccess = true;
                <?php unset($_SESSION['post_location']); ?>
            <?php else : ?>
                var postlocationSuccess = false;
            <?php endif; ?>

            <?php if (isset($_SESSION['post_success']) && $_SESSION['post_success']) : ?>
                var postSuccess = true;
                <?php unset($_SESSION['post_success']); ?>
            <?php else : ?>
                var postSuccess = false;
            <?php endif; ?>
        </script>

        <div class="left-panel">
            <ul>
                <li>
                    <div class="dp">
                        <?php
                        $corner_image = "images/istockphoto-1337144146-612x612.jpg";
                        if (file_exists($row['profile_image'])) {
                            $image_class = new Image();
                            $corner_image = $image_class->get_thumb_profile($row['profile_image']);
                        }
                        ?>
                        <img src="<?php echo $corner_image ?>" id="profile_pic">

                    </div>
                    <a href="./Profilepage.php" class="nav-link ms-2">
                        <p style="font-weight:700;"><?php echo $row['first_name'] . " " . $row['last_name'] ?></p>
                    </a>

                </li>
                <div class="mt-3">
                    <button class="btn location btn-outline-light w-100 mt-2" data-bs-target="#AddlocationModal" data-bs-toggle="modal" data-bs-dismiss="modal">
                        <div class="icons h-25 w-100 d-flex align-items-center justify-content-center">
                            <div class="text-center" style="font-size:16px;">เพิ่มสถานที่</div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icon">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>

                    </button>
                </div>




            </ul>


        </div>

        <div class="container-post">
            <!-- พื่นที่สำหรับสร้างโพสต์ -->
            <div class="post create" style="margin-top:70px;">
                <div class="post-topm">
                   
                <div class="tag">
                        <a href="./travel.php">สถานที่ท่องเที่ยว</a>
                    </div>
                
                <div class="tag">
                        <a href="./foodpage.php">ร้านอาหาร</a>
                    </div>

                <div class="tag">
                        <a href="./clothing.php">ร้านบริการ</a>
                    </div>

                    <!-- พื้นที่สำหรับสร้างโพสต์ -->
                    <style>
                        #exampleFormControlTextarea1 {
                            height: 150px !important;
                        }
                    </style>
                    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title me-3">คุณอยากโพสต์อะไร</h5>


                                    <button type="button" class="btn-close mr-lg-2" data-bs-dismiss="modal" aria-label="Close"></button>

                                </div>
                                <form method="post" enctype="multipart/form-data" class="p-4">
                                    <div class="d-flex gap-2">
                                        <select id="locationDropdown" class="form-select option-container text-center rounded-pill mt-1 w-50" name="location" required>
                                            <option value="" disabled selected>กรุณาเลือกสถานที่</option>
                                            <?php foreach ($locations as $location) : ?>
                                                <option value="<?php echo $location; ?>"><?php echo $location; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="modal-body">
                                        <img src="" style="display: none;" id="post_img" class="w-100 rounded border">

                                        <div class="my-3">

                                            <input class="form-control" name="file" type="file" id="select_post_img" style="display: none;">
                                            <label for="select_post_img" class="d-flex justify-content-center">
                                                <i class="fa fa-image photo"></i>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label"></label>
                                            <textarea name="post" class="form-control h-50" id="exampleFormControlTextarea1" rows="1" placeholder="คุณกำลังคิดอะไรอยู่" required></textarea>
                                        </div>


                                        <div class="w-100 mx-auto mt-2 d-flex">
                                            <button name="post_button" type="submit" class="btn btn-primary mx-auto" id="post_button" value="Post">
                                                <div class="text-center">ยืนยัน</div>
                                            </button>
                                        </div>

                                </form>
                            </div>

                        </div>
                    </div>
                </div>


            </div>

            <div class="post-bottom">
                <!-- <div class="action">
            <i class="fa fa-video"></i>
            <span>Live video</span>
          </div> -->

                <!-- <div class="action">
            <i class="fa fa-smile"></i>
            <span>Feeling/Activity</span>
          </div> -->
            </div>
        </div>
        <!-- post area -->
        <?php

        if ($posts) {



            foreach ($posts as $ROW) {
                if (!empty($ROW['location_name']) && $ROW['status'] !== 'rejected') {
                    $user = new User();
                    $ROW_USER = $user->getUsers($ROW['user_id']);
                    include 'function.php';
                } elseif (empty($ROW['location_name']) && $ROW['status'] === 'approved') {
                    $user = new User();
                    $ROW_USER = $user->getUsers($ROW['user_id']);
                    include 'function.php';
                }
            }
        }

        # code...

        ?>
        <div class="modal fade" id="AddlocationModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title text-center mx-auto w-100">กรุณาเพิ่มสถานที่</h5>


                        <button type="button" class="btn-close mr-lg-2" data-bs-dismiss="modal" aria-label="Close"></button>

                    </div>
                    <form method="post" enctype="multipart/form-data" class="p-4" id="locationForm2">
                        <div class="my-3">
                            <label for="locationname" class="col-form-label">ชื่อสถานที่</label>
                            <input type="text" class="form-control ps-3 mx-auto" style="width: 95%;" id="locationname" name="location_name" placeholder="กรุณาใส่ชื่อสถานที่" required>
                        </div>

                        <div class="modal-body">
                            <img src="" style="display: none;" id="location_img" class="w-100 rounded border">

                            <div class="my-3">

                                <input class="form-control" name="file" type="file" id="select_location_img" style="display: none;" required>
                                <label for="select_location_img" class="d-flex justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor" class="bi bi-cloud-arrow-up text-center mx-auto" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd" d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z" />
                                        <path d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                    </svg>
                                </label>
                            </div>
                            <div class="my-3">
                                <label for="Map-link" class="col-form-label">Link GoogleMap</label>
                                <input type="text" class="form-control ps-3 mx-auto" style="width: 95%;" id="Map-link" name="Maplink" placeholder="กรุณาใส่ลิงค์ GoogleMap" required>
                            </div>
                        </div>

                        <div class="w-100 mx-auto mt-2 d-flex">
                            <button type="submit" name="addlocation" class="btn btn-primary mx-auto" id="location_submit">ยืนยัน</button>

                        </div>

                    </form>
                </div>

            </div>
        </div>

        <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content">
                    <form action="backend/comment.php" method="post" id="form-comment">
                        <div class="modal-header">
                            <h5 class="modal-title" id="commentModalLongTitle">แสดงความคิดเห็น</h5>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="content">ความคิดเห็น</label>
                                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
                            </div>
                            <input type="hidden" name="post_id" value="">
                            <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">บันทึก</button>
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

    </div>
    </div>





</body>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js" integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
</script>
<script src="./javascript/main.js"></script>
<script src="./javascript/hamburger.js"></script>
<script src="./javascript//search.js"></script>
<script src="./javascript/custom.js?v=<?= time() ?>"></script>

<script>
    document.addEventListener('DOMContentLoaded', async function() {
        let location_submit = document.getElementById('location_submit');
        if (location_submit) {
            location_submit.addEventListener('click', () => {
                validateAndSubmit();
            })
        }

        console.log("DOM fully loaded and parsed");

        document.querySelectorAll('.report-button').forEach(button => {
            button.addEventListener('click', function() {
                const postId = this.getAttribute('data-postid');
                const userSessionId = '<?php echo isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 'not set'; ?>';

                fetch('report_post.php', { // Ensure this is the correct path to your PHP script
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/x-www-form-urlencoded',
                        },
                        body: `post_id=${postId}&user_id=${userSessionId}`
                    })
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            Swal.fire({
                                icon: 'success',
                                title: 'รายงานสำเร็จ!',
                                text: 'รายงานโพสต์สำเร็จแล้วกรุณารอแอดมินตรวจสอบ!',
                                timer: 2000, // Auto close after 2 seconds
                                showConfirmButton: false // Hide the confirm button
                            });
                            const dropdown = button.closest('.posts').querySelector('.content-button');
                            dropdown.style.display = 'none';

                            console.log('Report submitted successfully', data);
                        } else {
                            Swal.fire('รายงานไม่สำเร็จ!', data.message, 'warning');
                            console.log('Error:', data.message);
                            const dropdown = button.closest('.posts').querySelector('.content-button');
                            dropdown.style.display = 'none';

                            // Handle error - you can display a message or update the UI
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        Swal.fire('Error', 'An error occurred. Please try again.', 'error');
                        // Handle fetch error - you can display a message or update the UI
                    });
            });
        });

        const textContainers = document.querySelectorAll('.text-container');

            textContainers.forEach(container => {
                const scrollHeight = container.scrollHeight;
                const clientHeight = container.clientHeight;

                if (scrollHeight > clientHeight) {
                    const showMoreBtn = document.createElement('button');
                    showMoreBtn.classList.add('show-more-btn');
                    showMoreBtn.innerText = 'ดูเพิ่มเติม...';

                    showMoreBtn.addEventListener('click', function () {
                        container.style.height = scrollHeight + 'px';
                        container.classList.add('expanded');
                        showMoreBtn.style.display = 'none'; // Hide the button after clicking
                    });

                    container.appendChild(showMoreBtn);
                } else {
                    container.style.height = 'auto'; // Set height to auto if content is less than 10vh
                }
            });

       
    });



    function validateAndSubmit() {
        var locationName = document.getElementById('locationname').value.trim();
        var mapLink = document.getElementById('Map-link').value.trim();
        var image = document.getElementById('select_location_img').files.length;

        console.log("Validation started");
        console.log("Location Name: " + locationName);
        console.log("Map Link: " + mapLink);
        console.log("Image Files Count: " + image);

        if (!locationName || !mapLink) {
            console.log("Validation failed: Name or Map link missing.");
            Swal.fire({
                icon: 'warning',
                title: 'แจ้งเตือน',
                text: 'กรุณากรอกชื่อสถานที่และลิงค์ Google Map!'
            });
        } else if (image === 0) {
            console.log("Validation failed: No image selected.");
            Swal.fire({
                icon: 'warning',
                title: 'แจ้งเตือน',
                text: 'กรุณาอัพโหลดรูปภาพ!'
            });
        } else {
            console.log("Validation passed, form will be submitted.");
            locationForm.submit();
        }
    }

    const postsubmit = document.getElementById('post_button');
    const locationSelect = document.getElementById('locationDropdown');
    if (postsubmit) {
        postsubmit.addEventListener('click', function(event) {
            if (!locationSelect.value) {
                event.preventDefault(); // Prevent form submission
                Swal.fire({
                    icon: 'error',
                    title: 'โพสต์ไม่สำเร็จกรุณาลองใหม่อีกครั้ง',
                    html: 'กรุณาเลือกสถานที่ที่ต้องการโพสต์หากไม่มีสถานที่<br>ที่คุณต้องการกรุณาทำการเพิ่มสถานที่ได้ที่หน้าหลัก',
                });
            }
        });

    }



    console.log(postSuccess);
    console.log(postlocationSuccess);
    if (postSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'โพสต์สำเร็จ',
            text: 'โพสต์สำเร็จแล้วกรุณารอทางAdmin อนุมัติ!!'
        });
    } else if (postlocationSuccess) {
        Swal.fire({
            icon: 'success',
            title: 'โพสต์สำเร็จ',
            text: 'โพสต์สำเร็จแล้ว!!'
        });
    }

    const toggleDropdowns = document.querySelectorAll('.fa-ellipsis');
    const showDropdowns = document.querySelectorAll('.content-button');

    toggleDropdowns.forEach((toggleDropdown, index) => {
        toggleDropdown.addEventListener('click', function() {
            if (showDropdowns[index].style.display === 'block') {
                showDropdowns[index].style.display = 'none';
            } else {
                showDropdowns[index].style.display = 'block';
            }
        });
    });

    $(document).ready(function() {

        $('.btn-like').click(function() {
            let $this = $(this);
            let post_id = $(this).data('id')
            let like_id = $(this).data('likeid')

            fetch('./backend/post.php?post_id=' + post_id + '&like_id=' + like_id)
                .then(
                    function(response) {
                        // Examine the text in the response
                        response.json().then(function(data) {
                            const likes = data.likes
                            const like_id = data.like_id

                            $($this).data('likeid', like_id)

                            if (like_id == '0') {
                                $($this).find('.bi-star-fill').removeClass('bi-star-fill').addClass('bi-star')

                            } else {
                                $($this).find('.bi-star').removeClass('bi-star').addClass('bi-star-fill')

                            }

                            if (likes == '0') {
                                $('#ele-' + post_id).html('')

                            } else if (likes == '1') {
                                let ele = "<span class='badge badge-dark like-count' id='post-" + post_id + "'>" + likes + "</span>"
                                $('#ele-' + post_id).html(ele)

                            } else {
                                $('#post-' + post_id).html(likes)
                            }

                        });
                    }
                )
                .catch(function(err) {
                    console.log('Fetch Error :-S', err);
                });
        })

        $('.btn-comment').click(function() {
            let post_id = $(this).data('id')
            $('input[name="post_id"]', $('#form-comment')).val(post_id)
            $('#commentModal').modal('show')
        })
    })
</script>

</html>