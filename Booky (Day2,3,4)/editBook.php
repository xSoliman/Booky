<?php
include_once("dbConnect.php");

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $action = false;

    if (isset($_POST['save'])) {
        $name = $_POST['name'];
        $price = $_POST['price'];

        if (!empty($_FILES['image']['tmp_name'])) {
            $image_location = $_FILES['image']['tmp_name'];
            $image_name = $_FILES['image']['name'];
            $image_up = "assets/images/" . $image_name;
            $image_up = "assets/images/" . $image_name;
            $image_db = "assets/images/" . $image_name;
            if (move_uploaded_file($image_location, $image_up)) {
                $query = "UPDATE Books SET name='$name', price='$price', image='$image_db' WHERE id=$id";
            } else {
                die("<script>alert('Upload image failed')</script>");
            }
        } else {
            $query = "UPDATE Books SET name='$name', price='$price' WHERE id=$id";
        }

        if (mysqli_query($db, $query)) {
            $action = "update";
        } else {
            die(mysqli_error($db));
        }
    }
?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="assets/css/bootstrap.min.css">
        <link rel="stylesheet" href="assets/css/toastr.css" />
        <link rel="stylesheet" href="assets/css/addBook.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Dosis:wght@200..800&family=Nerko+One&family=Roboto+Mono:ital,wght@0,100..700;1,100..700&display=swap" rel="stylesheet">
        <title>Booky Dashboard | Edit book</title>
        <style>
            .main {
                margin-top: 10%;
            }
        </style>
    </head>

    <body>
        <div class="main">
            <h1>
                Edit Book
                <img src="assets/images/book(2).png" alt="logo" style="width:45px">
            </h1>
            <?php
            $query = "SELECT * FROM Books WHERE id = $id";
            $res = mysqli_query($db, $query);
            if (!$res) {
                die(mysqli_error($db));
            }
            $book = $res->fetch_assoc();
            ?>
            <form action="editBook.php?id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <input type="text" name="name" placeholder="Book Name" value="<?php echo $book['name']; ?>" required>
                </div>
                <div class="form-group">
                    <input type="number" name="price" placeholder="Book Price" value="<?php echo $book['price']; ?>" required>
                </div>
                <div class="form-group">
                    <label for="file" class="file-label">Choose Book Image</label>
                    <input type="file" name="image" id="file">
                </div>
                <div class="form-group uploadProduct">
                    <label for="upload" class="upload-label">
                        Save
                    </label>
                    <input type="submit" name="save" id="upload">
                </div>
            </form>

            <div class="store">
                <a href="allBooks.php">Display All Books</a>
            </div>

        </div>
        <p class="footer-text">Developed by MrMongo</p>

        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jq.js"></script>
        <script src="assets/js/t.js"></script>
        <script src="assets/js/main.js"></script>

        <?php
        if ($action != false && $action == "update") {
        ?>
            <script>
                show_update();
            </script>
    <?php }
    } ?>
    </body>

    </html>