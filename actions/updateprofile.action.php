<?php
session_start();
require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();


if ($_POST) {
    $post = $_POST;

    if ($post['full_name'] && $post['email_id']) {
        $full_name = $conn->real_escape_string($post['full_name']);
        $email_id = $conn->real_escape_string($post['email_id']);
        $password = md5($conn->real_escape_string($post['password']));

        $authid = $fn->Auth()['id'];

        $result = $conn->query("SELECT COUNT(*) as user FROM users WHERE (email_id='$email_id' AND id!=$authid)");
        $result = $result->fetch_assoc();

    if($result['user']){
        $fn->setError($email_id.'is already registered');
        $fn->redirect('../profile.php');
        die();
    }

    if($password!=''){
        $conn->query("UPDATE users SET full_name='$fullname',email_id='$email_id',password='$password' WHERE id=$authid");
    }else{
        $conn->query("UPDATE users SET full_name='$fullname',email_id='$email_id' WHERE id=$authid");
    }     
    
    
    $fn->setAlert('Profile is Updated !');
    $fn->redirect('../profile.php');
    
    }else{
        $fn->setError('please fill the form !');
        $fn->redirect('../profile.php');
    }
}else{
    $fn->redirect('../profile.php');
}