<?php 
require_once 'autoload.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

header('Content-Type: application/json');

if (!isset($_SESSION['user_login'])) {
    echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
    exit();
}


if ($_SERVER['REQUEST_METHOD'] == "POST") {
    header('Content-Type: application/json');
    if (isset($_POST['post_id']) && isset($_SESSION['user_id'])) {
        $post = new Post();
        $user_id = $_SESSION['user_id'];
        $report = $post->ReportPost($_POST, $user_id);
        echo json_encode($report);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Post ID or User ID missing in request']);
    }
    exit();
}
