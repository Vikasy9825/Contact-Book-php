<?php
ob_start();
session_start();

require_once '../includes/config.php';
require_once '../includes/db.php';

$errors = [];

if(isset($_POST)){
    $firstName = trim($_POST['fname']);
    $lastName = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['cpassword']); 


//validations ---------
if(empty($firstName)){
    $errors[] = "First name can't be empty!!";
}

if(empty($email)){
    $errors[] = "Email can't be blank!!";
}

if(!empty($email) && !filter_var($email , FILTER_VALIDATE_EMAIL)){
    $errors[] = "Invalid Email Address!!";

}

if(empty($password)){
    $errors[] = "Password cannot be blank!!";
}

if(empty($confirmPassword)){
    $errors[] = "confirm Password cannot be blank!!";
}

if(!empty($password) && !empty($confirmPassword) && $password != $confirmPassword ){
    $errors[] = "Passwords doesnt match!!";

}


    // echo "All good!!"; 

    //if email already exists

    if(!empty($email)){
        $conn = db_connect();
        $sanitizeEmail = mysqli_real_escape_string($conn,$email);
        $emailSql = "SELECT id FROM `users` WHERE `email` = '{$sanitizeEmail}'";
        $sqlResult = mysqli_query($conn,$emailSql);
        $emailRow = mysqli_num_rows($sqlResult);
        if($emailRow > 0){
            $errors[] = "Email id already exists!!";
        }
        db_close($conn);
    }

    if(!empty($errors)){
        $_SESSION['errors'] = $errors;
        header('location:' .SITEURL.'signup.php');
        exit();
    }

    //if no errors

    $passwordHash = password_hash($password,PASSWORD_DEFAULT);

    $sql = "INSERT INTO `users` (first_name,last_name,email,password) VALUES('{$firstName}','{$lastName}','{$email}','{$passwordHash}')";

    $conn = db_connect();

    if(mysqli_query($conn,$sql)){

        db_close($conn);
        $message = "You are registered successfully!";
        $_SESSION['success'] = $message;
        header('location:' .SITEURL.'signup.php');

    }


}
