<?php 
include_once("dbConnect.php");

$bookId = $_GET['bookId'];
$userId = $_GET['userId'];
$query = "DELETE FROM Cart WHERE bookId = $bookId AND userId = $userId  ";
if(!mysqli_query($db,$query)){
    die(mysqli_error($db));
}else{
    header('location: cart.php?action=delete');
}

?>