<?php

session_start();

include 'dbh.inc.php';

$userId=$_SESSION['u_id'];


if(!isset($userId)) { //try direct access
    header("Location: ../index.php");
    exit();
}

$sql = "SELECT * FROM users WHERE user_id = $userId;";
$result = mysqli_query($conn,$sql);
$data = mysqli_fetch_assoc($result);

 //this is  $row = resultset


