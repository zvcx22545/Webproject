<?php

    session_start();
    require_once 'config/db.php';

        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $address = $_POST['address'];
        $telephone = $_POST['telephone'];
        $urole = 'user';
        if (empty($email) || (strpos($email, "@ku.th") === false)) {
            echo json_encode(array("status" => "error", "msg" => "กรุณากรอกอีเมล@ku.th"));
        } else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(array("status" => "error", "msg" => "กรุณากรอกอีเมล@ku.th"));
        } else if (!$password) {
            echo json_encode(array("status" => "error", "msg" => "กรุณากรอกรหัสผ่าน"));
        } else if (strlen($password) > 20 || strlen($password) < 5) {
            echo json_encode(array("status" => "error", "msg" => "รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร"));
        } else if (!$c_password) {
            echo json_encode(array("status" => "error", "msg" => "กรุณายืนยันรหัสผ่าน"));
        } else if ($password != $c_password) {
            echo json_encode(array("status" => "error", "msg" => "กรุณากรอกรหัสผ่านให้ตรงกัน"));
        } else if (!$address) {
            echo json_encode(array("status" => "error", "msg" => "กรุณากรอกที่อยู่"));
        } else if (!$telephone) {
            echo json_encode(array("status" => "error", "msg" => "กรุณากรอกเบอร์โทร"));
        } else if (strlen($telephone) < 10) {
            echo json_encode(array("status" => "error", "msg" => "กรุณาใส่เบอร์โทร"));
        } else {
            try{
                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);
    
                if ($row['email'] == $email) {
                    echo json_encode(array("status" => "error", "msg" => "มีอีเมลนี้ในระบบแล้วโปรดเข้าสู่ระบบ"));
                } else if (!isset($_SESSION['error'])) {
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users(email, password,address,telephone,urole) 
                                    VALUES(:email, :password, :address, :telephone, :urole)");
                    $stmt->bindParam(":email", $email);
                    $stmt->bindParam(":password", $passwordHash);
                    $stmt->bindParam(":address", $address);
                    $stmt->bindParam(":telephone", $telephone);
                    $stmt->bindParam(":urole", $urole);
                    $stmt->execute();
                    echo json_encode(array("status" => "success", "msg" => "สมัครสมาชิก"));
                }
            } catch (PDOException $e) {
                echo json_encode(array("status" => "error", "msg" => "Something went wrong, please try again!"));
            }
        }
