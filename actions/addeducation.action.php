<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();

if ($_POST) {
    $post = $_POST;

    // Check if all required fields are present
    if (!empty($post['resume_id']) && !empty($post['course']) && !empty($post['institute']) && !empty($post['started']) && !empty($post['ended']) ) {

        $resumeid = $post['resume_id'];
        $slug = $post['slug']; // Store the slug separately
        unset($post['resume_id']); // Remove resume_id from post data to avoid duplication
        unset($post['slug']); // Remove slug from post data to avoid insertion into the database

        $columns = '';
        $values = '';

        foreach ($post as $index => $value) {
            $$index = $conn->real_escape_string($value);
            $columns .= $index . ',';
            $values .= "'$value',";
        }

        // Add resume_id to the columns and values
        $columns .= 'resume_id';
        $values .= "'$resumeid'";

        // Assuming Auth() and randomstring() methods are defined in function.class.php
        try {
            $query = "INSERT INTO educations ($columns) VALUES ($values)";
            
            // Debug: print the constructed query
            // echo $query;
            // die();

            if ($conn->query($query) === TRUE) {
                $fn->setAlert('Experience added!');
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






