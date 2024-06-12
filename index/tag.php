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

    public function getTagPosts($Postid)
    {
        global $conn;
        
        $query = $conn->prepare("SELECT * FROM post_tags WHERE post_id = :post_id");
        $query->bindParam(":post_id", $Postid);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all posts
        
        return $result; // Return the array of posts
    }

    public function getPostsByTagName($tagName) {
        global $conn;
        
        $query = $conn->prepare("
            SELECT p.* 
            FROM posts p 
            JOIN post_tags pt ON p.id = pt.post_id 
            WHERE pt.tag_name = :tag_name AND p.status = 'approved'
            ORDER BY p.likes DESC
        ");
        $query->bindParam(":tag_name", $tagName);
        $query->execute();
        
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

}



