<?php
require '../assets/class/function.class.php';
require '../assets/class/database.class.php';

$dbInstance = new Database();
$conn = $dbInstance->connect();

$slug = $_GET['resume']??'';
$resumes = $conn->query("SELECT * FROM resumes WHERE (slug='$slug' AND user_id=".$fn->Auth()['id'].") ");
$resume = $resumes->fetch_assoc();
if(!$resume){
    $fn->redirect('myresumes.php');
}

$exps = $conn->query("SELECT * FROM experiences WHERE (resume_id =".$resume['id'].") ");
$exps = $exps->fetch_all(1);

$edus = $conn->query("SELECT * FROM educations WHERE (resume_id =".$resume['id'].") ");
$edus = $edus->fetch_all(1);

$skills = $conn->query("SELECT * FROM skills WHERE (resume_id =".$resume['id'].") ");
$skills = $skills->fetch_all(1);

        $columns = '';
        $values = '';
        unset($resume['id']);
        unset($resume['slug']);
        unset($resume['updated_at']);
        $resume['resume_title'] = 'clone_'.time();

        foreach ($resume as $index => $value) {
            $value = $conn->real_escape_string($value);
            $columns .= $index . ',';
            $values .= "'$value',";
        }


        // Assuming Auth() and randomstring() methods are defined in function.class.php
        $authid = $fn->Auth()['id'];
        $columns .= 'slug,updated_at';
        $values .= "'" . $fn->randomstring() . "'," . time();

        try {
            $query = "INSERT INTO resumes ($columns) VALUES ($values)";
            
            if ($conn->query($query) === TRUE) {
                $new_resume_id = $conn -> insert_id;

                foreach($exps as $exp){
                    foreach($exp as $index=>$value){
                        $exp[$index] = $conn->real_escape_string($value);
                    }
                    $query2 = 'INSERT INTO experiences(resume_id,position,company,job_desc,started,ended) ';
                    $query2.= "VALUES ($new_resume_id,'{$exp['position']}','{$exp['company']}','{$exp['job_desc']}','{$exp['started']}','{$exp['ended']}')";
                    $conn->query($query2);
                }

                foreach($edus as $edu){
                    foreach($edu as $index=>$value){
                        $edu[$index] = $conn->real_escape_string($value);
                    }
                    $query2 = 'INSERT INTO educations(resume_id,course,institute,started,ended) ';
                    $query2.= "VALUES ($new_resume_id,'{$edu['course']}','{$edu['institute']}','{$edu['started']}','{$exp['ended']}')";
                    $conn->query($query2);
                }

                foreach($skills as $skill){
                    foreach($skill as $index=>$value){
                        $skill[$index] = $conn->real_escape_string($value);
                    }
                    $query2 = 'INSERT INTO skills(resume_id,skill) ';
                    $query2.= "VALUES ($new_resume_id,'{$skill['skill']}')";
                    $conn->query($query2);
                }
                
                $fn->setAlert('Clone created!');
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
?>