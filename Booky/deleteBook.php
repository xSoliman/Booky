<?php 
include_once("dbConnect.php");
$id = $_GET['id'];
$query = "DELETE FROM Books WHERE id = $id";
if(!mysqli_query($db,$query)){
    die(mysqli_error($db));
}else{
    header('location: allBooks.php?action=delete');
}

?>