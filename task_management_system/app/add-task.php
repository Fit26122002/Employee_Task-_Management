<?php
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

if(isset($_POST['title']) && isset ($_POST['description']) && 
isset ($_POST['assigned_to'])&& $_SESSION['role']=='admin' && isset($_POST['due_date'])){
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
    $due_date = validate_input($_POST['due_date']);



    if (empty($title)) {
        $em = "Title can't be left empty";
        header("Location: ../create_task.php?error=$em");
        exit();
    }else if (empty($description)) {
        $em = "Description is required";
        header("Location: ../create_task.php?error=$em");
        exit();
    }else if ($assigned_to == 0) {
        $em = "Select employee to be assigned";
        header("Location: ../create_task.php?error=$em");
        exit();
    }else {
        
       include "Model/Task.php";
       include "Model/Notification.php";


       $data = array($title, $description, $assigned_to, $due_date);
       insert_task($conn, $data);

       $notif_data = array("$title has been assigned to you.", $assigned_to, 'New Task Assigned');
       insert_notification($conn, $notif_data);

       $em = "Task successfully assigned";
       header("Location: ../create_task.php?success=$em");
       exit();

    }

    
    
}else{
    $em = "unknown error occured";
    header("Location: ../create_task.php?error=$em");
    exit();
}
}else { 
    $em = "First login";
    header("Location: ../create_task.php?error=$em");
    exit();
}


