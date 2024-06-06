<?php
class Database
{
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $db = "web_project";
    private $conn;

    function connect()
    {
        if (!$this->conn) {
            try {
                $this->conn = new PDO("mysql:host={$this->host};dbname={$this->db};charset=utf8", $this->username, $this->password);
                $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            } catch (PDOException $e) {
                die("Connection failed: " . $e->getMessage());
            }
        }
        return $this->conn;
    }

    function read($query)
    {
        try {
            $stmt = $this->connect()->prepare($query);
            $stmt->execute();

            $data = [];
            while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                $data[] = $row;
            }
            return $data;

        } catch (PDOException $e) {
            return false;
        }
    }

    function save($query)
    {
        try {
            $stmt = $this->connect()->prepare($query);
            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }
}

$DB = new Database();

?>

// class Database
// {
//     private $host = "localhost";
//     private $username = "root";
//     private $password = "";
//     private $db = "web_project";


//     function connect()
//     {
//         $connection = mysqli_connect("$this->host", "$this->username", "$this->password", "$this->db");
//         return $connection;
//     }


//     function read($query)
//     {

//         $conn = $this->connect();
//         $result = mysqli_query($conn, $query);
//         if (!$result) {
//             return false;
//         } else {
//             $data = false;
//             while ($row = mysqli_fetch_assoc($result)) {
//                 $data[] = $row;
//             }
//             return $data;
//         }
//     }

//     function save($query)
//     {
//         $conn = $this->connect();
//         $result = mysqli_query($conn, $query);
//         if (!$result) {
//             return false;
//         } else {
//             return true;
//         }
//     }
// }

// $DB  = new Database();
