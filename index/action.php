<?php
require_once 'autoload.php';

if (isset($_POST['query'])) {
    global $conn;
    $inputText = $_POST['query'];

    // Query to fetch posts from the posts table
    $sqlPosts = "
        SELECT p.post, p.location_name 
        FROM posts p
        WHERE p.post LIKE :query
    ";

    // Query to fetch location names from the locations table
    $sqlLocations = "
        SELECT NULL AS post, l.location_name 
        FROM locations l
        WHERE l.location_name LIKE :query
    ";

    // Combine both queries using UNION
    $sql = "($sqlPosts) UNION ($sqlLocations)";

    $stmt = $conn->prepare($sql);
    $stmt->execute(['query' => '%' . $inputText . '%']);
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Debugging: Check the result of the combined query
    // echo '<pre>Action Result: ';
    // var_dump($result);
    // echo '</pre>';

    if ($result) {
        foreach ($result as $row) {
            if (!empty($row['post'])) {
                echo '<a class="search-content border-1">' . htmlspecialchars($row['post']) . '</a>';
            } else if (!empty($row['location_name'])) {
                echo '<a class="search-content border-1">' . htmlspecialchars($row['location_name']) . '</a>';
            }
        }
    } else {
        echo '<p class="list-group-item border-1 text-center d-flex check-search justify-content-center">No record found.</p>';
    }
}
?>
