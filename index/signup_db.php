<?php

    session_start();
    require_once 'config/db.php';

    if(isset($_POST['signup']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];
        $c_password = $_POST['c_password'];
        $address = $_POST['address'];
        $telephone = $_POST['telephone'];
        $urole = 'user';

        if(empty($email && strpos($email, "@ku.th") !== false)){
            $_SESSION['error']  = 'กรุณากรอกอีเมล@ku.th';
            header("location: register.php");
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location:register.php");
        }else if (empty($password)){
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header('location:register.php');
        }else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านต้องมีความยาวระหว่าง 5 ถึง 20 ตัวอักษร';
            header('location:register.php');
        }else if (empty($c_password)){
            $_SESSION['error'] = 'กรุณายืนยันรหัสผ่าน';
            header('location:register.php');
    }else if ($password != $c_password) {
        $_SESSION['error'] = 'กรุณากรอกรหัสผ่านให้ตรงกัน';
        header("location: register.php");
        }else if (empty($address)){
            $_SESSION['error'] = 'กรุณากรอกที่อยู่';
            header('location:register.php');
        }else if (empty($telephone)){
            $_SESSION['error'] = 'กรุณากรอกเบอร์โทร';
            header('location:register.php');
        }else if (strlen($_POST['telephone']) > 10 || strlen($_POST['telephone']) < 0) {
            $_SESSION['error'] = 'กรุณาใส่เบอร์โทร';
            header('location:register.php');
        } else {
            try{
                $check_email = $conn->prepare("SELECT email FROM users WHERE email = :email");
                $check_email->bindParam(":email", $email);
                $check_email->execute();
                $row = $check_email->fetch(PDO::FETCH_ASSOC);
    
                if ($row['email'] == $email) {
                    $_SESSION['warning'] = "มีอีเมลนี้อยู่ในระบบแล้ว <a href='login.php'>คลิ๊กที่นี่</a> เพื่อเข้าสู่ระบบ";
                    header("location: register.php");
                }else if (!isset($_SESSION['error'])){
                    $passwordHash = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO users(email, password,address,telephone,urole) 
                            VALUES(:email, :password, :address, :telephone, :urole)");
                    $stmt->bindParam(":email",$email);
                    $stmt->bindParam(":password",$passwordHash);  
                    $stmt->bindParam(":address",$address);
                    $stmt->bindParam(":telephone",$telephone);
                    $stmt->bindParam(":urole",$urole);
                    $stmt->execute();
                    $_SESSION['success'] = "Register is successful! <a herf='/index/login.php' class='alert-link'>คลิกที่นี่</a>เพื่อเข้าสู่ระบบ";
                    header("location:register.php");
                } else{
                    $_SESSION['error'] = "มีบางอย่างผิดพลาด";
                    header("location:register.php");
                }
    
            }catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    ?>
            
        
