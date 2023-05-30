<?php
    session_start();
    // If the user is logged in go to the logout page otherwise redirect to the login page
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        // If logout id is set
        if(isset($logout_id)){
            // Set the status to offline now, unset & destroy the session lastly redirect to the login page
            $status = "Offline now";
            $sql = mysqli_query($conn, "UPDATE users SET status = '{$status}' WHERE unique_id={$_GET['logout_id']}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../login.php");
            }
        }else{
            header("location: ../users.php");
        }
    }else{  
        header("location: ../login.php");
    }
?>