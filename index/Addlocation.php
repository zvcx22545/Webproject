<?php
require_once 'config/db.php';
require_once 'user.php';
class Location
{
    private $error = "";
    public function Addlocation($user_id, $data, $files, $first_name)
    {
        global $conn;
        if (empty($data['location']) || empty($data['Maplink'])) {
            echo '<script type="text/javascript">';
            echo 'Swal.fire("Error", "กรุณากรอกชื่อสถานที่และลิงค์ Google Map", "error");';
            echo '</script>';
            return "Please fill both the location name and the Google Map link.";
        }
        $query_check = $conn->prepare("SELECT * FROM locations WHERE location_name = :location_name AND map_link = :map_link");
        $query_check->bindParam(":location_name", $data['location']);
        $query_check->bindParam(":map_link", $data['Maplink']);
        $query_check->execute();
        $result = $query_check->fetch(PDO::FETCH_ASSOC);

        if ($result) {
            echo '<script type="text/javascript">';
            echo 'Swal.fire("Error", "ชื่อสถานที่หรือลิงค์ Google Map นี้มีอยู่แล้วในระบบ", "error");';
            echo '</script>';
            return "ชื่อสถานที่หรือลิงค์ Google Map นี้มีอยู่แล้วในระบบ";
        }


        if (!empty($data['location']) || !empty($files['file']['name']) || isset($data['location']) || !empty($first_name)) {
            $myimage = "";
            $has_image = 0;

            if (!empty($files['file']['name'])) {
                // ตรวจสอบนามสกุลของไฟล์ที่อัปโหลด
                $file_extension = strtolower(pathinfo($files['file']['name'], PATHINFO_EXTENSION));
                // รายการของนามสกุลที่อนุญาต
                $allowed_extensions = array('jpg', 'jpeg', 'png', 'svg');
                // ตรวจสอบว่านามสกุลของไฟล์ที่อัปโหลดอยู่ในรายการที่อนุญาตหรือไม่
                if (in_array($file_extension, $allowed_extensions)) {
                    // อัปโหลดไฟล์ด้วยรหัสเดียวกันที่สร้างจากชื่อไฟล์
                    $folder = "uploads/" . $user_id . "/";
                    if (!file_exists($folder)) {
                        mkdir($folder, 0777, true);
                        file_put_contents($folder . "index.php", "");
                    }
                    $image_class = new Image();
                    $myimage = $folder . $image_class->generate_filename(15) . "." . $file_extension;
                    move_uploaded_file($_FILES["file"]["tmp_name"], $myimage);
                    $image_class->resize_image($myimage, $myimage, 1500, 1500);
                    $has_image = 1;
                } else {
                    // ถ้านามสกุลของไฟล์ไม่ได้อยู่ในรายการที่อนุญาต
                    return "Only JPG, JPEG, PNG, and SVG files are allowed.";
                }
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

    public function GetAllLocation()

    {
        global $conn;
        $query = $conn->prepare("SELECT * FROM locations ORDER BY create_at DESC");
        $query->execute();
        $locations = $query->fetchAll(PDO::FETCH_ASSOC);
        return $locations;
    }

    public function GetApprovedLocation()
    {
        global $conn;
        // สร้างคำสั่ง SQL เพื่อดึงข้อมูล location name ที่มี status เป็น "approved"
        $query = $conn->prepare("SELECT location_name FROM locations WHERE status = 'approved'");
        $query->execute();
        $locations = $query->fetchAll(PDO::FETCH_COLUMN);
        return $locations;
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
