<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();


if ($_POST) {
    $post = $_POST;

    if ($post['otp']) {
        
        $otp =$post['otp'];
        
        if($fn->getSession('otp')==$otp){
            $fn->setAlert('email is verified');
            $fn->redirect('../change-password.php');
        }else{
            $fn->setError('incorrect otp entered');
            $fn->redirect('../verification.php');
        }
        

    
    }else{
        $fn->setError('please enter 6 digit code that is sent to your email id !');
        $fn->redirect('../verification.php');
    }
}else{
    $fn->redirect('../verification.php');
}