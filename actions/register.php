<?php
session_start();
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();


if ($_POST) {
    $post = $_POST;

    if ($post['full_name'] && $post['email_id'] && $post['password']) {
        $full_name = $conn->real_escape_string($post['full_name']);
        $email_id = $conn->real_escape_string($post['email_id']);
        $password = md5($conn->real_escape_string($post['password']));

        $result = $conn->query("SELECT COUNT(*) as user FROM users WHERE email_id='$email_id' AND password='$password'");
        $result = $result->fetch_assoc();

    if($result['user']){
        $fn->setError($email_id.'is already registered');
        $fn->redirect('../register.php');
        die();
    }

         
    try {
        $conn->query("INSERT INTO users(full_name, email_id, password) VALUES('$full_name', '$email_id', '$password')");
        $fn->setAlert('You registered successfully!');
        $fn->redirect('../login.php');
    }catch(Exception $error){
            $fn->setError($error->getMessage());
            $fn->redirect('../register.php');
        }
    }else{
        $fn->setError('please fill the form !');
        $fn->redirect('../register.php');
    }
}else{
    $fn->redirect('../register.php');
}