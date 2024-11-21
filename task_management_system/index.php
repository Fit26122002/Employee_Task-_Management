<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {

    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";

    if ($_SESSION['role'] == "admin") {

        $today_due = count_tasks_due_today($conn);
        $overdue_task = count_tasks_overdue($conn);
        $completed_task = count_tasks_completed($conn);
        $num_task = count_tasks($conn);
        $num_users = count_users($conn);
        $pending = count_pending_tasks($conn);
        $in_progress = count_in_progress_tasks($conn);
        
    } else {

        $num_my_task = count_my_tasks($conn, $_SESSION['id']);
        $overdue_task = count_my_tasks_overdue($conn, $_SESSION['id']);
        $completed_task = count_my_completed_tasks($conn, $_SESSION['id']);
        $today_due = count_my_tasks_due_today($conn, $_SESSION['id']);
        $pending = count_my_pending_tasks($conn, $_SESSION['id']);
        $in_progress = count_my_in_progress_tasks($conn, $_SESSION['id']);


    }

   

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Dashboard</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>


        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
 
        <div class="body">
        <?php include "inc/nav.php" ?>
 
            <section class="section-1">

            <?php if ($_SESSION['role'] == "admin") { ?>
                
                <div class="dashboard">
                    <div class="dashboard-item">
						<i class="fa fa-users"></i>
						<span> <?= $num_users?> Employee</span>
					</div>
                    <div class="dashboard-item">
						<i class="fa fa-tasks"></i>
						<span><?= $num_task?> All Tasks</span>
					</div> 
                    <div class="dashboard-item">
                        <i class="fa-solid fa-circle-exclamation"></i>
						<span><?=$overdue_task?> Overdue</span>
					</div> 
                    <div class="dashboard-item">
                        <i class="fa-solid fa-circle-check"></i>
						<span><?=$completed_task?> Completed</span>
					</div> 
                    <div class="dashboard-item">
                        <i class="fa-solid fa-triangle-exclamation"></i>
						<span><?=$today_due?> Due Today</span>
					</div> 
                    <div class="dashboard-item">
						<i class="fa fa-bell"></i>
						<span><?=$overdue_task?> Notification</span>
					</div>
                    <div class="dashboard-item">
                        <i class="fa-regular fa-square-minus"></i>
						<span><?=$pending?> Pending</span>
					</div>
                    <div class="dashboard-item">
						<i class="fa fa-spinner"></i>
						<span><?=$in_progress?> In progress</span>
					</div>
                </div>
              
               
           <?php } else { ?>
            <div class="dashboard">
                    <div class="dashboard-item">
						<i class="fa fa-tasks"></i>
						<span><?= $num_my_task?> My Tasks</span>
					</div> 
                    <div class="dashboard-item">
                        <i class="fa-solid fa-circle-exclamation"></i>
						<span><?=$overdue_task?> Overdue</span>
					</div> 
                    <div class="dashboard-item">
                        <i class="fa-solid fa-circle-check"></i>
						<span><?=$completed_task?> Completed</span>
					</div> 
                    <div class="dashboard-item">
                        <i class="fa-solid fa-triangle-exclamation"></i>
						<span><?=$today_due?> Due Today</span>
					</div> 
                    <div class="dashboard-item">
                        <i class="fa-regular fa-square-minus"></i>
						<span><?=$pending?> Pending</span>
					</div>
                    <div class="dashboard-item">
						<i class="fa fa-spinner"></i>
						<span><?=$in_progress?> In progress</span>
					</div>
                </div>
           <?php } ?>
             
            </section>
        </div>

        <script type="text/javascript">
       var active = document.querySelector("#navList li:nth-child(1)");
       active.classList.add("active");
    </script>

    </body>
</html>
<?php } else { 
    $em = "First login";
    header("Location: login.php?error=$em");
    exit();
}
    ?>
    