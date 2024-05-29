<?php
  require_once 'config/db.php';
  class Comment {

    private $error = "";

    public function getAllComment($post_id) 
    {

      try {
        global $conn;
        $sql = "SELECT c.id as content_id, c.content, concat(u.first_name, ' ',u.last_name) as fullname, c.create_date FROM comments c".
                " inner join users u ON c.user_id = u.userid".
                " where c.post_id = '$post_id' ORDER BY c.create_date DESC";
        $query = $conn->prepare($sql);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC); // Fetch all posts
        
        return $result;

      } catch (\Throwable $th) {
        //throw $th;
      }
      
    }

    public function create_comment($user_id, $post_id, $content)
    {
      global $conn;
      $query = $conn->prepare("INSERT INTO comments (user_id, post_id, content, create_date) VALUES (:user_id, :post_id, :content, NOW())");
      $query->bindParam(":user_id", $user_id, PDO::PARAM_INT);
      $query->bindParam(":post_id", $post_id, PDO::PARAM_INT);
      $query->bindParam(":content", $content, PDO::PARAM_STR);

      try {
        $query->execute();
        return true;
      } catch (\Throwable $th) {
        //throw $th;
        return false;
      }
    }
  }

?>