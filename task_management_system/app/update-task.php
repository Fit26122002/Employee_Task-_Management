<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if(isset($_POST['id']) &&isset($_POST['title']) && isset ($_POST['description']) && 
isset ($_POST['assigned_to'])&& $_SESSION['role']=='admin' &&isset($_POST['due_date'])){
    include "../DB_connection.php";

    //code...
    function validate_input($data) {
        $data = trim($data);
        $data = stripcslashes($data);
        $data = htmlspecialchars($data);
        return $data;        
    }

    $title = validate_input($_POST['title']);
    $description = validate_input($_POST['description']);
    $assigned_to = validate_input($_POST['assigned_to']);
    $id = validate_input($_POST['id']);
    $due_date = validate_input($_POST['due_date']);




    if (empty($title)) {
        $em = "Title can't be left empty";
	    header("Location: ../edit-task.php?error=$em&id=$id");
        exit();
    }else if (empty($description)) {
        $em = "Description is required";
        header("Location: ../edit-task.php?error=$em&id=$id");
        exit();
    }else if ($assigned_to == 0) {
        $em = "Select employee to be assigned";
        header("Location: ../edit-task.php?error=$em&id=$id");
        exit();
    }else {
        
       include "Model/Task.php";

       $data = array($title, $description, $assigned_to, $due_date, $id);
       update_task($conn, $data);

       $em = "Task updated";
       header("Location: ../edit-task.php?success=$em&id=$id");
       exit();

    }

    
    
}else{
    $em = "unknown error occured";
    header("Location: ../edit-task.php?error=$em");
    exit();
}
}else { 
    $em = "First login";
    header("Location: ../login.php?error=$em");
    exit();
}


