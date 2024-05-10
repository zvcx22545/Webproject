<?php
require_once 'config/db.php';
require_once 'user.php';
class Post
{
    private $error = "";
    public function create_post($user_id, $data, $files)
    {
        global $conn;
        if (!empty($data['post']) || !empty($files['file']['name']) || isset($data['is_profile_image']) || isset($data['is_cover_image'])) {
            $myimage = "";
            $has_image = 0;
            $is_cover_image = 0;
            $is_profile_image = 0;
            $category = isset($data['category']) ? $data['category'] : '';
            if (isset($data['is_profile_image']) || isset($data['is_cover_image'])) {

                $myimage = $files;
                $has_image = 1;
                if (isset($data['is_cover_image']) && $data['is_cover_image']) {
                    $is_cover_image = 1;
                    $is_profile_image = 0; // Ensure is_profile_image is not set when is_cover_image is set
                } elseif (isset($data['is_profile_image']) && $data['is_profile_image']) {
                    $is_profile_image = 1;
                    $is_cover_image = 0; // Ensure is_cover_image is not set when is_profile_image is set
                }
            } else {


                if (!empty($files['file']['name'])) {
                    // $image_class = new Image();
                    $folder = "uploads/" . $user_id . "/";

                    //create folder
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        file_put_contents($folder. "index.php","");
                    }
                    $image_class = new Image();
                    $myimage = $folder . $image_class->generate_filename(15) . ".jpg";
                    move_uploaded_file($_FILES["file"]["tmp_name"], $myimage);

                    $image_class->resize_image($myimage, $myimage, 1500, 1500);

                    $has_image = 1;
                }
            }


            $post = "";
            if (isset($data['post'])) {

                $post = addslashes($data['post']);
            }

            $postid = $this->create_postid();
            $location = "";
            if (isset($data['location'])) {
                $location = addslashes($data['location']);
            }
     

            $query = $conn->prepare("INSERT INTO posts(user_id,postid,post,image,has_image,is_cover_image,is_profile_image,category,location_name) VALUES(:user_id,:postid,:post,:image,:has_image,:is_cover_image,:is_profile_image,:category,:location_name)");
            $query->bindParam(":user_id", $user_id);
            $query->bindParam(":postid", $postid);
            $query->bindParam(":post", $post);
            $query->bindParam(":image", $myimage);
            $query->bindParam(":has_image", $has_image);
            $query->bindParam(":is_cover_image", $is_cover_image);
            $query->bindParam(":is_profile_image", $is_profile_image);
            $query->bindParam(":category", $category);
            $query->bindParam(":location_name", $location);
            $query->execute();
        } else {
            $this->error .= 'Please enter something to post! <br>';
        }
        return $this->error;
    }

    public function get_posts($id)
    {
        global $conn;
        $query = $conn->prepare("SELECT * FROM posts WHERE user_id = :id ORDER BY id DESC LIMIT 10");
        $query->bindParam(":id", $id);

        try {
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error = "Error fetching posts: " . $e->getMessage();
            return false;
        }
    }
    public function get_one_post($postid)
    {
        global $conn;
        if(!is_numeric($postid)) {
            return false;
        }
        $query = $conn->prepare("SELECT * FROM posts WHERE postid = :postid  LIMIT 1");
        $query->bindParam(":postid", $postid);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if($result)
        {
            return $result["0"];
        }else{
            return false;
        }
    }
    public function delete_post($postid,)
    {
        global $conn;
        if(!is_numeric($postid)) {
            return false;
        }
        $query = $conn->prepare("DELETE FROM posts WHERE postid = :postid  LIMIT 1");
        $query->bindParam(":postid", $postid,PDO::PARAM_INT);
        $query->execute();

            
        
    }
    public function i_own_post($postid,$user_login)
    {
        global $conn;
        if(!is_numeric($postid)) {
            return false;
        }
        $query = $conn->prepare("SELECT * FROM posts WHERE postid = :postid  LIMIT 1");
        $query->bindParam(":postid", $postid,PDO::PARAM_INT);
        $query->execute();
        $result = $query->fetch(PDO::FETCH_ASSOC);
        if(is_array($result))
        {
            if($result['user_id'] == $user_login)
            {
                return true;
            }
        }
        return false;

            
        
    }
    public function getAllPosts()
{
    global $conn;
    
    $query = $conn->prepare("SELECT * FROM posts ORDER BY date DESC");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all posts
    
    return $result; // Return the array of posts
}

    private function create_postid()
    {
        $length = rand(4, 19);
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number = $number . $new_rand;
        }

        return $number;
    }

    public function edit_post($data, $files)
    {
        global $conn;
        if (!empty($data['post']) || !empty($files['file']['name'])) {
            $myimage = "";
            $has_image = 0;
            
            // Check if a new image file is uploaded
            if (!empty($files['file']['name'])) {
                // Handle image upload
                $folder = "uploads/" . $user_id . "/";
                // Create folder if not exists
                if (!file_exists($folder)) {
                    mkdir($folder, 0777, true);
                    file_put_contents($folder. "index.php", "");
                }
                $image_class = new Image();
                $myimage = $folder . $image_class->generate_filename(15) . ".jpg";
                move_uploaded_file($_FILES["file"]["tmp_name"], $myimage);
                $image_class->resize_image($myimage, $myimage, 1500, 1500);
                $has_image = 1;
            }
    
            $post = "";
            if (isset($data['post'])) {
                $post = addslashes($data['post']);
            }
            $postid = addslashes($data['postid']);
    
            // Update post query
            if ($has_image) {
                $query = $conn->prepare("UPDATE posts SET post = :post, image = :myimage WHERE postid = :postid LIMIT 1");
                $query->bindParam(":myimage", $myimage);
                
            } else {
                $query = $conn->prepare("UPDATE posts SET post = :post WHERE postid = :postid LIMIT 1");
            }
    
            // Bind parameters
            $query->bindParam(":postid", $postid);
            $query->bindParam(":post", $post);
    
            // Execute query
            $query->execute();
            header("Location: Profilepage.php");
        exit; // Stop the script
        } else {
            $this->error .= 'Please enter something to post! <br>';
        }
        return $this->error;
    }
    
}

   