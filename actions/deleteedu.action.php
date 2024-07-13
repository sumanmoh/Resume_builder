<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();

if ($_GET) {
    $post = $_GET;

    // Check if all required fields are present
    if (!empty($post['id']) && !empty($post['resume_id'])) {

        

        // Assuming Auth() and randomstring() methods are defined in function.class.php
        try {
            $query = "DELETE FROM educations WHERE id={$post['id']} AND resume_id={$post['resume_id']}";
            
            // Debug: print the constructed query
            // echo $query;
            // die();

            if ($conn->query($query) === TRUE) {
                $fn->setAlert('Education deleted !');
                $fn->redirect('../updateresume.php?resume='.$slug);
            } else {
                // Handle SQL error
                throw new Exception("Error: " . $query . "<br>" . $conn->error);
            }
        } catch (Exception $error) {
            // Log the error message
            $fn->setError($error->getMessage());
            $fn->redirect('../updateresume.php?resume='.$slug);
        }
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../updateresume.php?resume='.$post['slug']);
    }
} else {
    $fn->redirect('../updateresume.php?resume='.$post['slug']);
}

?>