<?php
ob_start();
session_start();

require_once '../includes/config.php';
require_once '../includes/db.php';

$errors = [];

if (isset($_POST)) {
    $firstName = trim($_POST['fname']);
    $lastName = trim($_POST['lname']);
    $email = trim($_POST['email']);



    //validations ---------
    if (empty($firstName)) {
        $errors[] = "First name can't be empty!!";
    }

    if (empty($email)) {
        $errors[] = "Email can't be blank!!";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email Address!!";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('location:' . SITEURL . "edit_profile.php");
        exit();
    }



    $userId = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;

    if (!empty($userId)) {
        $sql = "UPDATE `users` SET first_name= '{$firstName}' , last_name= '{$lastName}' , email= '{$email}' WHERE id='{$userId}'";
    }
    $conn = db_connect();
    if (mysqli_query($conn, $sql)) {
        $_SESSION['success'] = "Profile has been updated!!";
        db_close($conn);
        header('location:' . SITEURL ."profile.php");
    }
}
