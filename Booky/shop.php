<?php
require_once("dbConnect.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$userLogin = false;
$admin = false;
if (isset($_SESSION['id'])) {
    $userLogin = true;
    $userId = $_SESSION['id'];
    $userName = $_SESSION['name'];
    $email = $_SESSION['email'];
    $role = $_SESSION['role'];
    if ($role == 'admin')
        $admin = true;
}

$query = "SELECT * FROM Books";
$resListBooks = mysqli_query($db, $query);
if (!$resListBooks) {
    die(mysqli_error($db));
}

$pleaseLogin = false;
$addCart = false;

if (isset($_GET['action']) && $_GET['action'] == 'addcart') {
    if ($userLogin) {
        $bookId = $_GET['id'];
        $query = "SELECT * FROM Cart WHERE bookId=$bookId AND userId=$userId";

        $resAddCart = mysqli_query($db, $query);
        if (!$resAddCart) {
            die(mysqli_error($db));
        }
        if (mysqli_num_rows($resAddCart) > 0)
            $query = "UPDATE Cart SET quantity=quantity+1 WHERE bookId=$bookId";
        else
            $query = "INSERT INTO cart (bookId,userId,quantity) VALUES ('$bookId','$userId',1)";

        $resAddCart = mysqli_query($db, $query);
        if (!$resAddCart) {
            die(mysqli_error($db));
        }
        $addCart = true;
    } else {
        $pleaseLogin = true;
    }
}


?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Nerko+One&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link href="assets/css/toastr.css" rel="stylesheet" />
    <link href="assets/css/list.css" rel="stylesheet" />
    <title>Booky | Shop</title>

    <style>
        .dashboard {
            position: absolute;
            top: 50px;
            left: 10px;
            font-size: 1rem;
            width: 170px;
            font-weight: bold;
        }
    </style>

</head>

<body>
    <div class="container">
        <div class="card-box">
            <?php
            if ($userLogin) {
            ?>
                <a href="cart.php" class="cart btn btn-warning">Go to cart <i class="bi bi-cart"></i></a>

                <a href="logout.php" class="left btn btn-danger"><i class="bi bi-arrow-bar-left"></i> Logout </a>

                <?php
                if ($admin) {
                ?>
                    <a href="allBooks.php" class="dashboard btn btn-secondary"> Admin Dashboard </a>
                <?php
                }
            } else {
                ?>
                <a href="login.php" class="left btn btn-info">Login <i class="bi bi-arrow-bar-right"></i></a>
            <?php
            }
            ?>
            <h2>
                <?php
                if ($userLogin) {
                    echo "Welcome " . $userName;
                ?>
                    <img src="assets\images\book(3).png" alt="logo3" id="logo3">
                <?php
                }
                ?>
            </h2>
            <h2>
                Available Books
            </h2>
            <div class="row">
                <?php
                while ($row = $resListBooks->fetch_assoc()) {
                ?>
                    <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                        <div class="card shadow-sm">
                            <img src="<?php echo $row['image'] ?>" class="card-img-top" alt="<?php echo $row['image'] ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                                <p class="card-text"><?php echo $row['price'] . "$"; ?></p>
                                <a href="shop.php?action=addcart&&id=<?php echo $row['id']; ?>" class="btn btn-success">Add to cart <i class="bi bi-cart-plus"></i></a>
                            </div>
                        </div>
                    </div>
                <?php
                }
                ?>
            </div>
        </div>
    </div>

    <p class="footer-text">Developed by MrMongo</p>

    <script src="assets/js/jq.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/t.js"></script>
    <script src="assets/js/main.js"></script>
    <?php
    if ($addCart) {
    ?>
        <script>
            show_add_cart()
        </script>
    <?php
    }
    ?>

    <?php
    if ($pleaseLogin) {
    ?>
        <script>
            show_login_first()
        </script>
    <?php
    }
    ?>
</body>

</html>