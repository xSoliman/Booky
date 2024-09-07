<?php
require_once("dbConnect.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$userLogin = false;
if (isset($_SESSION['id'])) {
    $userLogin = true;
    $userId = $_SESSION['id'];
    $userName = $_SESSION['name'];
    $email = $_SESSION['email'];
}
if (!$userLogin) {
    header('location:shop.php');
    exit();
}


$query = "SELECT * FROM Cart where userId=$userId";
$resListItems = mysqli_query($db, $query);
if (!$resListItems) {
    die(mysqli_error($db));
}

$cartItems = array();
while ($book = $resListItems->fetch_assoc()) {
    $bookId = $book['bookId'];
    $query = "SELECT * FROM Books where id=$bookId";
    $resBookDetails = mysqli_query($db, $query);
    if (!$resBookDetails) {
        die(mysqli_error($db));
    }
    $bookDetails = $resBookDetails->fetch_assoc();
    $bookName = $bookDetails['name'];
    $bookPrice = $bookDetails['price'];
    $bookImage = $bookDetails['image'];
    $quantity = $book['quantity'];

    $cartItems[] = array('id' => $bookId, 'name' => $bookName, 'price' => $bookPrice, 'quantity' => $quantity, 'image' => $bookImage);
}

$pleaseLogin = false;
$addCart = false;

if (isset($_GET['action']) && $_GET['action'] == 'addcart') {
    if ($userLogin) {
        $bookId = $_GET['id'];
        $query = "INSERT INTO cart (bookId,userId) VALUES ('$bookId','$userId')";
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
    <link href="assets/css/list.css" rel="stylesheet" />
    <link href="assets/css/toastr.css" rel="stylesheet" />
    <title>Booky | Shop</title>
    <style>
        .left {
            position: absolute;
            top: 10px;
            left: 10px;
            font-size: 1rem;
            width: 130px;
            color: white;
            font-weight: bold;
        }

        .right {
            position: relative;
            bottom: 20px;
            left: 575px;
            font-size: 1rem;
            width: 150px;
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
                <a href="logout.php" class="left btn btn-warning"><i class="bi bi-arrow-bar-left"></i> Back to shop </a>
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
                Cart
            </h2>
            <div class="row">
                <?php
                if (count($cartItems) > 0) {
                    foreach ($cartItems as $row) {
                ?>
                        <div class="list-group">

                            <div href="#" class="list-group-item list-group-item-action">
                                <div class="d-flex w-100 justify-content-between">
                                    <h5 class="mb-1"><?php echo $row['name'] ?></h5>
                                    <small class="text-body-secondary">
                                        <img src="<?php echo $row['image'] ?>" class="card-img-top" alt="<?php echo $row['image'] ?>">

                                    </small>

                                </div>
                                <p class="mb-1"><?php echo $row['price'] . "$"; ?></p>
                                <small class="text-body-secondary">Quantity = <?php echo $row['quantity'] ?></small>
                                <br>
                                <small class="text-body-secondary">Total = <?php echo $row['quantity'] * $row['price'] ?>$</small>
                                <a href="removeCart.php?bookId=<?php echo $row['id'] ?>&&userId=<?php echo $userId ?>" class="btn btn-danger right">Remove from cart</a>
                            </div>

                        </div>
                <?php
                    }
                }
                ?>
            </div>
        </div>
    </div>

    <p class="footer-text">Developed by MrMongo</p>

    <script src="assets/js/jq.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/t.js"></script>
    <?php
    if ($addCart) {
    ?>
        <script>
            show_add_cart();
        </script>
    <?php
    }
    ?>

    <?php
    if ($pleaseLogin) {
    ?>
        <script>
            show_login_first();
        </script>
    <?php
    }
    ?>

    <?php
    if (isset($_GET['action']))
        if ($_GET['action'] == "delete") {
    ?>
        <script>
            show_remove_cart();
        </script>
    <?php
        }
    ?>

</body>

</html>