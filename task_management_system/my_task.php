<?php 
session_start();
if (isset($_SESSION['role']) && isset($_SESSION['id'])) {
    include "DB_connection.php";
    include "app/Model/Task.php";
    include "app/Model/User.php";


    $tasks = get_all_tasks_by_id($conn, $_SESSION['id']);

?>

<!DOCTYPE html>
<html>
    <head>
        <title>My tasks</title>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
        <link rel="stylesheet" href="css/style.css">
    </head>

    <body>


        <input type="checkbox" id="checkbox">
        <?php include "inc/header.php" ?>
 
        <div class="body">
        <?php include "inc/nav.php" ?>
 
            <section class="section-1">
			<h4 class="title">My tasks</h4>
            <?php if (isset($_GET['success'])) {?>
                    <div class="success" role="alert">
                    <?php echo stripcslashes($_GET['success']); ?>
                    </div>
                <?php } ?>
            <?php if ($tasks != 0) { ?>

            <table class="main-table">
                <tr>
                    <th>#</th>
					<th>Title</th>
					<th>Description</th>
                    <th>Status</th>
                    <th>Due date</th>
					<th>Action</th>
                </tr> 
                <?php $i=0; foreach ($tasks as $task) { ?>
                <tr>
                  <td><?=++$i?></td>
                  <td><?=$task['title']?></td>
                  <td><?=$task['description']?></td>
                  <td><?=$task['status']?></td>
                  <td><?=$task['due_date']?></td>


              
                  <td align="center">
                  <a href="edit-task-employee.php?id=<?=$task['id']?>" class="edit-btn">Edit</a>
                </td>   
                </tr> 
                <?php  }  ?>
            </table>
            <?php } else { ?>
                <h3>Empty</h3>
            <?php }?>


            </section>
        </div>

    <script type="text/javascript">
       var active = document.querySelector("#navList li:nth-child(2)");
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
    