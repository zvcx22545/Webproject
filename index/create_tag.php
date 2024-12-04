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

$Gettag = new Tag();
$gettag = $Gettag->GetTag();


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['category']) && isset($_POST['nametag'])) {
        $category = $_POST['category'];
        $nameTag = $_POST['nametag'];
        // Check if the tagname already exists in the same category
        $checkQuery = $conn->prepare("SELECT COUNT(*) FROM subtag WHERE category = :category AND tagname = :tagname");
        $checkQuery->bindParam(":category", $category);
        $checkQuery->bindParam(":tagname", $nameTag);
        $checkQuery->execute();
        $tagExists = $checkQuery->fetchColumn();

        if ($tagExists) {
            echo json_encode(['success' => false, 'message' => 'Tagname นี้มีอยู่ใน หมวดหมู่นี้แล้ว กรุณาเพิ่ม Tagname อื่น']);
        } else {
            $query = $conn->prepare("INSERT INTO subtag (tagname, category, user_id) VALUES (:tagname, :category, :user_id)");
            $query->bindParam(":tagname", $nameTag);
            $query->bindParam(":category", $category);
            $query->bindParam(":user_id", $user_id);

            if ($query->execute()) {
                echo json_encode(['success' => true, 'message' => 'สร้างTagสำเร็จแล้วสามารถนำTag<br>ไปเพิ่มให้กับหมวดหมู่ย่อยได้!!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Category addition failed: ' . implode(";", $query->errorInfo())]);
            }
        }
        exit();
    } elseif (isset($_POST['EditTag']) && isset($_POST['EditCategory']) && isset($_POST['tagId'])) {
        $editTag = $_POST['EditTag'];
        $editCategory = $_POST['EditCategory'];
        $tagId = $_POST['tagId'];

        // Check if the tagname already exists in the same category, excluding the current tag ID
        $checkQuery = $conn->prepare("SELECT COUNT(*) FROM subtag WHERE category = :category AND tagname = :tagname AND id != :id");
        $checkQuery->bindParam(":category", $editCategory);
        $checkQuery->bindParam(":tagname", $editTag);
        $checkQuery->bindParam(":id", $tagId);
        $checkQuery->execute();
        $tagExists = $checkQuery->fetchColumn();

        if ($tagExists) {
            echo json_encode(['success' => false, 'message' => 'Tagname นี้มีอยู่ใน หมวดหมู่ นี้แล้ว กรุณาเพิ่ม Tagname อื่น']);
        } else {
            $query = $conn->prepare("UPDATE subtag SET tagname = :tagname, category = :category WHERE id = :id");
            $query->bindParam(":tagname", $editTag);
            $query->bindParam(":category", $editCategory);
            $query->bindParam(":id", $tagId);

            if ($query->execute()) {
                echo json_encode(['success' => true, 'message' => 'แก้ไช Tag สำเร็จแล้ว!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Tag update failed: ' . implode(";", $query->errorInfo())]);
            }
        }
        exit();
    }
}



