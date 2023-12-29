<?php
require_once("autoload.php");

class Category {
    private $error = "";

    // Method to get posts by category
    public function getCategory($category) {
        global $conn; // Using the global connection object
        
        // Initialize an empty array for posts
        $posts = array();

        // Prepare the SQL query to select posts where the category matches the given category
        $query = $conn->prepare("SELECT * FROM posts WHERE category = :category ORDER BY date DESC");
        $query->bindParam(":category", $category);

        try {
            // Execute the query
            $query->execute();

            // Fetch all the posts as an associative array
            $posts = $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            // Set the error message if an exception occurs
            $this->error = "Error fetching posts by category: " . $e->getMessage();
        }

        // Return the error message and posts as an array
        return array(
            'error' => $this->error,
            'posts' => $posts
        );
    }
}
?>
