<?php

require_once 'autoload.php';

if (isset($_POST['query'])) {
    $inputText = $_POST['query'];
    $sql = "SELECT post FROM posts WHERE post LIKE :postid";
    $stmt = $conn->prepare($sql);
    $stmt->execute(['postid' => '%' . $inputText . '%' ]);
    $result = $stmt->fetchAll();

    if ($result) {
        foreach($result as $row) {
            echo '<a class="list-group-item list-group-item-action border-1">' . htmlspecialchars($row['post']) . '</a>';
        }
    } else {
        echo '<p class="list-group-item border-1">No record found.</p>';
    }
}

?>
