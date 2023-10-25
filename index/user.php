<?php
require_once 'config/db.php';

class User
{
    public function get_data($id)
{
    global $conn; // เรียกใช้ $conn ที่เราประกาศไว้ใน db.php

    $stmt = $conn->prepare("SELECT * FROM users WHERE userid = :id LIMIT 1");
    $stmt->bindParam(":id", $id, PDO::PARAM_INT);
    $stmt->execute();

    $result = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        return $result; 
    } else {
        return false;
    }
}

public function getUsers($id)
{
    global $conn;
    $query = $conn->prepare("SELECT * FROM users WHERE userid = :id LIMIT 1");
    $query->bindParam(":id", $id, PDO::PARAM_INT);  // Explicitly bind as integer
    $query->execute();
    $result = $query->fetch(PDO::FETCH_ASSOC);
    
    if ($result) {  // Check if a user was found
        return $result;
    } else {
        return false;
    }
}

}
?>
