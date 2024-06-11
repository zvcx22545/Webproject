<?php
require_once 'autoload.php';
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
    header('location:login.php');
}




// Handle both status and category updates
// Handle status updates

if (isset($_SESSION['admin_login'])) {
    // แสดงข้อมูลของผู้ใช้ที่ล็อกอินเข้าระบบ
    $user_session_id = $_SESSION['admin_login'];
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
}


// GetLocation
$location = new Location();
$locations = $location->GetAllLocation();


if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['category']) && isset($_POST['nametag'])) {
    $category = $_POST['category'];
    $nameTag = $_POST['nametag'];

    $query = $conn->prepare("INSERT INTO subtag (tagname, category) VALUES (:tagname, :category)");
    $query->bindParam(":tagname", $nameTag);
    $query->bindParam(":category", $category);

    if ($query->execute()) {
        echo json_encode(['success' => true, 'message' => 'สร้างTagสำเร็จ.']);
        header('location:create_tag.php');
    } else {
        echo json_encode(['success' => false, 'message' => 'Category addition failed: ' . implode(";", $query->errorInfo())]);
    }
    exit();
}
$count = 0;


?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin page</title>
    <link rel="stylesheet" href="./style/admin.css">
    <link rel="stylesheet" href="./style/sidebar.css">
    <link rel="stylesheet" href="./style/post.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css"
        integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script src="https://cdn.tailwindcss.com"></script>

</head>

<body class="hold-transition sidebar-mini bg-zinc-100">
    <div class="container">
        <?php
        if (isset($_SESSION['admin_login'])) {
            $admin_id = $_SESSION['admin_login'];
            $stmt = $conn->query("SELECT * FROM users WHERE id =  $admin_id");
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);
        }

        ?>

        <script>
            <?php if (isset($_SESSION['tagcreate_success'])): ?>
                var createTagsuccess = true;
                <?php unset($_SESSION['tagcreate_success']); ?>
            <?php else: ?>
                var createTagsuccess = false;
            <?php endif; ?>

        </script>

        <div class="container">
            <div class="left bg-white">
                <!-- ส่วนทางซ้าย -->
                <h1 class="logo"></h1>
                <div class="main">
                    <br>
                    <ul class="menu">
                        <a href="./admin.php"><button class="none-active " id="teamButton"><i
                                    class="fa-solid fa-map-location-dot"></i></i>จัดการสถานที่</button></a>
                    </ul>
                    <ul class="menu">
                        <a href="./managepost.php"><button class="none-active" id="competitionButton"><i
                                    class="bi bi-boxes"></i>จัดการโพสต์</button></a>
                    </ul>
                    <ul class="menu">
                        <a href="./ReportPost.php"><button class="none-active" id="competitionButton"><i
                                    class="bi bi-boxes"></i>รายงานการโพสต์</button></a>
                    </ul>
                    <ul class="menu">
                        <a href="./create_tag.php"><button class="active p-2" id="competitionButton"><i
                                    class="fa-solid fa-tags"></i>จัดการ Tags</button></a>
                    </ul>

                    <ul class="menu">
                    </ul>
                    <button class="logout" type="button"><a href="./logout.php">
                            <p><i class="bi bi-arrow-bar-right"></i>Log out</p>
                        </a>
                    </button>
                </div>
            </div>
            <div class="right">
                <!-- ส่วนทางขวา -->
                <nav class="flex">
                    <h1 id="pageTitle" class="text-2xl w-1/2">จัดการ Tags</h1>
                    <div class="container-btn w-1/2 flex gap-10 justify-end items-center">
                        <button class="custom-btn btn-12" id="OpenModal">
                            <span>สร้าง!</span><span>สร้าง Tags</span>
                        </button>

                        <div class="search-box">
                            <button class="btn-search"><i class="fas fa-search"></i></button>
                            <input type="text" class="input-search" placeholder="ค้นหาสถานที่ ..." id="searchInput">
                        </div>
                    </div>
                </nav>

                <div class="admin-data">
                    <div class="top-data">
                        <div class="listMenu">
                            <h4>ทั้งหมด :  โพสต์</h4><?php echo $count; ?>
                        </div>
                    </div>
                    <div class="tableMember">
                        <table>
                            <tr>
                                <th class="col0">No.</th>
                                <th class="col1">ชื่อ-นามสกุล</th>
                                <th class="col4">User_ID</th>
                                <th class="col4">Post_ID</th>
                                <th class="col4">ชื่อสถานที่</th>
                                <th class="col4">ข้อความโพสต์</th>
                                <th class="col2">รูปภาพ</th>
                                <th class="col2">สถานะ</th>
                                <th class="col2">แก้ไข</th>
                            </tr>
                            <tbody id="locationTable">


                                <?php
                                // $post = new Post();
                                // $posts = $post->getAllPosts();
                                $displayedIndex = 0;


                                if (!empty($posts)): ?>
                                    <?php foreach ($posts as $post):
                                        if ((!empty($post['is_profile_image']) && $post['is_profile_image'] == 1) || (!empty($post['is_cover_image']) && $post['is_cover_image'] == 1)) {
                                            continue; // Skip this iteration and move to the next post
                                        }
                                        // Increment the displayed index only when a post is displayed
                                        $displayedIndex++;

                                        $user = new User();
                                        $ROW_USER = $user->getUsers($post['user_id']); ?>

                                        <tr>
                                            <td><?php echo $displayedIndex;
                                            ; ?></td>
                                            <td><?php echo $ROW_USER['first_name'] . " " . $ROW_USER['last_name'] ?></td>
                                            <td><?php echo $post['user_id']; ?></td>
                                            <td><?php echo $post['postid']; ?></td>
                                            <td><?php echo $post['location_name']; ?></td>
                                            <td class="w-[20%]">
                                                <div class=" w-[200px] truncate"><?php echo $post['post']; ?></div>
                                            </td>
                                            <td class='w-[10%]'>
                                                <img class='w-[30%] h-[20%] clickable-image' src="<?php echo $post['image']; ?>"
                                                    alt="post Image" onclick="zoomImage('<?php echo $post['image']; ?>')">
                                            </td>

                                            <td>
                                                <select class="status-dropdown" data-post-id="<?php echo $post['postid']; ?>">
                                                    <!-- <option value="pending" <?php echo $post['status'] === 'pending' ? 'selected' : ''; ?>>รอดำเนินการ</option> -->
                                                    <option value="approved" <?php echo $post['status'] === 'approved' ? 'selected' : ''; ?>>อนุมัติ</option>
                                                    <option value="rejected" <?php echo $post['status'] === 'rejected' ? 'selected' : ''; ?>>ไม่อนุมัติ</option>
                                                </select>
                                            </td>
                                            <td class="w-[5%]">
                                                <div class="edit-icon ">
                                                    <?php echo
                                                        "<a  href='edit.php?id=$post[postid]'><i class='fa-solid fa-pen-to-square'></i></a>";
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No posts found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>

        </div>
        <?php if (!empty($locations)): ?>
            <?php foreach ($locations as $index => $location): ?>
                <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" id="postModal"
                    style="display: none;">
                    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
                        <div class="bg-white p-6">
                            <div class="flex items-start justify-between w-full">
                                <h5 class="text-lg font-medium leading-6 text-gray-900 w-full">สร้าง Tags ให้กับสถานที่</h5>
                                <button type="button" class="text-gray-400 hover:text-gray-500 w-full" data-bs-dismiss="modal"
                                    aria-label="Close">
                                    <span class="sr-only">Close</span>
                                    <svg class="h-6 w-6 ml-auto" id="close" xmlns="http://www.w3.org/2000/svg" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>
                            </div>
                            <form method="post" enctype="multipart/form-data" id="tagForm" class="mt-4">
                                <div class="">
                                    <input id="locationInput" class="form-control w-1/2 rounded-[4px] px-2 py-1 w-full"
                                        name="d" placeholder="กรุณากรอกชื่อ Tags" required>
                                    <span class="advice text-red-900 text-xs inline-block mt-2 items-center">*
                                        กรุณากรอกชื่อ Tag ให้สอดคล้องกับสถานที่</span>
                                </div>
                                <div class="mt-4">

                                    <div class="mb-3">
                                        <select class="category-dropdown flex w-1/2 py-2 px-3 rounded-lg">
                                            <option disabled selected>หมวดหมู่</option>
                                            <option value="food" <?php echo $location['category_name'] === 'food' ? 'selected' : ''; ?>>อาหาร</option>
                                            <option value="clothing" <?php echo $location['category_name'] === 'clothing' ? 'selected' : ''; ?>>บริการ</option>
                                            <option value="travel" <?php echo $location['category_name'] === 'travel' ? 'selected' : ''; ?>>สถานที่ท่องเที่ยว</option>
                                        </select>
                                    </div>
                                    <div class="w-full flex justify-center mt-2">
                                        <button name="post_button" type="submit"
                                            class="text-white w-1/3 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2"
                                            id="post_button" value="Post">
                                            <div class="text-center text-[18px]">ยืนยัน</div>
                                        </button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>

            <div class="text2xl font-semibold text-red-900">No categoryy found.</div>
        <?php endif; ?>








    </div>
