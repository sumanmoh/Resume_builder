<?php

require '../assets/class/database.class.php';
require '../assets/class/function.class.php';

// Instantiate the Database class and get the connection
$dbInstance = new Database();
$conn = $dbInstance->connect();

if ($_POST) {
    $post = $_POST;

    if ($post['resume_id'] && $post['background']) {


        $tile = $conn->real_escape_string($post['background']);
        
        $query = "UPDATE resumes SET background='$tile' WHERE id={$post['resume_id']}";

        $conn->query($query);
    }
} 
?>






