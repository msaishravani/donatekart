<!-- logic to remove expired campaign -->
<?php

    $currentDate = date('Y-m-d');

    include_once 'includes/dbh.inc.php';
    $sql = "SELECT item_id,DATE(DATE_ADD(item_regDate, INTERVAL item_days DAY)) AS endDate,
        DATE(item_regDate) AS startDate
        FROM items;";

    $result = mysqli_query($conn, $sql);
    $resultCheck = mysqli_num_rows($result);
    if($resultCheck > 0) {
        while($row = mysqli_fetch_assoc($result)) {
            $itemid = $row['item_id'];
            $itemStartDate = $row['startDate'];
            $itemEndDate = $row['endDate'];
            if($currentDate > $itemEndDate) {
                $sql = "UPDATE items
                        SET item_expiry = 0 
                        WHERE item_id = '$itemId';";
                mysqli_query($conn, $sql);
            }
        }
    }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Donate Here</title>
    <link rel="stylesheet" href="assets/css/campaigns.css">
</head>

<body>
    <!-- navigation section -->
    <div class="nav-bar">
        <a href="index.php">
            <img src="assets/images/logo.png" alt="Fund Raiser logo">
        </a>
         
        <div class="nav-links">
            <a href="campaigns2.php">CAMPAIGNS</a>
            <a href="donors2.php">DONORS</a>
        </div>

        
    </div>


    <!-- body part -->

    <div class="main-container">
            <h2>Here below are some items where you can Donate Items as much as you like.</h2>
            <form action="includes/logout.inc.php" method="POST">
                        <div class="btn-login-signup">
                            <button type="submit" id="btn-login" name="submit">LOGOUT</button>
                        </div>
                      </form>

            <div class="all-campaigns">
                <?php
                    $sql = "SELECT * FROM items WHERE  item_expiry = 1 ORDER BY item_id DESC;";
                    $result = mysqli_query($conn,$sql);
                    $resultCheck = mysqli_num_rows($result);            
                    if($resultCheck > 0) {
                        while($row = mysqli_fetch_assoc($result)) {
                            $campaignId = $row['item_id'];
                            // echo "$campaignId";               
                ?>
                <div class="preview-box">
                    <form action="singleuserItem.php?itemId=<?php echo $itemid;?>" method="POST">
                        <span id='campaign-name'>Name :<?php echo $row['item_name']; ?></span><br><br>
                        <span id='campaign-type'>Price :<?php echo $row['item_amount']; ?></span><br><br>
                        <button class="btn" type="submit" name="donate">View Item</button>
                    </form>
                </div>   
                <?php
                    }
                } else if($resultCheck == 0) {
                    echo "<p>There are no items right now</p>";
                } else {
                    exit();
                }
                ?>    
            </div>        
    </div>

    <?php
        include_once 'footer.php';
    ?>