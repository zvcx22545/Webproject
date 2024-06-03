<?php

require_once 'autoload.php';

if (isset($_POST['query'])) {
    global $conn;
    $inputText = $_POST['query'];
    $sql = "SELECT post, location_name FROM posts WHERE post LIKE :query OR location_name LIKE :query";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['query' => '%' . $inputText . '%']);
    $result = $stmt->fetchAll();

    if ($result) {
        foreach($result as $row) {
            echo '<a class="search-content border-1">' . htmlspecialchars($row['post']) . '</a>';
        }
    } else {
        echo '<p class="list-group-item border-1 text-center d-flex check-search justify-content-center">No record found.</p>';
    }
}

?>
