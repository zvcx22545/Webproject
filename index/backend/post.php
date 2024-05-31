<?php
  session_start();
  require_once '../config/db.php';
  require_once '../post.php';

  $like_id = $_GET['like_id'];
  $post_id = $_GET['post_id'];

  $history_like_id = 0;
  $user_session_id = $_SESSION['user_login'];
  $stmt = $conn->prepare("SELECT * FROM users WHERE id = :user_session_id");
  $stmt->bindParam(':user_session_id', $user_session_id);
  $stmt->execute();
  $row = $stmt->fetch(PDO::FETCH_ASSOC);
  $user_id = $row['userid'];

  $post = new Post();
  if($like_id == 0){
    $create_history = $post->add_like_history($post_id, $user_id);
    if($create_history){
      $history_like_id = $create_history;
      $result = $post->update_like($post_id, 'like');
    }
    
  }else{
    $delete_history_like = $post->delete_like_history($post_id, $user_id);
    if($delete_history_like){
      $result = $post->update_like($post_id, 'unlike');
    }
  }
  
  $data = $post->get_one_post($post_id);

  header('Content-type: application/json');
  echo json_encode([
    'likes' => number_format($data['likes']),
    'like_id' => $history_like_id
  ]);
?>