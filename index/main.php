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



        <div
            class="container-fluid d-flex flex-wrap align-items-center justify-content-center justify-content-sm-start justify-content-start ">

            <div class="logo text-left col-12 col-lg-auto"><a href="./main.php" class="nav-link">Travel to Knowledge</a>
            </div>

            <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0 navbars">
                <li><a href="./main.php"
                        class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'main.php' ? 'active' : ''; ?>"><i
                            class="fa fa-home"></i></a></li>
                <li><a href="./travel.php"
                        class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'travel.php' ? 'active' : ''; ?>"><i
                            class="fa-solid fa-mountain-sun"></i></a></li>
                <li><a href="./foodpage.php"
                        class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'foodpage.php' ? 'active' : ''; ?>"><i
                            class="fa-solid fa-utensils"></i></a></li>
                <li><a href="./clothing.php"
                        class="nav-link px-2 <?php echo basename($_SERVER['PHP_SELF']) == 'shirt.php' ? 'active' : ''; ?>"><i
                            class="fa-solid fa-shirt"></i></a></li>
                <button class="navbar-toggler" type="button">
                    <i class="fa-solid fa-bars"></i>
                </button>
            </ul>

            <div class="collapse navbar-collapse w-auto" id="navbarSupportedContent">

                <form class="d-flex mt-3 mt-lg-0 ms-auto search" role="search" action="search.php" method="POST">
                    <input class="form-control me-2 rounded-pill" type="search" placeholder="ค้นหาสถานที่"
                        aria-label="Search" name="search" id="search" autocomplete="off" required>
                    <button class="btn btn-outline-light me-2" type="submit" name="submit"><svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-search" viewBox="0 0 16 16">
                            <path
                                d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z" />
                        </svg></button>

                        <div class="list-groups" id="show-list"> 

                        </div>
                </form>


                <div class="text-center">
                    <button type="button" class="btn btn-outline-light"><a class="nav-link" href="./logout.php"
                            id="logout">Logout</a></button>
                </div>
                <div class="icon text-white me-2 px-3"><i class="fa-solid fa-sun" id="theme"></i></div>

            </div>

        </div>

    </header>

    <div class="container ">
        <script>
            <?php if (isset($_SESSION['post_location']) && $_SESSION['post_location']): ?>
                var postlocationSuccess = true;
                <?php unset($_SESSION['post_location']); ?>
            <?php else: ?>
                var postlocationSuccess = false;
            <?php endif; ?>

            <?php if (isset($_SESSION['post_success']) && $_SESSION['post_success']): ?>
                var postSuccess = true;
                <?php unset($_SESSION['post_success']); ?>
            <?php else: ?>
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
                    <button class="btn location btn-outline-light w-100 mt-2" data-bs-target="#AddlocationModal"
                        data-bs-toggle="modal" data-bs-dismiss="modal">
                        <div class="icons h-25 w-100 d-flex align-items-center justify-content-center">
                            <div class="text-center" style="font-size:16px;">เพิ่มสถานที่</div>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="icon">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1 1 15 0Z" />
                            </svg>
                        </div>

                    </button>
                </div>




            </ul>


        </div>

        <div class="container-post">
            <!-- พื่นที่สำหรับสร้างโพสต์ -->
            <div class="post create" style="margin-top:70px;">
                <div class="post-top">
                    <div class="dp">
                        <img src="<?php echo $corner_image ?>" type="images" alt="">
                    </div>

                    <input type="text" placeholder="คุณอยากจะโพสต์อะไร" data-bs-toggle="modal"
                        data-bs-target="#postModal" readonly style="cursor: pointer;" />

                    <!-- พื้นที่สำหรับสร้างโพสต์ -->
                    <style>
                        #exampleFormControlTextarea1 {
                            height: 150px !important;
                        }
                    </style>
                    <div class="modal fade" id="postModal" tabindex="-1" aria-labelledby="exampleModalLabel"
                        aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title me-3">คุณอยากโพสต์อะไร</h5>


                                    <button type="button" class="btn-close mr-lg-2" data-bs-dismiss="modal"
                                        aria-label="Close"></button>

                                </div>
                                <form method="post" enctype="multipart/form-data" class="p-4">
                                    <div class="d-flex gap-2">
                                        <!-- <select id="categoryDropdown" required
                                            class="form-select option-container text-center rounded-pill mt-1 w-50 "
                                            name="category">
                                            <option value="" disabled selected>หมวดหมู่</option>
                                            <option value="clothing">Clothing</option>
                                            <option value="travel">Travel</option>
                                            <option value="food">Food</option>
                                        </select> -->
                                        <select id="locationDropdown"
                                            class="form-select option-container text-center rounded-pill mt-1 w-50"
                                            name="location" required>
                                            <option value="" disabled selected>กรุณาเลือกสถานที่</option>
                                            <?php foreach ($locations as $location): ?>
                                                <option value="<?php echo $location; ?>"><?php echo $location; ?></option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>

                                    <div class="modal-body">
                                        <img src="" style="display: none;" id="post_img" class="w-100 rounded border">

                                        <div class="my-3">

                                            <input class="form-control" name="file" type="file" id="select_post_img"
                                                style="display: none;">
                                            <label for="select_post_img" class="d-flex justify-content-center">
                                                <i class="fa fa-image photo"></i>
                                            </label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="exampleFormControlTextarea1" class="form-label"></label>
                                            <textarea name="post" class="form-control h-50"
                                                id="exampleFormControlTextarea1" rows="1"
                                                placeholder="คุณกำลังคิดอะไรอยู่" required></textarea>
                                        </div>


                                        <div class="w-100 mx-auto mt-2 d-flex">
                                            <button name="post_button" type="submit" class="btn btn-primary mx-auto" onclick="ValidationPost()"
                                                id="post_button" value="Post">
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
                <div class="action mx-auto">
                    <i class="fa fa-image"></i>
                    <span>Photo</span>
                </div>
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
        <div class="modal fade" id="AddlocationModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header ">
                        <h5 class="modal-title text-center mx-auto w-100">กรุณาเพิ่มสถานที่</h5>


                        <button type="button" class="btn-close mr-lg-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>

                    </div>
                    <form method="post" enctype="multipart/form-data" class="p-4" id="locationForm2">
                        <div class="my-3">
                            <label for="locationname" class="col-form-label">ชื่อสถานที่</label>
                            <input type="text" class="form-control ps-3 mx-auto" style="width: 95%;" id="locationname"
                                name="location_name" placeholder="กรุณาใส่ชื่อสถานที่" required>
                        </div>

                        <div class="modal-body">
                            <img src="" style="display: none;" id="location_img" class="w-100 rounded border">

                            <div class="my-3">

                                <input class="form-control" name="file" type="file" id="select_location_img"
                                    style="display: none;" required>
                                <label for="select_location_img" class="d-flex justify-content-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="30" height="30" fill="currentColor"
                                        class="bi bi-cloud-arrow-up text-center mx-auto" viewBox="0 0 16 16">
                                        <path fill-rule="evenodd"
                                            d="M7.646 5.146a.5.5 0 0 1 .708 0l2 2a.5.5 0 0 1-.708.708L8.5 6.707V10.5a.5.5 0 0 1-1 0V6.707L6.354 7.854a.5.5 0 1 1-.708-.708l2-2z" />
                                        <path
                                            d="M4.406 3.342A5.53 5.53 0 0 1 8 2c2.69 0 4.923 2 5.166 4.579C14.758 6.804 16 8.137 16 9.773 16 11.569 14.502 13 12.687 13H3.781C1.708 13 0 11.366 0 9.318c0-1.763 1.266-3.223 2.942-3.593.143-.863.698-1.723 1.464-2.383zm.653.757c-.757.653-1.153 1.44-1.153 2.056v.448l-.445.049C2.064 6.805 1 7.952 1 9.318 1 10.785 2.23 12 3.781 12h8.906C13.98 12 15 10.988 15 9.773c0-1.216-1.02-2.228-2.313-2.228h-.5v-.5C12.188 4.825 10.328 3 8 3a4.53 4.53 0 0 0-2.941 1.1z" />
                                    </svg>
                                </label>
                            </div>
                            <div class="my-3">
                                <label for="Map-link" class="col-form-label">Link GoogleMap</label>
                                <input type="text" class="form-control ps-3 mx-auto" style="width: 95%;" id="Map-link"
                                    name="Maplink" placeholder="กรุณาใส่ลิงค์ GoogleMap" required>
                            </div>
                        </div>

                        <div class="w-100 mx-auto mt-2 d-flex">
                            <button type="submit" name="addlocation" class="btn btn-primary mx-auto"
                                id="location_submit">ยืนยัน</button>

                        </div>

                    </form>
                </div>

            </div>
        </div>

        <div class="modal fade" id="commentModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
            aria-hidden="true">
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

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
    integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
    integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous">
    </script>
