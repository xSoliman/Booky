<?php
require_once("dbConnect.php");
$query = "SELECT * FROM Books";
$res = mysqli_query($db, $query);
if (!$res) {
    die(mysqli_error($db));
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
    <link rel="stylesheet" href="assets/css/list.css">
    <link rel="stylesheet" href="assets/css/toastr.css" />
    <title>Booky Dashboard | All Books</title>

</head>

<body>
    <div class="container">
        <div class="card-box">
            <a href="addBook.php"  class="add btn btn-success">Add Book <i class="bi bi-journal-plus"></i></a>
            <a href="shop.php" class="back-link"> <i class="bi bi-arrow-90deg-left"></i> Back to store</a>
            <h2>
                All Books
            </h2>
            <div class="row">
                <?php
                while ($row = $res->fetch_assoc()) {
                ?>
                    <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                        <div class="card shadow-sm">
                            <img src="<?php echo $row['image'] ?>" class="card-img-top" alt="...">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name'] ?></h5>
                                <p class="card-text"><?php echo $row['price'] . "$"; ?></p>
                                <a href="editBook.php?id=<?php echo $row['id']; ?>" class="btn btn-primary">Edit <i class="bi bi-pencil-square"></i></a>
                                <a onclick="confirm_delete(<?php echo $row['id']; ?>)" class="btn btn-danger">Delete <i class="bi bi-trash-fill"></i></a>
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

    <script src="assets/js/main.js"></script>
    <script src="assets/js/jq.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/t.js"></script>
    <?php
    if (isset($_GET['action']))
        if ($_GET['action'] == "delete") {
    ?>
        <script>
            show_delete()
        </script>
    <?php
        }
    ?>
</body>

</html>