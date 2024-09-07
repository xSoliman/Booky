<?php
$hostName = "localhost";
$userName = "root";
$password = "root";
$dbName = "crud";
$db = mysqli_connect($hostName, $userName, $password, $dbName);
if (!$db){
    die(mysqli_connect_error());
} 