<?php
require_once 'autoload.php';
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
    header('location:login.php');
}


// Handle both status and category updates
// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['locationId'])) {
    global $conn;

    $locationId = $_POST['locationId'];

    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        $query = $conn->prepare("UPDATE locations SET status = :status WHERE id = :locationId");
        $query->bindParam(":status", $status);
        $query->bindParam(":locationId", $locationId);

        if ($query->execute()) {
            echo 'Status update successful.';
        } else {
            echo 'Status update failed: ' . implode(";", $query->errorInfo());
        }
    }

    if (isset($_POST['category'])) {
        $category = $_POST['category'];
        $query = $conn->prepare("UPDATE locations SET category_name = :category WHERE id = :locationId");
        $query->bindParam(":category", $category);
        $query->bindParam(":locationId", $locationId);

        if ($query->execute()) {
            echo 'Category update successful.';
        } else {
            echo 'Category update failed: ' . implode(";", $query->errorInfo());
        }
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
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
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


        $location = new Location();
        $locations = $location->GetAllLocation();
        ?>

        <div class="container">
            <div class="left bg-white">
                <!-- ส่วนทางซ้าย -->
                <h1 class="logo"></h1>
                <div class="main">
                    <br>
                    <ul class="menu">
                        <a href="./admin.php"><button class="active p-2" id="teamButton"><i
                                    class="fa-solid fa-map-location-dot"></i>จัดการสถานที่</button></a>

                    </ul>
                    <ul class="menu">
                        <a href="./managepost.php"><button class="none-active" id="competitionButton"
                                onclick="changePage('competition')"><i class="bi bi-boxes"></i>จัดการโพสต์</button></a>
                    </ul>
                    <ul class="menu">
                        <a href="./ReportPost.php"><button class="none-active" id="competitionButton"
                                onclick="changePage('competition')"><i class="bi bi-boxes"></i>รายงานโพสค์</button></a>
                    </ul>
                    <ul class="menu">
                        <a href="./create_tag.php"><button class="none-active" id="competitionButton"><i
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
                <nav>
                    <h1 id="pageTitle" class="text-2xl">จัดการสถานที่</h1>
                    <div class="search-box">
                        <button class="btn-search"><i class="fas fa-search"></i></button>
                        <input type="text" class="input-search" placeholder="ค้นหาสถานที่ ..." id="searchInput">
                    </div>
                </nav>

                <div class="admin-data">
                    <div class="top-data">
                        <div class="listMenu">
                            <h4>ทั้งหมด :<?php echo count($locations); ?> </h4>
                        </div>
                    </div>
                    <div class="tableMember">
                        <table>
                            <thead>
                                <tr>
                                    <th class="col0">No.</th>
                                    <th class="col1">ชื่อผู้เพิ่มสถานที่</th>
                                    <th class="col4">User_ID</th>
                                    <th class="col4">ชื่อสถานที่</th>
                                    <th class="col2">รูปภาพ</th>
                                    <th class="col2">GoogleMapLink</th>
                                    <th class="col2">หมวดหมู่</th>
                                    <th class="col2">สถานะ</th>
                                    <th class="col2">แก้ไข</th>
                                </tr>
                            </thead>
                            <tbody id="locationTable">
                                <?php if (!empty($locations)): ?>
                                    <?php foreach ($locations as $index => $location): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo $location['first_name']; ?></td>
                                            <td><?php echo $location['user_id']; ?></td>
                                            <td><?php echo $location['location_name']; ?></td>
                                            <td class='w-[10%]'>
                                                <img class='w-[30%] h-[20%] clickable-image'
                                                    src="<?php echo $location['image']; ?>" alt="Location Image"
                                                    onclick="zoomImage('<?php echo $location['image']; ?>')">
                                            </td>
                                            <td><a class='map' href='<?php echo $location['map_link']; ?>'>ดูแผนที่</a></td>
                                            <td>
                                                <select class="category-dropdown"
                                                    data-location-id="<?php echo $location['id']; ?>">
                                                    <option disabled selected>หมวดหมู่</option>
                                                    <option value="food" <?php echo $location['category_name'] === 'food' ? 'selected' : ''; ?>>อาหาร</option>
                                                    <option value="clothing" <?php echo $location['category_name'] === 'clothing' ? 'selected' : ''; ?>>บริการ</option>
                                                    <option value="travel" <?php echo $location['category_name'] === 'travel' ? 'selected' : ''; ?>>สถานที่ท่องเที่ยว</option>
                                                </select>
                                            </td>
                                            <td>
                                                <select class="status-dropdown"
                                                    data-location-id="<?php echo $location['id']; ?>">
                                                    <option value="pending" <?php echo $location['status'] === 'pending' ? 'selected' : ''; ?>>รอดำเนินการ</option>
                                                    <option value="approved" <?php echo $location['status'] === 'approved' ? 'selected' : ''; ?>>อนุมัติ</option>
                                                    <option value="rejected" <?php echo $location['status'] === 'rejected' ? 'selected' : ''; ?>>ไม่อนุมัติ</option>
                                                </select>
                                            </td>
                                            <td class="w-[5%]">
                                                <div class="edit-icon ">
                                                    <?php echo
                                                        "<a  href='Editlocation.php?id=$location[location_id]'><img src='data:image/png;base64,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'></a>";
                                                    ?>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="8">No locations found.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>

                        </table>

                    </div>
                </div>
            </div>


        </div>
</body>
<!-- SCRIPTS -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script src="./javascript/no-table.js"></script>
<script src="./javascript/details.js"></script>
<script src="./javascript/search.js"></script>
<script src="./javascript/preview.js"></script>
<script src="./javascript/Approval.js"></script>

<!-- <script src="./javascript/admin-page.js"></script> -->



</html>

<script>
    $(document).ready(function () {
        $("#searchInput").on("keyup", function () {
            var value = $(this).val().toLowerCase();
            $("#locationTable tr").filter(function () {
                $(this).toggle($(this).find("td:nth-child(4)").text().toLowerCase().indexOf(value) > -1);
                $(this).toggle($(this).find("td:nth-child(3)").text().toLowerCase().indexOf(value) > -1);
            });
        });
    });
</script>