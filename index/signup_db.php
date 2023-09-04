<?php
session_start();
require_once 'config/db.php';

$email = isset($_POST['email']) ? $_POST['email'] : '';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$c_password = isset($_POST['c_password']) ? $_POST['c_password'] : '';
$address = isset($_POST['address']) ? $_POST['address'] : '';
$telephone = isset($_POST['telephone']) ? $_POST['telephone'] : '';
$urole = 'user';

$response = array();

if (empty($email) || strpos($email, "@ku.th") === false) {
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
} else if (!$address) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกที่อยู่";
} else if (!$telephone) {
    $response['status'] = "error";
    $response['msg'] = "กรุณากรอกเบอร์โทร";
} else if (strlen($telephone) < 10) {
    $response['status'] = "error";
    $response['msg'] = "กรุณาใส่เบอร์โทร";
} else {
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
            $stmt = $conn->prepare("INSERT INTO users(email, password,address,telephone,urole) 
                            VALUES(:email, :password, :address, :telephone, :urole)");
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":password", $passwordHash);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":telephone", $telephone);
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
?>
