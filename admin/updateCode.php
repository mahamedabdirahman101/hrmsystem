<?php
session_start();
include('config/dbcon.php');



if(isset($_POST['updateUser']))
    {
        $user_id = $_POST['id'];
        $name    = $_POST['name'];
        $phone   = $_POST['phone'];
        $email   = $_POST['email'];
        $pass    = $_POST['password'];



        // $query = "UPDATE `users` SET name='$name', phone='$phone', email='$email', password='$pass' WHERE `id`='$user_id'";

        $query  = "UPDATE users SET name='$name', phone='$phone', email='$email', password='$pass' WHERE id='$user_id'";
        $query_run = mysqli_query($con, $query);

        if($query_run)
        {
            $_SESSION['status']  = "User Updated Successfully!";
            header('Location: registered.php');
        }
        else 
        {
            $_SESSION['status']  = "<h4 class='alert alert-danger alert-dismissible fade'>User Updating Failed!</h4>";
            header('Location: registered.php');
        }

    }

    
?>