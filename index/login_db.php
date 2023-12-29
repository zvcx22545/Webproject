<?php

    session_start();
    require_once 'config/db.php';
    

    if(isset($_POST['signin']))
    {
        $email = $_POST['email'];
        $password = $_POST['password'];

        
        if(empty($email && strpos($email, "@ku.th") !== false)){

            $_SESSION['error']  = 'กรุณากรอกอีเมล@ku.th';
            header("location: login.php");
        }else if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'รูปแบบอีเมลไม่ถูกต้อง';
            header("location:login.php");
        }else if (empty($password)){
            $_SESSION['error'] = 'กรุณากรอกรหัสผ่าน';
            header('location:login.php');
        }else if (strlen($_POST['password']) > 20 || strlen($_POST['password']) < 5) {
            $_SESSION['error'] = 'รหัสผ่านไม่ถูกต้อง';
            header('location:login.php');
        } else {
            try{
                $check_data = $conn->prepare("SELECT * FROM users WHERE email = :email");
                $check_data->bindParam(":email", $email);
                $check_data->execute();
                $row = $check_data->fetch(PDO::FETCH_ASSOC);
                
    
                if ($check_data ->rowCount()>0) {
                    if($email == $row['email']){
                       
                        if(password_verify($password,$row['password'])){
                            if ($row) {
                                $_SESSION['userid'] = $row['id'];
                                $_SESSION['email'] = $row['email'];
                    
                                if (!empty($_POST['remember'])) {
                                    setcookie('user_login', $_POST['email'], time() + (10 * 365 * 24 * 60 * 60));
                                    setcookie('user_password', $_POST['password'], time() + (10 * 365 * 24 * 60 * 60));
                                } else {
                                    if (isset($_COOKIE['user_login'])) {
                                        setcookie('user_login', '');
                    
                                        if (isset($_COOKIE['user_password'])) {
                                            setcookie('user_password', '');
                                        }
                                    }
                                }
                                header("location: welcome.php");
                            } else {
                                $msg = "Invalid Login";
                            }
                            if($row['urole'] == 'admin'){
                                $_SESSION['admin_login'] = $row['id'];
                                header("location:http://localhost/Webproject/index/admin-dashboard/admin-dashboard/");
                            }else{
                                $_SESSION['user_login'] = $row['id'];
                                header("location:main.php");
                            }
                            

                        }else {
                            $_SESSION['error'] = 'รหัสผ่านไม่ถูกต้อง';
                                header("location:login.php");
                        }
                    }else{
                        $_SESSION['error'] = 'อีเมลไม่ถูกต้อง';
                                header("location:login.php");
                    }

                }else{
                    $_SESSION['error'] = "ไม่มีข้อมูลในระบบ";
                    header("location:register.php");
                }
                
                 
            }catch(PDOException $e) {
                echo $e->getMessage();
            }
        }
    }
    ?>
            
        
