<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();


if ($_POST) {
    $post = $_POST;

    if ($post['password']) {
        
        $password =md5($conn->real_escape_string($post['password']));
        $email = $fn->getSession('email');
        
        $conn->query("UPDATE users SET password='$password' WHERE email_id='$email'");

        $fn->setAlert('password is changed !');
        $fn->redirect('../login.php');
        

    
    }else{
        $fn->setError('Please enter your new password !');
        $fn->redirect('../change-password.php');
    }
}else{
    $fn->redirect('../change-password.php');
}