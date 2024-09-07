<?php
include_once("dbConnect.php");

if (isset($_POST["signup"])) {

    $name = mysqli_real_escape_string($db, $_POST['name']);
    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);
    $cpassword = mysqli_real_escape_string($db, $_POST['cpassword']);
    $role = "user";
    $query = "SELECT * FROM Users WHERE email='$email'";
    $res = mysqli_query($db, $query);
    if (!$res) {
        die($mysqli_error($db));
    }

    if ($cpassword != $password) {
        $errorPass = "Password and Confirm Password doesn't match";
    } elseif (mysqli_num_rows($res) > 0) {
        $errorEmail = "Email already exists";
    } else {

        $password = password_hash($password, PASSWORD_DEFAULT);
        $query = "INSERT INTO Users (name,email,password,role) VALUES ('$name','$email','$password','$role')";
        if (!mysqli_query($db, $query)) {
            die(mysqli_error($db));
        }

       
        $id = mysqli_insert_id($db);

        session_start();

        $_SESSION['id'] = $id;
        $_SESSION['name'] = $name;
        $_SESSION['email'] = $email;
        $_SESSION['role'] = $role;


        header('location:shop.php');
        exit();
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <title>Booky | Sign up</title>

    <style>
        body {
            background-color: #f8f9fa;
        }

        .container {
            max-width: 400px;
            margin: 20px auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
        }

        h1 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 24px;
        }

        h1 img {
            width: 40px;
            vertical-align: middle;
        }

        .btn-primary {
            width: 100%;
        }

        .footer-text {
            font-family: 'Roboto Mono', monospace;
            text-align: center;
            font-size: 0.9em;
            margin-top: -10px;
            color: #888;
        }

        .error {
            color: red;
        }
    </style>
</head>

<body>

    <div class="container">
        <h1>Create Account on Booky! <img src="assets/images/open-book.png" alt="logo"></h1>
        <form action="signup.php" method="post">
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" placeholder="Enter your name">
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                <?php if (isset($errorEmail)) { ?>
                    <p class="error"><?php echo $errorEmail ?></p>
                <?php } ?>

            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>
            <div class="mb-3">
                <label for="cpassword" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="Confirm your password">
                <?php if (isset($errorPass)) { ?>
                    <p class="error"><?php echo $errorPass ?></p>
                <?php } ?>

            </div>

            <button type="submit" name="signup" class="btn btn-primary">Register</button>
        </form>
        <a href="login.php">Have an account? Login</a>
        <br>
        <a href="shop.php">Back to shop</a>

    </div>
    <p class="footer-text">Developed by MrMongo</p>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>