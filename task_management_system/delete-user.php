<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id']) && $_SESSION['role'] == "admin") {
    include "DB_connection.php";
    include "app/Model/User.php";
    
    if (!isset($_GET['id'])) {
    	 header("Location: user.php");
    	 exit();
    }
    $id = $_GET['id'];
    $user = get_user_by_id($conn, $id);

    if ($user == 0) {
    	 header("Location: user.php");
    	 exit();
    }

    // Check if the user has assigned tasks
    $sql = "SELECT COUNT(*) FROM tasks WHERE assigned_to = ? AND status != 'completed'";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $taskCount = $stmt->fetchColumn(); // Fetch the number of tasks

    if ($taskCount > 0) {
        // Display a JavaScript popup if tasks are assigned
        echo "
        <script>
            alert('Cannot delete this user because tasks are assigned to them.');
            window.location.href = 'user.php'; // Redirect back to the user page
        </script>";
        exit();
    }

     $data = array($id, "employee");
     delete_user($conn, $data);
     $sm = "Deleted Successfully";
     header("Location: user.php?success=$sm");
     exit();

 }else{ 
   $em = "First login";
   header("Location: login.php?error=$em");
   exit();
}
 ?>