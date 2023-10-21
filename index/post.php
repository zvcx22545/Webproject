<?php 
    require_once 'config/db.php';
    require_once 'user.php';
    class Post{
        private $error = "";
        public function create_post($user_id,$data){
            global $conn;
            if(!empty($data['post']))
        {
            $post = addslashes($data['post']);
            $postid = $this->create_postid();

            $query = $conn->prepare("INSERT INTO posts(user_id,postid,post) VALUES(:user_id,:postid,:post)");
            $query->bindParam(":user_id",$user_id);
            $query->bindParam(":postid",$postid);
            $query->bindParam(":post",$post);
            $query->execute();

           
        }else{
            $this->error .= 'Please enter something to post! <br>';
        }
        return $this->error;
    }

    public function get_posts($id) {
        global $conn;
        $query = $conn->prepare("SELECT * FROM posts WHERE user_id = :id ORDER BY id DESC LIMIT 10");
        $query->bindParam(":id", $id);
        
        try {
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->error = "Error fetching posts: " . $e->getMessage();
            return false;
        }
    }
        private function create_postid()
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
