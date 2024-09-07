<?php

include_once("dbConnect.php");
$action = false;
if (isset($_POST['save'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $query = "INSERT INTO users (name, email, password, mobile) VALUES ('$name', '$email', '$password', '$phone')";
    $res = mysqli_query($db, $query);
    if (!$res) {
        die(mysqli_error($db));
    } else {
        $action = "add";
    }
}

if (isset($_GET['action']) && $_GET['action'] == "del") {
    $id = $_GET['id'];
    $query_del = "DELETE FROM users WHERE id=$id";
    $res_del = mysqli_query($db, $query_del);
    if (!$res_del) {
        die(mysqli_error($db));
    } else {
        $action = "del";
    }
}

if (isset($_POST['edit'])) {
    $id = $_POST['id'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $query_edit = "UPDATE users SET name='$name', email='$email', password='$password', mobile='$phone' WHERE id=$id";
    $res_edit = mysqli_query($db, $query_edit);
    if (!$res_edit) {
        die(mysqli_error($db));
    } else {
        $action = "edit";
    }
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Users</title>
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/toastr.css">
    <link rel="stylesheet" href="assets/css/main.css">

</head>

<body>

    <div class="container">
        <div class="wrapper p-5 m-5">
            <div class="d-flex p-2 mb-2 justify-content-between">
                <h2>All Users</h2>
                <div>
                    <a href="addUser.php"><i class='icon text-success' data-feather="user-plus"></i><a>
                </div>
            </div>
            <hr>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Name</th>
                        <th scope="col">Email</th>
                        <th scope="col">Phone</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>

                <tbody>
                    <?php
                    $query = "SELECT * FROM users";
                    $res = mysqli_query($db, $query);
                    $num = 1;
                    if (!$res) {
                        die(mysqli_error($db));
                    } else if ($res->num_rows > 0) {
                        while ($row = $res->fetch_assoc()) {
                            echo "<tr>
                                <td scope=row>" . $num . "</td>" .
                                "<td scope=row>" . $row['name'] . "</td>" .
                                "<td scope=row>" . $row['email'] . "</td>" .
                                "<td scope=row>" . $row['mobile'] . "</td>" .
                                "<td scope=row>
                                <div class='justify-content-evenly'>
                                <i onclick='confirm_delete(";
                            echo $row['id'] . ")' class='m-2 text-danger' data-feather=trash-2></i> 
                                <a href='updateUser.php?id= ";
                            echo $row['id'] . " '>
                                <i class='text-primary' data-feather=edit></i>
                                </a>
                                </div>
                                 </td>";
                            $num++;
                        }
                    }
                    ?>
                </tbody>
            </table>
        </div>
    </div>


    <script src="assets/js/jquery.js"></script>
    <script src="assets/js/toastr.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <script src="assets/js/main.js"></script>
    <?php
    if ($action != false) {
        if ($action == "add") {
    ?>
            <script>
                show_add();
            </script>
        <?php
        } elseif ($action == "edit") {
        ?>
            <script>
                show_update();
            </script>
        <?php
        } elseif ($action == "del") {
        ?>
            <script>
                show_delete();
            </script>
    <?php
        }
    }
    ?>

    <script>
        feather.replace();
    </script>

</body>

</html>