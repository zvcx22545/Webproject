<?php
require_once 'autoload.php';
require_once 'config/db.php';
if (!isset($_SESSION['admin_login'])) {
    $_SESSION['error'] = 'กรุณาเข้าสู่ระบบ!!';
    header('location:login.php');
}


// Handle both status and category updates
// Handle status updates
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['locationId']) && isset($_POST['status'])) {
    global $conn;

    $status = $_POST['status'];
    $locationId = $_POST['locationId'];
    $query = $conn->prepare("UPDATE posts SET status = :status WHERE postid = :locationId");
    $query->bindParam(":status", $status);
    $query->bindParam(":locationId", $locationId);
    if ($query->execute()) {
        echo 'Status update successful.';
    } else {
        echo 'Status update failed: ' . implode(";", $query->errorInfo());
    }
}
$post = new Post();
$posts = $post->getAllPosts();
$count = 0;

foreach ($posts as $post) {
    if (empty($post['location_name'])) {
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
                        <a href="./admin.php"><button class="none-active " id="teamButton"><i
                                    class="bi bi-people"></i>อนุมัติสถานที่</button></a>
                    </ul>
                    <ul class="menu">
                        <a href="./managepost.php"><button class="active p-2" id="competitionButton"
                               ><i class="bi bi-boxes"></i>จัดการโพสต์</button></a>
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
                    <h1 id="pageTitle" class="text-2xl">จัดการโพสต์</h1>
                    <h1></h1>
                </nav>

                <div class="admin-data">
                    <div class="top-data">
                        <div class="listMenu">
                        <h4>ทั้งหมด : <?php echo $count; ?> โพสต์</h4>
                        </div>
                    </div>
                    <div class="tableMember">
                        <table>
                            <tr>
                                <th class="col0">No.</th>
                                <th class="col1">ชื่อ-นามสกุล</th>
                                <th class="col4">User_ID</th>
                                <th class="col4">ข้อความโพสต์</th>
                                <th class="col2">รูปภาพ</th>
                                <th class="col2">สถานะ</th>
                            </tr>

                            <?php
                            // $post = new Post();
                            // $posts = $post->getAllPosts();
                            
                            if (!empty($posts)): ?>
                                <?php foreach ($posts as $index => $post): 
                                    if (!empty($post['location_name'])) {
                                        continue; // ข้ามโพสต์ที่มี location_name
                                    }
                                    $count++;
                                    $user = new User();
                                    $ROW_USER = $user->getUsers($post['user_id']);?>
                                    
                                    <tr>
                                        <td><?php echo $index; ?></td>
                                        <td><?php echo $ROW_USER['first_name'] . " " . $ROW_USER['last_name'] ?></td>
                                        <td><?php echo $post['user_id']; ?></td>
                                        <td><?php echo $post['post']; ?></td>
                                        <td class='w-[10%]'>
                                            <img class='w-[30%] h-[20%] clickable-image' src="<?php echo $post['image']; ?>"
                                                alt="post Image" onclick="zoomImage('<?php echo $post['image']; ?>')">
                                        </td>
                            
                                        <td>
                                            <select class="status-dropdown" data-post-id="<?php echo $post['postid']; ?>">
                                                <option value="pending" <?php echo $post['status'] === 'pending' ? 'selected' : ''; ?>>รอดำเนินการ</option>
                                                <option value="approved" <?php echo $post['status'] === 'approved' ? 'selected' : ''; ?>>อนุมัติ</option>
                                                <option value="rejected" <?php echo $post['status'] === 'rejected' ? 'selected' : ''; ?>>ไม่อนุมัติ</option>
                                            </select>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="7">No posts found.</td>
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
<script src="./javascript/Approvepost.js"></script>

<!-- <script src="./javascript/admin-page.js"></script> -->



</html>