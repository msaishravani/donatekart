<?php

if(!isset($_POST['submit']))
{ //if one try to access signup.inc.php without access
    header("Location: ../signup.php");
    exit();
} 








     //will generate a random verification string key

    // check if the input characters are valid



   /* if(!preg_match("/^[a-zA-Z'. -]+$/", $fullname)) 
    {    
        header("Location: ../signup.php?signup=invalidname");
        exit();
    }*/
   
    if($_POST['d']=='ORGANISATION')
     {
        include_once 'dbh.inc.php'; //creating connection to database

    $fullname = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    // for email verification: generate vkey
    $vkey = md5(time().$username);
     
    
        // check if there is already a username with same inputted data by new user
        $sql = "SELECT * FROM organizers WHERE organizer_username = '$username'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);
        if($resultCheck > 0)
         {
            header("Location: ../signup.php?signup=usernametaken");
            exit();
         } 
        else 
        {
            // password hashing
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            // insert the organizer into database
            $sql = "INSERT INTO organizers(organizer_fullname, organizer_username, organizer_email, organizer_password, organizer_phone, vkey) VALUES('$fullname','$username','$email','$hashedPassword','$phone','$vkey');";
            $insertSuccess = mysqli_query($conn, $sql);
            // if signup data successfully inserted in database then send email to him for verification using vkey

            if($insertSuccess)
             {
                // send mail
                $url = "http://localhost:8080/Donatehere/includes/verifyEmail.inc.php?vkey=".$vkey;
                $to = $email;
                $subject = 'Email Verification';
                $message = '<p>You can verify the email from the link below:</br>';
                $message .= '<a href="' .$url. '">Verify Email</a></p>';

                $headers = "From: Fund Raiser <Himanshu@kindbeings.com>\r\n";
                $headers .= "Reply-To: shaikyounusshaik@gmail.com\r\n";
                $headers .= "Content-type: text/html\r\n"; //to make the html work in email

                mail($to, $subject, $message, $headers);

                header("Location: ../assets/html/thankyouemail.html");
                exit();

            } 
            else 
            {
                echo $conn->error;
            } 

        }
     }




 
      else if($_POST['d']=='USER')
    {
          include_once 'dbh.inc.php'; //creating connection to database

    $fullname2 = mysqli_real_escape_string($conn, $_POST['fullname']);
    $username2 = $_POST['username'];
    $email2 = mysqli_real_escape_string($conn, $_POST['email']);
    $password2 = mysqli_real_escape_string($conn, $_POST['password']);
    $phone2 = mysqli_real_escape_string($conn, $_POST['phone']);

    // for email verification: generate vkey
    


        
      
       
        $sql = "SELECT * FROM users WHERE user_username = '$username2'";
        $result = mysqli_query($conn, $sql);
        $resultCheck = mysqli_num_rows($result);

        if($resultCheck > 0)
         {
            header("Location: ../signup.php?signup=usernametaken");
            exit();
         } else
         {

            $hashedPassword2 = password_hash($_POST['password'], PASSWORD_DEFAULT);

            $var1=$_POST['fullname'];
            $var2=$_POST['username'];
            $var3=$_POST['email'];
            $var4=$_POST['phone'];
            // insert the user into database
            $sql2 = "INSERT INTO users(user_fullname, user_username, user_email, user_password, user_phone) VALUES('$var1','$var2','$var3','$hashedPassword2','$var4');";
            $insertSuccess2 = mysqli_query($conn, $sql2);
             
            if($insertSuccess2)
            {
                
                header("Location: ../assets/html/thankyouemail.html");
            }

            else
            {
                echo $conn->error;

            }

       

     }
}





