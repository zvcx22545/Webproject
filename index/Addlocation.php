<?php
require_once 'config/db.php';
require_once 'user.php';
 class Location
 {
    private $error = "";
    public function Addlocation($user_id, $data, $files, $first_name)
{
    global $conn;
    if (!empty($data['location']) || !empty($files['file']['name']) || isset($data['location']) || !empty($first_name)) {
        $myimage = "";
        $has_image = 0;

        if (!empty($files['file']['name'])) {
            // Upload image code here
            $folder = "uploads/" . $user_id . "/";
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

        $location = "";
        $map_link = "";
        if (isset($data['location'])) {
            $location = addslashes($data['location']);
            $map_link = addslashes(($data['Maplink']));
        }
        $location_id = $this->create_location_id();

        $query = $conn->prepare("INSERT INTO locations(location_name, user_id, image, map_link, location_id, has_image, first_name) VALUES(:location_name, :user_id, :image, :map_link, :location_id, :has_image, :first_name)");
        $query->bindParam(":location_name", $location);
        $query->bindParam(":user_id", $user_id);
        $query->bindParam(":image", $myimage);
        $query->bindParam(":map_link", $map_link);
        $query->bindParam(":location_id", $location_id);
        $query->bindParam(":has_image", $has_image);
        $query->bindParam(":first_name", $first_name);
        // Check if query executes successfully
        if ($query->execute()) {
            // Query executed successfully
            return true;
        } else {
            // Query execution failed
            return "Error executing query: " . implode(" ", $query->errorInfo());
            
        }
    } else {
        return 'Please enter something to post!';
        
    }
    
}




    private function create_location_id()
    {
        $length = rand(4, 19);
        $number = "";
        for ($i = 0; $i < $length; $i++) {
            $new_rand = rand(0, 9);
            $number = $number . $new_rand;
        }

        return $number;
    }
 }