<?php
session_start();

if(!isset($_SESSION['user_id'])){
    header("Location: login.php");
    exit();
}

require_once "../includes/auth.php";
include "../includes/header.php";
include "../includes/sidebar.php";



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
</head>
<body>
<div class="container-fluid p-4">

    <h2>Welcome <?php echo $_SESSION['username'];  ?></h2>
    <p>Login Successful 🎉</p>
    <a href="profile.php" class="btn btn-primary  me-2" >Profile Management</a>
    <br><br>
    <a href="logout.php"  class="btn btn-danger" >Logout</a>

</div>

<?php

include "../includes/footer.php";

?>


</body>
</html>