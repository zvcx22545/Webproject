<?php
  require_once '../config/db.php';
  require_once '../comment.php';

  $content = $_POST['content'];
  $user_id = $_POST['user_id'];
  $post_id = $_POST['post_id'];

  $comment = new Comment;
  $result = $comment->create_comment($user_id, $post_id, $content);
  if($result){
    $_SESSION['post_success'] = true;
  }else{
    $_SESSION['post_success'] = false;
  }

  header('Location: ../main.php');
?>