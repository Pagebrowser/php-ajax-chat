<?php
    session_start();
    include_once "config.php"; //We require the database connection
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password)){
        // We check if user email is valid/not
        if(filter_var($email, FILTER_VALIDATE_EMAIL)){ 
            // We check if the valid email already exists in the database
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
            if(mysqli_num_rows($sql) > 0){ //If email appears more than once
                echo "$email - This email already exist!";
            }else{
                // We check if the user uploaded a file/not
                if(isset($_FILES['image'])){ //We use the file input name from the signup form to check If the file is uploaded successfully
                    // We then get the user uploaded image name, type and temporary name which is used to save the file in our folder
                    $img_name = $_FILES['image']['name'];
                    $img_type = $_FILES['image']['type'];
                    $tmp_name = $_FILES['image']['tmp_name'];
                    
                    // We now explode the image so as to get the last extension to see if its a valid type
                    $img_explode = explode('.',$img_name);
                    //Here we get the extension of the user uploaded file
                    $img_ext = end($img_explode);
                    
                    //We then define the valid extensions & store the extension in an array
                    $extensions = ["jpeg", "png", "jpg"];
                    //If the user uploaded image extension matches with the valid image extensions
                    if(in_array($img_ext, $extensions) === true){
                        $types = ["image/jpeg", "image/jpg", "image/png"];
                        if(in_array($img_type, $types) === true){
                            //time variable returns the current time so we need this time because when u upload an image to our folder we rename the user file with the current time so that all images will have a unique name
                            $time = time();
                            // We move the uploaded images to a particular folder
                            $new_img_name = $time.$img_name;
                            // If we successfully manage to move the user uploaded image to the folder
                            if(move_uploaded_file($tmp_name,"images/".$new_img_name)){
                                //We create a random id for the user
                                $ran_id = rand(time(), 100000000);
                                //We set their status to be Active now
                                $status = "Active now";
                                $encrypt_pass = md5($password);
                                //We insert all user data inside the table
                                $insert_query = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, password, img, status)
                                VALUES ({$ran_id}, '{$fname}','{$lname}', '{$email}', '{$encrypt_pass}', '{$new_img_name}', '{$status}')");
                                //If the data inserted successfully
                                if($insert_query){
                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if(mysqli_num_rows($select_sql2) > 0){
                                        $result = mysqli_fetch_assoc($select_sql2);
                                        // Using this session we can use our user unique_id in other php files
                                        $_SESSION['unique_id'] = $result['unique_id'];
                                        echo "success";
                                    }else{
                                        echo "This email address does not Exist!";
                                    }
                                }else{
                                    echo "Something went wrong. Please try again!";
                                }
                            }
                        }else{
                            echo "Please upload an image file - jpeg, png or jpg";
                        }
                    }else{
                        echo "Please upload an image file - jpeg, png or jpg";
                    }
                }
            }
        }else{
            echo "$email is not a valid email!";
        }
    }else{
        echo "All input fields are required!";
    }
?>