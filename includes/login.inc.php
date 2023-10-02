<?php

session_start();

if($_POST['d']=='ORGANISATION')
{ 

    
    
    include 'dbh.inc.php';

    $username = mysqli_real_escape_string($conn, $_POST['username']); //$username can either be username or email
    $password = mysqli_real_escape_string($conn, $_POST['password']);//user prepared statement instead of this

    //error handling: check if username exits in database
    $sql = "SELECT * FROM organizers WHERE organizer_username='$username' OR organizer_email='$username';";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck < 1) { //if no such record in database
        header("Location: ../login.php?login=notauthenticuser");
        exit();
    } else {
        // check for correct password
        if($row = mysqli_fetch_assoc($result)) {
            // DE-HASHING the password
            $hashedPasswordCheck = password_verify($password, $row['organizer_password']);
            if($hashedPasswordCheck == false) {
                header("Location: ../login.php?login=invalidPassword");
                exit();
            } elseif($hashedPasswordCheck == true) {
                // login the user here
                //session variables
                $_SESSION['o_id'] = $row['organizer_id'];
                $_SESSION['o_fullname'] = $row['organizer_fullname'];
                $_SESSION['o_username'] = $row['organizer_username'];
                $_SESSION['o_email'] = $row['organizer_email'];
                $_SESSION['o_phone'] = $row['organizer_phone'];

                $date = $row['organizer_reg_date'];
                $date = strtotime($date);
                $date = date('M D Y',$date); //show date in nice form

                $_SESSION['o_date'] = $date;
                 
                $verified = $row['verified'];
                if($verified == 1) {
                    header("Location: ../organizerHome.php");
                    exit();
                } else {
                    // echo "This account has not been yet verified. An email was sent to ".$_SESSION['o_email']." on ".$_SESSION['o_date'] ;
                    header("Location: ../login.php?account=notverified");
                }

                
            }
        }
    }

} 
else if($_POST['d']=='USER')
{


include 'dbh.inc.php';

    $username = mysqli_real_escape_string($conn, $_POST['username']); //$username can either be username or email
    $password = mysqli_real_escape_string($conn, $_POST['password']);//user prepared statement instead of this

    //error handling: check if username exits in database
    $sql = "SELECT * FROM users WHERE user_username='$username' OR user_email='$username';";
    $result = mysqli_query($conn,$sql);
    $resultCheck = mysqli_num_rows($result);

    if($resultCheck < 1) { //if no such record in database
        header("Location: ../login.php?login=notauthenticuser");
        exit();
    } else {
        // check for correct password
        if($row = mysqli_fetch_assoc($result)) {
            // DE-HASHING the password
            $hashedPasswordCheck = password_verify($password, $row['user_password']);
            if($hashedPasswordCheck == false) {
                header("Location: ../login.php?login=invalidPassword");
                exit();
            } elseif($hashedPasswordCheck == true) {
        
                // login the user here
                //session variables
                $_SESSION['u_id'] = $row['user_id'];
                $_SESSION['u_fullname'] = $row['user_fullname'];
                $_SESSION['u_username'] = $row['user_username'];
                $_SESSION['u_email'] = $row['user_email'];
                $_SESSION['u_phone'] = $row['user_phone'];

                $date = $row['user_regdate'];
                $date = strtotime($date);
                $date = date('M D Y',$date); //show date in nice form

                $_SESSION['u_date'] = $date;
                 
                //$verified = $row['verified'];
                
                    header("Location: ../userHome.php");
                    







}
}
}
}





else 
{ //if user try to access login.inc.php directly
    header("Location: ../login.php?login=error");
    exit();
}