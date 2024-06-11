<?php
require_once 'autoload.php';
require_once 'config/db.php';
class Tag
{
    public function GetTag()
    {
        global $conn;
        $query = $conn->prepare("SELECT * FROM subtag ORDER BY create_at DESC");
        $query->execute();
        $Tag = $query->fetchAll(PDO::FETCH_ASSOC);
        return $Tag;

    }

}



