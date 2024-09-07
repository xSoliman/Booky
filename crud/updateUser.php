<?php
include_once('dbConnect.php');

$id = $_GET['id'];

$query = "SELECT * FROM users WHERE id=$id";
$res = mysqli_query($db,$query);
if(!$res){
    echo mysqli_error($db);
}else{
    $user = $res->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update User</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/toastr.css">
    <link rel="stylesheet" href="assets/css/main.css">

    <style>
       
    </style>
</head>

<body>

    <div class="container">
        <div class="wrapper p-5 m-5">
            <div class="d-flex p-2 justify-content-between">
                <h2>Update User</h2>

                <div>
                    <a href="index.php"><i class="icon" data-feather="corner-down-left"></i><a>
                </div>
            </div>
            <hr>
            <form action="index.php" method="post">
                <input type="hidden" name="id" value=<?php echo $id ?>>
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" class="form-control" id="name" name="name" value=<?php echo $user['name']?>>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name="email" value=<?php echo $user['email']?>>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" value=<?php echo $user['password']?>>
                </div>
                <div class="mb-3">
                    <label for="phone" class="form-label">Phone</label>
                    <input type="phone" class="form-control" id="phone" name="phone" value=<?php echo $user['mobile']?>>
                </div>
                <button type="submit" name="edit" class="btn btn-primary">Save</button>

            </form>
        </div>
    </div>



    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/toastr.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script>
        feather.replace();
    </script>
</body>

</html>