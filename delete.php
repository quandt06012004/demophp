<?php
    include 'connect.php';
    if(!empty($_GET['id'])){
        $id = $_GET['id'];
        $sql = "delete from human where id = '$id'";
        if(mysqli_query($conn, $sql)){
            header('Location:index.php');
        }
    }
?>