<script src="./javascript/main.js"></script>
<script src="./javascript/hamburger.js"></script>
<script src="./javascript//search.js"></script>
<script src="./javascript/custom.js?v=<?= time() ?>"></script>

<script>

    document.addEventListener('DOMContentLoaded', async function () {
        let location_submit = document.getElementById('location_submit');
        if (location_submit) {
            location_submit.addEventListener('click', () => {
                validateAndSubmit();
            })
        }

        console.log("DOM fully loaded and parsed");

        document.querySelectorAll('.report-button').forEach(button => {
            button.addEventListener('click', function () {
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

    const ValidationPost = () => {
    const postsubmit = document.getElementById('post_button');
    const locationSelect = document.getElementById('locationDropdown');
    
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
        toggleDropdown.addEventListener('click', function () {
            if (showDropdowns[index].style.display === 'block') {
                showDropdowns[index].style.display = 'none';
            } else {
                showDropdowns[index].style.display = 'block';
            }
        });
    });

    $(document).ready(function () {

        $('.btn-like').click(function () {
            let $this = $(this);
            let post_id = $(this).data('id')
            let like_id = $(this).data('likeid')

            fetch('./backend/post.php?post_id=' + post_id + '&like_id=' + like_id)
                .then(
                    function (response) {
                        // Examine the text in the response
                        response.json().then(function (data) {
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
                .catch(function (err) {
                    console.log('Fetch Error :-S', err);
                });
        })

        $('.btn-comment').click(function () {
            let post_id = $(this).data('id')
            $('input[name="post_id"]', $('#form-comment')).val(post_id)
            $('#commentModal').modal('show')
        })
    })
</script>

</html>