<?php 
    session_start();
    include_once "config.php";//We require the database connection
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);

    // We check that the email & password are not empty
    if(!empty($email) && !empty($password)){
        // We check if the user entered email & password match with the once in the database
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
        // If user credentials matched
        if(mysqli_num_rows($sql) > 0){
            $row = mysqli_fetch_assoc($sql);
            $user_pass = md5($password);
            $enc_pass = $row['password'];
            if($user_pass === $enc_pass){
                $status = "Active now";
                $sql2 = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                if($sql2){
                    // I get the unique_id of the current logged in user & use it in session on this page
                    $_SESSION['unique_id'] = $row['unique_id'];
                    echo "success";
                }else{
                    echo "Something went wrong. Please try again!";
                }
            }else{
                echo "Email or Password is Incorrect!";
            }
        }else{
            echo "$email - This email doesn't Exist!";
        }
    }else{
        echo "All input fields are required!";
    }
?>