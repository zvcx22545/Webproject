<?php
session_start();
require_once 'config/db.php';


$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$c_password = isset($_POST['c_password']) ? $_POST['c_password'] : '';
$first_name = isset($_POST['first_name']) ? $_POST['first_name'] : '';
$last_name = isset($_POST['last_name']) ? $_POST['last_name'] : '';
$url_address = strtolower($first_name) . "." . strtolower($last_name);
$userCreator = new create_user();
$userid = $userCreator->create_userid();
$urole = 'user';
function isValidName($name) {
    return preg_match('/^[a-zA-Zก-๙]+$/u', $name);
}
$response = array();
if (empty($first_name)) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกชื่อ";
} else if (!isValidName($first_name)) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกชื่อเป็นตัวอักษรไทยหรืออังกฤษเท่านั้น";
} 

// Check last name
else if (empty($last_name)) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกนามสกุล";
} else if (!isValidName($last_name)) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกนามสกุลเป็นตัวอักษรไทยหรืออังกฤษเท่านั้น";
}
 else if (empty($email) || strpos($email, "@ku.th") === false) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกอีเมล@ku.th";
} else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกอีเมล@ku.th";
} else if (!$password) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกรหัสผ่าน";
} else if (strlen($password) > 20 || strlen($password) < 5) {
    $response['status'] = "error";
    $response['msg'] = "รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร";
} else if (!$c_password) {
    $response['status'] = "error";
    $response['msg'] = "กรุณายืนยันรหัสผ่าน";
} else if ($password != $c_password) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกรหัสผ่านให้ตรงกัน";
}  else {
    try {
        $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
        $check_email->bindParam(":email", $email);
        $check_email->execute();
        $row = $check_email->fetch(PDO::FETCH_ASSOC);
        if ($row && $row['email'] == $email) {
            $response['status'] = "error";
            $response['msg'] = "มีอีเมลนี้ในระบบแล้วโปรดเข้าสู่ระบบ";
        } else {
            $passwordHash = password_hash($password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("INSERT INTO users(email, password,first_name,last_name,urole,userid,url_address) 
                            VALUES(:email, :password, :first_name, :last_name, :urole,:userid,:url_address)");
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->bindParam(":first_name", $first_name);
            $stmt->bindParam(":last_name", $last_name);
            $stmt->bindParam(":userid", $userid);
            $stmt->bindParam(":url_address", $url_address);
            $stmt->bindParam(":urole", $urole);
            $stmt->execute();

            $response['status'] = "success";
            $response['msg'] = "สมัครสมาชิกสำเร็จ";
        }
    } catch (PDOException $e) {
        $response['status'] = "error";
        $response['msg'] = "Something went wrong, please try again!";
        $response['debug'] = $e->getMessage();
    }
}


echo json_encode($response);
class create_user{
    public function create_userid()
     {
         $length = rand(4,19);
         $number = "";
         for ($i = 0; $i < $length; $i++){
             $new_rand = rand(0,9);
             $number = $number . $new_rand;
         }
 
         return $number;
     }
     
 }
 

 ?>