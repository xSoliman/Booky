<?php
$hostname = "localhost";
$user = "root";
$password = "root";
$dbName = "Ebooks";
$db = mysqli_connect($hostname, $user, $password);
if (!$db)
    die(mysqli_connect_error());

$query = "CREATE DATABASE IF NOT EXISTS $dbName;";
if (!mysqli_query($db, $query)) {
    die("Error creating database: " . mysqli_error($db));
}
mysqli_select_db($db, $dbName);
$query = "
        CREATE TABLE IF NOT EXISTS Books(
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(200),
        price FLOAT,
        image VARCHAR(200),
        PRIMARY KEY (id)
        );";

$res = mysqli_query($db, $query);
if (!$res) {
    die(mysqli_error($db));
}

$query = "
    CREATE TABLE IF NOT EXISTS Users (
        id INT NOT NULL AUTO_INCREMENT,
        name VARCHAR(50),
        email VARCHAR(200),
        password VARCHAR(50),
        role VARCHAR(50),
        PRIMARY KEY (id)
    );";

$res = mysqli_query($db, $query);
if (!$res) {
    die(mysqli_error($db));
}

$query = "
    CREATE TABLE IF NOT EXISTS Cart (
        id INT NOT NULL AUTO_INCREMENT,
        bookId INT,
        userId INT,
        quantity INT, 
        PRIMARY KEY (id),
        CONSTRAINT fk_user
            FOREIGN KEY (userId) 
            REFERENCES Users(id)
            ON DELETE CASCADE
    );";

$res = mysqli_query($db, $query);
if (!$res) {
    die(mysqli_error($db));
}


?>