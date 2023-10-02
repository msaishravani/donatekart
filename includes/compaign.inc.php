<?php

session_start();

include 'dbh.inc.php';

$organizerId = $_SESSION['o_id'];
$userId = $_SESSION['u_id'];
if(!isset($organizerId)) { //try direct access
    header("Location: ../login.php");
    exit();
} 
if(!isset($organizerId)) { //try direct access
    header("Location: ../login.php");
    exit();
} 



