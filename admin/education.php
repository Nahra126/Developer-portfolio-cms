<?php

require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";




if(isset($_POST['add_education'])){
    $degree = trim($_POST['degree']);
    $institute = trim($_POST['institute']);
    $start_year = trim($_POST['start_year']);
    $end_year = trim($_POST['end_year']);
    $descripton = trim($_POST['descripton']);


    $sql = "INSERT INTO education (degree,institute,start_year,end_year,descripton)
             VALUES ('$degree','$institute','$start_year','$end_year','$descripton')";





    if(mysqli_query($conn, $sql)){
        header("location:education.php");
        exit();
    }else{
        echo "Error" . mysqli_error($conn);
    }


}


if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $sql = "DELETE FROM education WHERE id = '$id'";

    if(mysqli_query($conn, $sql)){
        header("Location: education.php");
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

<h2>Education Management</h2>

    <form action="" method="POST" >

    <label>Degree</label>
    <input type="text" class="form-control" name="degree" required ><br><br>

    <label>Institute</label>
    <input type="text" class="form-control" name="institute" required><br><br>

    <label>Start Year</label>
    <input type="number" class="form-control" name="start_year" min="1900"
       max="2100" required><br><br>

    <label>End Year</label>
    <input type="number" class="form-control" name="end_year" min="1900"
       max="2100" required><br><br>

    <label>Description</label><br>
    <textarea name="descripton" class="form-control" rows="5" cols="40"  required></textarea><br><br>

    <button type="submit" class="btn btn-success" name="add_education">
            Add Education
        </button>

    </form>
    <?php

$sql = "SELECT * FROM education";
$result = mysqli_query($conn, $sql);

?>

<table class="table table-bordered table-hover" border="1" cellpadding="10">

    <tr>
        <th>id</th>
        <th>Degree</th>
        <th>Institute</th>
        <th>Start_year</th>
        <th>End_year</th>
        <th>Description</th>
    </tr>

    <?php while($row = mysqli_fetch_assoc($result)){ ?>

    <tr>
        <td><?php echo $row['id']; ?></td>

        <td><?php echo $row['degree']; ?></td>

        <td><?php echo $row['institute']; ?></td>

        <td><?php echo $row['start_year']; ?></td>

        <td><?php echo $row['end_year']; ?></td>

        <td><?php echo $row['descripton']; ?></td>
        

        <td>
            <a href="edit-education.php?id=<?php echo $row['id']; ?>">Edit</a> |
           <a href="education.php?delete=<?php echo $row['id']; ?>"
   onclick="return confirm('Are you sure you want to delete this education record?')">
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







