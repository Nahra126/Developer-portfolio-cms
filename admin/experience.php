<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";




if(isset($_POST['add_experience'])){
    $job_title = trim($_POST['job_title']);
    $company = trim($_POST['company']);
    $start_year = trim($_POST['start_year']);
    $end_year = trim($_POST['end_year']);
    $description = trim($_POST['description']);


    $sql = "INSERT INTO experience (job_title,company,start_year,end_year,description)
             VALUES ('$job_title','$company','$start_year','$end_year','$description')";





    if(mysqli_query($conn, $sql)){
        header("location:experience.php");
        exit();
    }else{
        echo "Error" . mysqli_error($conn);
    }


}


if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $sql = "DELETE FROM experience WHERE id = '$id'";

    if(mysqli_query($conn, $sql)){
        header("Location: experience.php");
exit();
    }else{
        echo "Error: " . mysqli_error($conn);
    }

}







?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<div class="container mt-4">   

<h2>Experience Management</h2>

    <form action="" method="POST" >

    <label>Job Title</label>
    <input type="text" class="form-control" name="job_title" required ><br><br>

    <label>Company</label>
    <input type="text" class="form-control" name="company" required><br><br>

    <label>Start Year</label>
    <input type="number" class="form-control" name="start_year" min="1900"
       max="2100" required><br><br>

    <label>End Year</label>
    <input type="number" class="form-control" name="end_year" min="1900"
       max="2100" required><br><br>

    <label>Description</label><br>
    <textarea name="description" class="form-control" rows="5" cols="40"  required></textarea><br><br>

    <button type="submit" class="btn btn-success" name="add_experience">
            Add Experience
        </button>

    </form>
    <?php

$sql = "SELECT * FROM experience";
$result = mysqli_query($conn, $sql);

?>

<table class="table table-bordered table-hover" border="1" cellpadding="10">

    <tr>
        <th>id</th>
        <th>Job Title</th>
        <th>Company</th>
        <th>Start_year</th>
        <th>End_year</th>
        <th>Description</th>
        <th>Action</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>

    <tr>
        <td><?php echo $row['id']; ?></td>

        <td><?php echo $row['job_title']; ?></td>

        <td><?php echo $row['company']; ?></td>

        <td><?php echo $row['start_year']; ?></td>

        <td><?php echo $row['end_year']; ?></td>

        <td><?php echo $row['description']; ?></td>
        

        <td>
            <a href="edit-experience.php?id=<?php echo $row['id']; ?>">Edit</a> |
           <a href="experience.php?delete=<?php echo $row['id']; ?>"
   onclick="return confirm('Are you sure you want to delete this experience record?')">
    Delete
</a>
        </td>

    </tr>

    <?php } ?>

    <?php
    include "../includes/footer.php";
    ?>
</body>
</html>







