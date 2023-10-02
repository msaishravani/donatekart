<?php


if(!isset($_POST['submit'])) { //if one try to access this file direct
    header("Location: ../addEventByAdmin.php");
    exit();
} else {

    include_once 'dbh.inc.php'; //creating connection to database

     $filename = $_FILES['ItemPhoto']['name'];
    $useritem = $_POST['useritem'];
    $itemprice = $_POST['itemprice'];
    $ItemDays = $_POST['ItemDays'];
    
    $Description = $_POST['Description'];

    // error handling
    if(!preg_match("/^[a-zA-Z'. -]+$/", $useritem)) {    
        header("Location: ../addEventByAdmin.php?user=invalidname");
        exit();
    } else {
        // check if there is already a campaign with same inputted campaignName by the organizer
        $sql = "SELECT * FROM items WHERE name = '$useritem'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0) {
            header("Location: ../addEventByAdmin.php?item=ItemNameTaken");
            exit();
        } else {

            // for campaign photo part

            
            $filename = md5($filename.time());
            $tempname = $_FILES['ItemPhoto']['tmp_name'];
            $userImagePath = "assets/images/userImages/".$filename;
            
            move_uploaded_file($tempname,$userImagePath);

             //insert the input value into database
             $sql = "INSERT INTO items(item_name,item_amount,item_days,item_description,item_image) VALUES('$useritem','$itemprice','$ItemDays','$Description',
             '$userImagePath');";
             $insertSuccess = mysqli_query($conn, $sql);
// to-do
             // if campaign input data successfully inserted in database then redirect him to success page with link of organizer profile
             if($insertSuccess) {
                echo "<h1>inserted into database</h1>";
                header("Location: ../includes/successEvent.php");
             } else {
                 echo $conn->error;
             }
        }
    }

}