<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();

if ($_POST) {
    $post = $_POST;

    if ($post['full_name'] && $post['email_id'] && $post['objective'] && $post['mobile_no'] && $post['dob'] && $post['religion'] && $post['nationality'] && $post['marital_status'] && $post['hobbies'] && $post['languages'] && $post['address']) {

        $columns = '';
        $values = '';
        foreach ($post as $index => $value) {
            $index = $conn->real_escape_string($index);
            $value = $conn->real_escape_string($value);
            $columns .= "$index,";
            $values .= "'$value',";
        }

        // Convert dob to a timestamp if needed
        $dob = strtotime($post['dob']);

        // Assuming Auth() and randomstring() methods are defined in function.class.php
        $authid = $fn->Auth()['id'];
        $columns .= 'slug,updated_at,user_id';
        $values .= "'" . $fn->randomstring() . "'," . time() . "," . $authid;

        // Remove the trailing commas
        $columns = rtrim($columns, ',');
        $values = rtrim($values, ',');

        try {
            $query = "INSERT INTO resumes ($columns) VALUES ($values)";
            
            // Debug: print the constructed query
            echo $query;

            if ($conn->query($query) === TRUE) {
                $fn->setAlert('Resume added!');
                $fn->redirect('../myresumes.php');
            } else {
                // Handle SQL error
                throw new Exception("Error: " . $query . "<br>" . $conn->error);
            }
        } catch (Exception $error) {
            // Log the error message
            $fn->setError($error->getMessage());
            $fn->redirect('../createresume.php');
        }
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../createresume.php');
    }
} else {
    $fn->redirect('../createresume.php');
}
?>