$count = 0;
if ($gettag) {
    foreach ($gettag as $tags) {
        if ($tags['id'])
            $count++;
    }

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
                            <h4>ทั้งหมด : โพสต์</h4><?php echo $count; ?>
                        </div>
                    </div>
                    <div class="tableMember">
                        <table>
                            <tr>
                                <th class="col0">No.</th>
                                <th class="col1">ชื่อ-นามสกุล</th>
                                <th class="col1">ชื่อ Tag</th>
                                <th class="col1">Tag_ID</th>
                                <th class="col4">User_ID</th>
                                <th class="col4">หมวดหมู่</th>
                                <th class="col4">วันที่สร้าง Tag</th>
                                <th class="col2">แก้ไข</th>
                            </tr>
                            <tbody id="locationTable">


                                <?php
                                // $post = new Post();
                                // $posts = $post->getAllPosts();
                                $displayedIndex = 0;


                                if (!empty($gettag)): ?>
                                    <?php foreach ($gettag as $Tag):

                                        // Increment the displayed index only when a post is displayed
                                        $displayedIndex++;
                                        $util = new Util();
                                        $create_date = $util->coverdate($Tag['create_at']);
                                        $user = new User();
                                        $ROW_USER = $user->getUsers($Tag['user_id']); ?>

                                        <tr>
                                            <td><?php echo $displayedIndex;
                                            ; ?></td>
                                            <td><?php echo $ROW_USER['first_name'] . " " . $ROW_USER['last_name'] ?></td>
                                            <td><?php echo $Tag['tagname']; ?></td>
                                            <td><?php echo $Tag['id']; ?></td>
                                            <td><?php echo $Tag['user_id']; ?></td>
                                            <td>
                                                <?php
                                                if ($Tag['category'] === 'food') {
                                                    echo 'อาหาร';
                                                } elseif ($Tag['category'] === 'travel') {
                                                    echo 'สถานที่ท่องเที่ยว';
                                                } elseif ($Tag['category'] === 'clothing') {
                                                    echo 'บริการ';
                                                } else {
                                                    echo $Tag['category']; // default to showing the raw category if it doesn't match any of the expected values
                                                }
                                                ?>
                                            </td>

                                            <td><?php echo $create_date; ?></td>
                                            <div class="edit-icon ">
                                                <td class="w-[5%]">
                                                    <svg class='cursor-pointer edit-icon w-[40%]'
                                                        data-tag-id='<?php echo $Tag['id']; ?>'
                                                        data-tag-name='<?php echo $Tag['tagname']; ?>'
                                                        data-category='<?php echo $Tag['category']; ?>' xmlns:dc="http://purl.org/dc/elements/1.1/" xmlns:cc="http://creativecommons.org/ns#" xmlns:rdf="http://www.w3.org/1999/02/22-rdf-syntax-ns#" xmlns:svg="http://www.w3.org/2000/svg" xmlns="http://www.w3.org/2000/svg" xmlns:sodipodi="http://sodipodi.sourceforge.net/DTD/sodipodi-0.dtd" xmlns:inkscape="http://www.inkscape.org/namespaces/inkscape" viewBox="0 0 16.933333 21.1666675" version="1.1" x="0px" y="0px"><g transform="translate(0,-280.06665)"><path style="color:#000000;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:medium;line-height:normal;font-family:sans-serif;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-feature-settings:normal;text-indent:0;text-align:start;text-decoration:none;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000000;letter-spacing:normal;word-spacing:normal;text-transform:none;writing-mode:lr-tb;direction:ltr;text-orientation:mixed;dominant-baseline:auto;baseline-shift:baseline;text-anchor:start;white-space:normal;shape-padding:0;clip-rule:nonzero;display:inline;overflow:visible;visibility:visible;opacity:1;isolation:auto;mix-blend-mode:normal;color-interpolation:sRGB;color-interpolation-filters:linearRGB;solid-color:#000000;solid-opacity:1;vector-effect:none;fill:#000000;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.52900004;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:normal;color-rendering:auto;image-rendering:auto;shape-rendering:auto;text-rendering:auto;enable-background:accumulate" d="m 9.54493,281.12498 a 0.26451098,0.26453254 0 0 0 -0.18552,0.078 l -6.64817,6.64663 a 0.26451098,0.26453254 0 0 0 0,0.37516 l 3.92844,3.92844 c 1.26349,-1.26304 2.58044,-2.57945 3.95997,-3.95841 0.14485,-0.14567 0.34472,-0.23209 0.55293,-0.23409 0.21346,-0.002 0.41575,0.081 0.56793,0.23254 a 0.52921962,0.52921962 0 0 1 0.002,0 l 0.18655,0.18655 2.31304,-2.31355 a 0.26451098,0.26453254 0 0 0 0.078,-0.18758 v -4.49017 a 0.26451098,0.26453254 0 0 0 -0.26562,-0.26355 z m 1.84847,1.84847 c 0.26959,-3.6e-4 0.53905,0.10287 0.74672,0.31057 v -0.002 c 0.4153,0.41542 0.4153,1.08061 0,1.49603 -0.41533,0.41626 -1.07812,0.41439 -1.49345,-0.001 -0.41531,-0.41542 -0.41531,-1.077 0,-1.49242 0.20767,-0.20728 0.47713,-0.31125 0.74673,-0.3116 z"/><path style="color:#000000;font-style:normal;font-variant:normal;font-weight:normal;font-stretch:normal;font-size:medium;line-height:normal;font-family:sans-serif;font-variant-ligatures:normal;font-variant-position:normal;font-variant-caps:normal;font-variant-numeric:normal;font-variant-alternates:normal;font-feature-settings:normal;text-indent:0;text-align:start;text-decoration:none;text-decoration-line:none;text-decoration-style:solid;text-decoration-color:#000000;letter-spacing:normal;word-spacing:normal;text-transform:none;writing-mode:lr-tb;direction:ltr;text-orientation:mixed;dominant-baseline:auto;baseline-shift:baseline;text-anchor:start;white-space:normal;shape-padding:0;clip-rule:nonzero;display:inline;overflow:visible;visibility:visible;opacity:1;isolation:auto;mix-blend-mode:normal;color-interpolation:sRGB;color-interpolation-filters:linearRGB;solid-color:#000000;solid-opacity:1;vector-effect:none;fill:#000000;fill-opacity:1;fill-rule:nonzero;stroke:none;stroke-width:0.52899998;stroke-linecap:round;stroke-linejoin:round;stroke-miterlimit:4;stroke-dasharray:none;stroke-dashoffset:0;stroke-opacity:1;paint-order:normal;color-rendering:auto;image-rendering:auto;shape-rendering:auto;text-rendering:auto;enable-background:accumulate" d="m 11.15817,288.4899 c -0.0701,8e-4 -0.13596,0.0292 -0.18448,0.078 -0.32564,0.32551 -0.60931,0.60894 -0.93483,0.9343 l 2.24534,2.24534 c 0.31143,-0.31142 0.62287,-0.62291 0.93431,-0.9343 0.10359,-0.10303 0.10356,-0.27056 5.2e-4,-0.37415 l -1.87121,-1.87171 c -0.0507,-0.0505 -0.11957,-0.0783 -0.18965,-0.0775 z m -1.49344,1.38649 c -1.2992,1.29857 -2.62809,2.62684 -3.74396,3.7424 -0.0492,0.05 -0.0765,0.11747 -0.076,0.18759 v 1.87121 c 2.7e-4,0.1455 0.11802,0.2635 0.26355,0.26406 h 1.87121 c 0.0702,3.9e-4 0.13768,-0.0271 0.18758,-0.0765 1.24745,-1.24788 2.49529,-2.49573 3.74292,-3.74343 z"/></g><text x="0" y="31.933334" fill="#000000" font-size="5px" font-weight="bold" font-family="'Helvetica Neue', Helvetica, Arial-Unicode, Arial, Sans-serif">Created by Ranah Pixel Studio</text><text x="0" y="36.933334" fill="#000000" font-size="5px" font-weight="bold" font-family="'Helvetica Neue', Helvetica, Arial-Unicode, Arial, Sans-serif"></text>
                                                        </svg>
                                                </td>
                                            </div>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="7">No Tag found.</td>
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
                                    <input id="locationInput" class="form-control w-1/2 rounded-[4px] px-2 py-1 w-full" name="d"
                                        placeholder="กรุณากรอกชื่อ Tags" required>
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


        <?php if (!empty($gettag)): ?>
            <?php foreach ($gettag as $index => $Tag): ?>
                <div class="fixed inset-0 flex items-center justify-center z-50 bg-black bg-opacity-50" id="EditModal" style="display: none;">
    <div class="bg-white rounded-lg overflow-hidden shadow-xl transform transition-all sm:max-w-lg sm:w-full">
        <div class="bg-white p-6">
            <div class="flex items-start justify-between w-full">
                <h5 class="text-lg font-medium leading-6 text-gray-900 w-full">แก้ไข Tag</h5>
                <button type="button" class="text-gray-400 hover:text-gray-500 w-full" id="close1" aria-label="Close">
                    <span class="sr-only">Close</span>
                    <svg class="h-6 w-6 ml-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <form method="post" enctype="multipart/form-data" id="EdittagForm" class="mt-4">
                <input type="hidden" name="tagId" id="editTagId">
                <div class="">
                    <input id="EditTagInput" class="form-control w-1/2 rounded-[4px] px-2 py-1 w-full" name="EditTag" placeholder="กรุณากรอกชื่อ Tags">
                </div>
                <div class="mt-4">
                    <select class="category-dropdowns flex w-1/2 py-2 px-3 rounded-lg" name="EditCategory" id="EditCategoryDropdown">
                        <option disabled selected>หมวดหมู่</option>
                        <option value="food">อาหาร</option>
                        <option value="clothing">บริการ</option>
                        <option value="travel">สถานที่ท่องเที่ยว</option>
                    </select>
                    <div class="w-full flex justify-center mt-5">
                        <button name="Edit_button" type="submit" class="text-white w-1/3 bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2" id="Edit_button" value="Post">
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
            <div class="text2xl font-semibold text-red-900">No tags found.</div>
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
        let modal = document.getElementById('postModal');
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

            const editIcons = document.querySelectorAll('.edit-icon');
    const modal1 = document.getElementById('EditModal');
    const closeModal = document.getElementById('close1');
    const editTagInput = document.getElementById('EditTagInput');
    const editTagIdInput = document.getElementById('editTagId');
    const editCategoryDropdown = document.getElementById('EditCategoryDropdown');

    editIcons.forEach(icon => {
        icon.addEventListener('click', function (event) {
            event.preventDefault();
            const tagId = this.getAttribute('data-tag-id');
            const tagName = this.getAttribute('data-tag-name');
            const category = this.getAttribute('data-category');

            editTagInput.value = tagName;
            editTagIdInput.value = tagId;
            editCategoryDropdown.value = category;

            modal1.style.display = 'flex';
        });
    });

    closeModal.addEventListener('click', function () {
        modal1.style.display = 'none';

    });

    $(document).ready(function () {
        $('#tagForm').on('submit', function (event) {
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
                success: function (response) {
                    var result = JSON.parse(response);
                    if (result.success) {
                        Swal.fire({
                            icon: 'success',
                            title: 'สร้างTagสำเร็จ',
                            html: result.message
                        }).then(() => {
                            // Reload the website after the alert is closed
                            location.reload();
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: result.message
                        });
                    }
                },
                error: function (xhr, status, error) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Category addition failed: ' + xhr.responseText
                    });
                }
            });
        });

        $('#EdittagForm').on('submit', function (event) {
        event.preventDefault();
        var editTag = $('#EditTagInput').val();
        var editCategory = $('#EditCategoryDropdown').val();
        var tagId = $('#editTagId').val();

        $.ajax({
            url: 'create_tag.php',
            type: 'POST',
            data: {
                EditTag: editTag,
                EditCategory: editCategory,
                tagId: tagId
            },
            success: function (response) {
                var result = JSON.parse(response);
                if (result.success) {
                    Swal.fire({
                        icon: 'success',
                        title: 'แก้ไข Tag สำเร็จ!',
                        html: result.message
                    }).then(() => {
                        location.reload();
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: result.message
                    });
                }
            },
            error: function (xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Tag update failed: ' + xhr.responseText
                });
            }
        });
    });
});
    });


    $(document).ready(function () {
        var locations = <?php echo json_encode($gettag); ?>;
        $("#locationInput").autocomplete({
            source: locations,
            select: function (event, ui) {
                // Set the value of the input to the selected item
                $("#locationInput").val(ui.item.value);
                return false;
            }
        });

        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#locationTable tr").filter(function () {
                var Nametag = $(this).find("td:nth-child(3)").text().toLowerCase();
                var TagId = $(this).find("td:nth-child(4)").text().toLowerCase();
                var Category = $(this).find("td:nth-child(6)").text().toLowerCase();
                $(this).toggle(Nametag.indexOf(value) > -1 || TagId.indexOf(value) > -1 || Category.indexOf(value) > -1);
            });
        });
    });


</script>