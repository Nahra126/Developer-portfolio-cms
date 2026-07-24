<?php


require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";

$id = $_GET['id'];

$sql = "SELECT * FROM experience WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

$education = mysqli_fetch_assoc($result);
if(isset($_POST['update_experience'])){

    $job_title = trim($_POST['job_title']);
    $company = trim($_POST['company']);
    $start_year = trim($_POST['start_year']);
    $end_year = trim($_POST['end_year']);
    $descripton = trim($_POST['description']);

    $sql = "UPDATE experience SET

    job_title = '$job_title',
    company = '$company',
    start_year = '$start_year',
    end_year = '$end_year',
    description = '$description'
    


    WHERE id = '$id'";

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
     <div class="container-fluid p-4">

    <h2>Edit Experience Record</h2>

    <form action="" method="POST">

        <label>Job Title</label><br>
        <input type="text"
               name="job_title"
               value="<?php echo $education['job_title']; ?>"><br><br>

        <label>Institute</label><br>
        <input type="text"
               name="company"
               value="<?php echo $education['company']; ?>"><br><br>

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
               value="<?php echo $education['description']; ?>"><br><br>

        <button type="submit" name="update_experience">
            Update Experience
        </button>

    </form>

</div>
<?php

include "../includes/footer.php";

?>
</body>
</html>