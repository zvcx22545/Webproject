<?php

  require_once '../config/db.php';
  require_once '../post.php';

  $post = new Post();
  $result = $post->update_like($_GET['id']);

  if($result){
    $_SESSION['post_success'] = true;
  }else{
    $_SESSION['post_success'] = false;
  }

  header('Location: ../main.php');
?>