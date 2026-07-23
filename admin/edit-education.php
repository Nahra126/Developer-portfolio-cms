<?php


require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";

$id = $_GET['id'];

$sql = "SELECT * FROM education WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

$education = mysqli_fetch_assoc($result);
if(isset($_POST['update_education'])){

    $degree = trim($_POST['degree']);
    $institute = trim($_POST['institute']);
    $start_year = trim($_POST['start_year']);
    $end_year = trim($_POST['end_year']);
    $descripton = trim($_POST['descripton']);

    $sql = "UPDATE education SET

    degree = '$degree',
    institute = '$institute',
    start_year = '$start_year',
    end_year = '$end_year',
    descripton = '$descripton'
    


    WHERE id = '$id'";

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
     <div class="container-fluid p-4">

    <h2>Edit Education Record</h2>

    <form action="" method="POST">

        <label>Degree</label><br>
        <input type="text"
               name="degree"
               value="<?php echo $education['degree']; ?>"><br><br>

        <label>Institute</label><br>
        <input type="text"
               name="institute"
               value="<?php echo $education['institute']; ?>"><br><br>

          <label>Start_year</label><br>
        <input type="number"
               name="start_year"
               value="<?php echo $education['start_year']; ?>"><br><br>

          <label>End_year</label><br>
        <input type="number"
               name="end_year"
               value="<?php echo $education['end_year']; ?>"><br><br>

         <label>Description</label><br>
        <input type="text"
               name="descripton"
               value="<?php echo $education['descripton']; ?>"><br><br>

        <button type="submit" name="update_education">
            Update Education
        </button>

    </form>

</div>
<?php

include "../includes/footer.php";

?>
</body>
</html>