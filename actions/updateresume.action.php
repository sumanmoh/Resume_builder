<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();

if ($_POST) {
    $post = $_POST;

    if ($post['id'] && $post['slug'] && $post['full_name'] && $post['email_id'] && $post['objective'] && $post['mobile_no'] && $post['dob'] && $post['religion'] && $post['nationality'] && $post['marital_status'] && $post['hobbies'] && $post['languages'] && $post['address']) {

        $columns = '';
        $values = '';
        $post2 = $post;
        unset($post2['id']);
        unset($post2['slug']);

        foreach ($post2 as $index => $value) {
            $$index = $conn->real_escape_string($value);
            $columns .= $index . "='$value',";
            // $values .= "'$value',";
        }

        $columns.='updated_at='.time();

        

        try {
            $query = "UPDATE resumes SET $columns WHERE id={$post['id']} AND slug='{$post['slug']}'";
            
            // Debug: print the constructed query
            // echo $query;
            // die();

            if ($conn->query($query) === TRUE) {
                $fn->setAlert('Resume updated!');
                $fn->redirect('../updateresume.php?resume='.$post['slug']);
            } else {
                // Handle SQL error
                throw new Exception("Error: " . $query . "<br>" . $conn->error);
            }
        } catch (Exception $error) {
            // Log the error message
            $fn->setError($error->getMessage());
            $fn->redirect('../updateresume.php?resume='.$post['slug']);
        }
    } else {
        $fn->setError('Please fill the form!');
        $fn->redirect('../updateresume.php?resume='.$post['slug']);
    }
} else {
    $fn->redirect('../updateresume.php?resume='.$post['slug']);
}
?>






