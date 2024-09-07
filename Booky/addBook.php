<?php
include_once("dbConnect.php");

$action = 0;
if (isset($_POST['upload'])) {
    $name = $_POST['name'];
    $price = $_POST['price'];
    $image = $_FILES['image'];
    $image_location = $_FILES['image']['tmp_name'];
    $image_name = $_FILES['image']['name'];
    $image_up = "assets/images/" . $image_name;
    $image_db = "assets/images/" . $image_name;
    $query = "INSERT INTO Books (name,price,image) VALUES('$name','$price','$image_db');";
    if (!mysqli_query($db, $query)) {
        die(mysqli_error($db));
    } else {
        if (move_uploaded_file($image_location, $image_up))
            $action = "add";
        else
            die("<script>alert('Upload image failed')</script>");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link href="assets/css/toastr.css" rel="stylesheet" />
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Nerko+One&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/addBook.css">
    <title>Booky Dashboard | Add book</title>
</head>

<body>
    <div class="main">
        <h1>
            Add Book
            <!-- <img src="assets/images/book(1).png" alt="logo" style="width:45px"> -->
        </h1>

        <!-- <img src="assets/images/logo.jpg" alt="logo" id="logo"> -->

        <form action="addBook.php" method="POST" enctype="multipart/form-data">
            <div class="form-group">
                <input type="text" name="name" placeholder="Book Name" required>
            </div>
            <div class="form-group">
                <input type="number" name="price" placeholder="Book Price" required>
            </div>
            <div class="form-group">
                <label for="file" class="file-label">Choose Book Image</label>
                <input type="file" name="image" id="file">
            </div>
            <div class="form-group uploadProduct">
                <label for="upload" class="upload-label">
                    Submit
                    <img src="assets/images/ebook.png" alt="add" id="addIcon">
                </label>
                <input type="submit" name="upload" id="upload">
            </div>
        </form>

        <div class="store">
            <a href="allBooks.php">Display All Books</a>
        </div>

    </div>
    <p class="footer-text">Developed by MrMongo</p>

    <script src="assets/js/jq.js"></script>
    <script src="assets/js/t.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <?php
    if ($action != false && $action == "add") {
    ?>
        <script>
            show_add_book();
        </script>
    <?php } ?>
</body>

</html>