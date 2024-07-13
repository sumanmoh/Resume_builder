<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();


if ($_POST) {
    $post = $_POST;

    if ($post['email_id'] && $post['password']) {
        
        $email_id = $conn->real_escape_string($post['email_id']);
        $password = md5($conn->real_escape_string($post['password']));

        $result = $conn->query("SELECT id,full_name FROM users WHERE email_id='$email_id' AND password='$password'");
        $result = $result->fetch_assoc();

    if($result){
        
        $fn->setAuth($result);
        $fn->setAlert('logged in !');
        $fn->redirect('../myresumes.php');
        
    }else{
        $fn->setError('Incorrect email id or password');
        $fn->redirect('../login.php');
    }

    
    }else{
        $fn->setError('please fill the form !');
        $fn->redirect('../login.php');
    }
}else{
    $fn->redirect('../login.php');
}