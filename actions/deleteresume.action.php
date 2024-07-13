<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();

if ($_GET) {
    $post = $_GET;

    // Check if all required fields are present
    if (!empty($post['id'])) {

        $authid = $fn->Auth()['id'];

        // Assuming Auth() and randomstring() methods are defined in function.class.php
        try {
            $query = "DELETE resumes,skills,educations,experiences FROM resumes LEFT JOIN skills ON resumes.id=skills.resume_id LEFT JOIN educations ON educations.id=educations.resume_id LEFT JOIN experiences ON resumes.id=experiences.resume_id WHERE resumes.id={$post['id']} AND resumes.user_id=$authid";
            
            // Debug: print the constructed query
            // echo $query;
            // die();

            if ($conn->query($query) === TRUE) {
                $fn->setAlert('Resume deleted !');
                $fn->redirect('../myresumes.php');
            } else {
                // Handle SQL error
                throw new Exception("Error: " . $query . "<br>" . $conn->error);
            }
        } catch (Exception $error) {
            // Log the error message
            $fn->setError($error->getMessage());
            $fn->redirect('../myresumes.php');
        }
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../myresumes.php');
    }
} else {
    $fn->redirect('../myresumes.php');
}

?>