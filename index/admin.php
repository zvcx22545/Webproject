<?php
require_once 'autoload.php';
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
    header('location:login.php');
}


// Handle both status and category updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['locationId'])) {
    // Connect to the database
    require_once 'config/db.php';

    // Check if status is set and update status
    if (isset($_POST['status'])) {
        $status = $_POST['status'];
        $query = $conn->prepare("UPDATE locations SET status = :status WHERE id = :locationId");
        $query->bindParam(":status", $status);
        $query->bindParam(":locationId", $_POST['locationId']);
        $query->execute();
    }

    // Check if category is set and update category
    if (isset($_POST['category'])) {
        $category = $_POST['category'];
        $query = $conn->prepare("UPDATE locations SET category = :category WHERE id = :locationId");
        $query->bindParam(":category", $category);
        $query->bindParam(":locationId", $_POST['locationId']);
        $query->execute();
    }

    // Send response
    echo 'Update successful.';
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
        ?>

        <div class="container">
            <div class="left bg-white">
                <!-- ส่วนทางซ้าย -->
                <h1 class="logo"></h1>
                <div class="main">
                    <br>
                    <ul class="menu">
                        <a href=""><button class="active p-2" id="teamButton" onclick="changePage('team')"><i
                                    class="bi bi-people"></i>อนุมัติสถานที่</button></a>
                    </ul>
                    <ul class="menu">
                        <a href=""><button class="none-active" id="competitionButton"
                                onclick="changePage('competition')"><i class="bi bi-boxes"></i>จัดการโพสต์</button></a>
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
                    <h1 id="pageTitle" class="text-2xl">อนุมัติสถานที่</h1>
                    <h1></h1>
                </nav>

                <div class="admin-data">
                    <div class="top-data">
                        <div class="listMenu">
                            <h4>ทั้งหมด : </h4>
                        </div>
                    </div>
                    <div class="tableMember">
                        <table>
                            <tr>
                                <th class="col0">No.</th>
                                <th class="col1">ชื่อผู้ส่งลิงค์</th>
                                <th class="col4">User_ID</th>
                                <th class="col4">ชื่อสถานที่</th>
                                <th class="col2">รูปภาพ</th>
                                <th class="col2">GoogleMapLink</th>
                                <th class="col2">หมวดหมู่</th>
                                <th class="col2">สถานะ</th>
                            </tr>

                            <?php
                            $location = new Location();
                            $locations = $location->GetAllLocation();

                            if (!empty($locations)): ?>
                                <?php foreach ($locations as $index => $location): ?>
                                    <tr>
                                        <td><?php echo $index + 1; ?></td>
                                        <td><?php echo $location['first_name']; ?></td>
                                        <td><?php echo $location['user_id']; ?></td>
                                        <td><?php echo $location['location_name']; ?></td>
                                        <td class='w-[10%]'>
                                            <img class='w-[30%] h-[20%] clickable-image' src="<?php echo $location['image']; ?>"
                                                alt="Location Image" onclick="zoomImage('<?php echo $location['image']; ?>')">
                                        </td>

                                        <td><a class='map' href='<?php echo $location['map_link']; ?>'>ดูแผนที่</a></td>
                                        <td>
                                            <select class="category-dropdown" data-location-id="<?php echo $location['id']; ?>">
                                                <option value="Selectcategory" <?php echo $location['category'] === 'category' ? 'selected' : ''; ?>>หมวดหมู่</option>
                                                <option value="clothing" <?php echo $location['category'] === 'clothing' ? 'selected' : ''; ?>>Clothing</option>
                                                <option value="travel" <?php echo $location['category'] === 'travel' ? 'selected' : ''; ?>>Travel</option>
                                                <option value="food" <?php echo $location['category'] === 'food' ? 'selected' : ''; ?>>Food</option>
                                            </select>
                                        </td>
                                        <td>
                                            <select class="status-dropdown" data-location-id="<?php echo $location['id']; ?>">
                                                <option value="pending" <?php echo $location['status'] === 'pending' ? 'selected' : ''; ?>>รอดำเนินการ</option>
                                                <option value="approved" <?php echo $location['status'] === 'approved' ? 'selected' : ''; ?>>อนุมัติ</option>
                                                <option value="rejected" <?php echo $location['status'] === 'rejected' ? 'selected' : ''; ?>>ไม่อนุมัติ</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No locations found.</td>
                                </tr>
                            <?php endif; ?>

                        </table>

                    </div>
                </div>
            </div>


        </div>
</body>
<!-- SCRIPTS -->
<script src="./javascript/no-table.js"></script>
<script src="./javascript/details.js"></script>
<script src="./javascript/search.js"></script>
<script src="./javascript/preview.js"></script>
<script src="./javascript/Approval.js"></script>

<!-- <script src="./javascript/admin-page.js"></script> -->



</html>