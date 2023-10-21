<?php 
    require_once './function.php';
    
    // For managing add post
    if (isset($_GET['addpost'])) {
        $response = validatePostImage($_FILES['post_img']);

        if ($response['status']) {
            if (createPost($_POST, $_FILES['post_img'])) {
                header("location:././?new_post_added");
            } else {
                echo " something went wrong";
            }
        } else {
            $_SESSION['error'] = $response;
            header("location:./");
        }
    }
?>
