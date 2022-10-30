<?php

ob_start();
session_start();
require_once '../includes/config.php';
require_once '../includes/db.php';
$errors = [];
if (isset($_POST)) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    if (empty($email)) {
        $errors[] = "Email can't be blank!!";
    }

    if (!empty($email) && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Invalid Email Address!!";
    }

    if (empty($password)) {
        $errors[] = "Password cannot be blank!!";
    }

    if (!empty($errors)) {
        $_SESSION['errors'] = $errors;
        header('location:' . SITEURL . 'login.php');
        exit();
    }

    //if no errors
    if (!empty($email) && !empty($password)) {

        //
        $conn = db_connect();
        $sanitizeEmail = mysqli_real_escape_string($conn, $email);
        $sql = "SELECT * FROM `users` WHERE `email` = '{$sanitizeEmail}'";
        $sqlResult = mysqli_query($conn, $sql);

        if (mysqli_num_rows($sqlResult) > 0) {
            $userInfo = mysqli_fetch_assoc($sqlResult);
            if (!empty($userInfo)) {
                $passwordInDb = $userInfo['password'];
                if (password_verify($password, $passwordInDb)) {
                    unset($userInfo['password']);
                    $_SESSION['user'] = $userInfo;
                    header('location:' . SITEURL);
                } else {
                    $errors[] = "Incorrect Password!";
                    $_SESSION['errors'] = $errors;
                    header('location:' . SITEURL . 'login.php');
                    exit();
                }
            }
        } else {
            $errors[] = "Email Address doesn't exists!";
            $_SESSION['errors'] = $errors;
            header('location:' . SITEURL . 'login.php');
            exit();
        }
    }
}
