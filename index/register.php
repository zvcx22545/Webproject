<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Sign-up</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <!-- Custom Login & Register CSS -->
    <link rel="stylesheet" href="./style/register.css">

</head>

<body>

    <div class="container">

        <main class="form-sign-in w-100 m-auto">
            <h1 class="h3 mb-3 fw-normal">Sign Up</h1>
            <hr>
            <form action="signup_db.php" id="registerForm" method="POST">
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
                <?php if (isset($_SESSION['warning'])) { ?>
                <div class="alert alert-warning" role="alert">
                    <?php
            echo $_SESSION['warning'];
            unset($_SESSION['warning']);
            ?>
                </div>
                <?php } ?>

                <div class="form-floating my-2">
                    <input type="email" class="form-control" id="floatingInput" placeholder="name@example.com"
                        name="email" aria-describedby="email">
                    <label for="floatingInput">Email address</label>
                </div>
                <div class="form-floating my-2">
                    <input type="password" class="form-control" id="floatingPassword" placeholder="Password"
                        name="password">
                    <label for="floatingPassword">Password</label>
                </div>
                <div class="form-floating my-2">
                    <input type="password" class="form-control" id="ConfirmPassword" placeholder="Confirm Password"
                        name="c_password">
                    <label for="ConfirmPassword">Confirm Password</label>
                </div>
                <div class="form-floating my-2">
                    <input type="adress" name="address" class="form-control" id="floatingaddress" placeholder="address">
                    <label for="floatingaddress">Address</label>
                </div>
                <div class="form-floating my-2">
                    <input type="telephone" name="telephone" class="form-control" id="telephone"
                        placeholder="Telephone Number">
                    <label for="telephone">Telephone Number</label>
                </div>

                <button class="btn-s w-100 py-2" type="submit" name="register">Sign Up</button>
                <p class="mt-5 mb-3 text-body-secondary">If you have an account then please <a href="./login.php">Sign
                        in</a></p>

            </form>
        </main>



        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous">
        </script>
        <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script src="./javascript/register.js"></script>

</body>

</html>