</body>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<!-- SCRIPTS -->
<script src="./javascript/no-table.js"></script>
<script src="./javascript/details.js"></script>
<script src="./javascript/search.js"></script>
<script src="./javascript/preview.js"></script>
<script src="./javascript/Approval.js"></script>

<!-- <script src="./javascript/admin-page.js"></script> -->



</html>

<script>


    document.addEventListener('DOMContentLoaded', function () {
        // modal
        const close = document.getElementById('close');
        const modal = document.getElementById('postModal');
        const Openmodal = document.getElementById('OpenModal');
        if (modal) {
            close.addEventListener('click', function () {
                modal.style.display = "none";
            });

        }

        if (Openmodal)
            Openmodal.addEventListener('click', function () {
                modal.style.display = "flex";
            });


    });

    
    if (createTagsuccess) {
            Swal.fire({
                icon: 'success',
                title: 'สร้างTagสำเร็จ',
                text: 'สร้างTagสำเร็จแล้วสามารถนำTagไปเพิ่มให้กับหมวดหมู่ย่อยได้!!'
            });
        }
    

        $(document).ready(function() {
    $('#tagForm').on('submit', function(event) {
        event.preventDefault(); // Prevent default form submission

        var category = $('.category-dropdown').val();
        var nameTag = $('#locationInput').val(); // Get the tagname from the input field

        $.ajax({
            url: 'create_tag.php', // This script will handle the request
            type: 'POST',
            data: {
                category: category,
                nametag: nameTag
            },
            success: function(response) {
                var result = JSON.parse(response);
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'สร้างTagสำเร็จ',
                        text: result.message
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Category addition failed: ' + xhr.responseText
                });
            }
        });
    });
});

</script>