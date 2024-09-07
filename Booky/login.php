<?php
include_once("dbConnect.php");

if (isset($_POST["login"])) {

    $email = mysqli_real_escape_string($db, $_POST['email']);
    $password = mysqli_real_escape_string($db, $_POST['password']);

    $query = "SELECT * FROM Users WHERE email='$email'";
    $res = mysqli_query($db, $query);
    if (!$res) {
        die($mysqli_error($db));
    }

    $error = false;
    if (mysqli_num_rows($res) == 0) {
        $error = "Wrong email or password!";
    } else {

        $user = $res->fetch_assoc();

        if (!password_verify($password, $user['password'])) {
            $error = "Wrong Email or Password!";
        } else {

            session_start();
            $_SESSION['id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['email'] = $email;
            $_SESSION['role'] = $user['role'];


            header('location:shop.php');
            exit();
        }
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
            margin: 10% auto;
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
            margin-top: -100px;
            color: #888;
        }

        .error {
            color: red;
            position: relative;
            left: 22%;
            top: -20px;
            margin: 0 auto;

        }
    </style>
</head>

<body>

    <div class="container">

        <h1>Login <img src="assets/images/open-book.png" alt="logo"></h1>

        <form action="login.php" method="post">

            <?php if (isset($error)) { ?>
                <p class="error"><?php echo $error ?></p>
            <?php } ?>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>


            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password">
            </div>


            <button type="submit" name="login" class="btn btn-primary">Login</button>
        </form>
        <a href="signup.php">Don't Have an account? Sign Up!</a>
        <br>
        <a href="shop.php">Back to shop</a>

    </div>
    <p class="footer-text">Developed by MrMongo</p>

    <script src="assets/js/bootstrap.min.js"></script>
</body>

</html>