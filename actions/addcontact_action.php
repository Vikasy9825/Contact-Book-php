<?php

ob_start();
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
$errors = [];

if (isset($_POST) && !empty($_SESSION['user'])) {
    // print_r($_POST);
    // print_arr($_FILES);
    $firstName = trim($_POST['fname']);
    $lastName = trim($_POST['lname']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);
    $cId = !empty($_POST['cid']) ? $_POST['cid'] : '';



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

    if (empty($phone)) {
        $errors[] = "Please enter phone number it can't be blank!!";
    }
    if (!empty($phone) && (strlen($phone) < 10 || strlen($phone) > 10)) {
        $errors[] = "Please enter a valid phone number!!";
    }
    if (!empty($phone) && !is_numeric($phone)) {
        $errors[] = "Phone number should be numeric!!";
    }

    if (empty($address)) {
        $errors[] = "Address field can't be blank!!";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('location:' . SITEURL . "addcontact.php");
        exit();
    }


    $ownerId = (!empty($_SESSION['user']) && !empty($_SESSION['user']['id'])) ? $_SESSION['user']['id'] : 0;

    if (!empty($cId)) {
        //update existing record
        $sql = "UPDATE  `contacts` SET first_name = '{$firstName}',last_name = '{$lastName}',email = '{$email}',phone = '{$phone}',address = '{$address}' WHERE id ={$cId} AND owner_id = {$ownerId}";
        $message = "Contact has been updated successfully!!";

    } else {

       //insert new record
        $sql = "INSERT INTO `contacts` (first_name,last_name,email,phone,address,owner_id) VALUES ('{$firstName}' , '{$lastName}', '{$email}', '{$phone}', '{$address}', '{$ownerId}')";
        $message = "New contact has been added successfully!!";

    }


    $conn = db_connect();
    if (mysqli_query($conn, $sql)) {
        db_close($conn);
        $_SESSION['success'] = $message;
        header('location:' . SITEURL);
    }
}
