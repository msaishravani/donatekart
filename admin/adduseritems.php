<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin</title>
    <link rel="stylesheet" href="../assets/css/createCampaign.css">
</head>

<body>
    <?php 
    include 'dashboard.html';
    ?>

        <div class="signupbox">
        <div class="boxone">
            <span id="create">Create Store Items </span>
        </div>

        <div class="boxtwo" style="background:rgba(40,57,101,.9);">
        <br>
            <form action="includes/createuseritem.inc.php" method="POST" enctype="multipart/form-data">
            	 
                           <!-- to-do upload file -upload image only-->
            	 <span id="	ItemImage">Upload image of Item</span> <br>
                <input type="file" name=ItemPhoto accept="image/*"><br><br>


                <input type="text" name=useritem placeholder="Item Name" required><br><br>
               
                <input type="number" min="1" name="itemprice" placeholder="Price" required><br><br>
               
                               
               <input type="number" min="1" name="ItemDays" placeholder="Estimated Days" required><br><br>
                
                <textarea rows="5" cols="50" name="Description" placeholder="Description of your campaign" required></textarea><br><br>
           <input type="checkbox" required><span id="agreeterms"> Agree all terms and conditions</span><br>
                <input type="submit" name="submit" value="Create Item">
            </form>
              
                
            
        </div>
    </div>
</body>
</html>