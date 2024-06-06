<?php
session_start();

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login</title>
  <link rel="stylesheet" href="./style/login.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link href="https://fonts.googleapis.com/css2?family=Kavoon&display=swap" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>

<body class="text-start">

  <div class="grid">

    <div class="background-logo">
      <div class="header w-50">
        <h1 class="web">travel </h1>
        <h1 class="content">to Knowledge</h1>
      </div>
    </div>
    <main class="form-signin w-500 ">
      <h1 class="h3 mb-3"> Sign In</h1>
      <p class="please-sign-in">please sign in to continue</p>
      <hr>
      <form action="login_db.php" method="post" id="loginForm">
        <?php if (isset($_SESSION['error'])) { ?>
          <div class="alert alert-danger" role="alert">
            <?php
            echo $_SESSION['error'];
            unset($_SESSION['error']);
            ?>
          </div>
        <?php } ?>
        <?php if (isset($_SESSION['success'])) { ?>
          <div class="alert alert-success" role="alert">
            <?php
            echo $_SESSION['success'];
            unset($_SESSION['success']);
            ?>
          </div>
        <?php } ?>
        <div class="form-floating my-4">
          <input type="email" id="email" class="form-control" id="floatingInput" name="email" placeholder="name@example.com" required>
          <label for="floatingInput">Email address</label>
        </div>


        <div class="form-floating confirm--password my-4 password-toggle">
          <input type="password" id="floatingPassword" class="form-control " name="password" id="floatingPassword" placeholder="Password" required>
          <label for="floatingPassword">Password</label>
          <i class="fa-solid fa-eye-slash toggle-icon" data-target="floatingPassword"></i>
        </div>
        <button name="signin" class="btn-s w-100 py-2" type="submit">Sign in</button>
        <p class="mt-5 mb-3 text-body-secondary">Don't have an account Please? <a href="./register.php">sing
            up</a></p>

      </form>
    </main>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
  </script>
  <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="./javascript/login.js"></script>


</body>

</html>