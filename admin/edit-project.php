<?php


require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";

$id = $_GET['id'];

$sql = "SELECT * FROM projects WHERE id = '$id'";
$result = mysqli_query($conn, $sql);

$project = mysqli_fetch_assoc($result);
if(isset($_POST['update_project'])){

    $project_name = trim($_POST['project_name']);
    $technologies  = trim($_POST['technologies']);
    $description = trim($_POST['description']);
    $github_link = trim($_POST['github_link']);
    $live_demo = trim($_POST['live_demo']);

if(!empty($_FILES['project_image']['name'])){ 
    $project_image = $_FILES['project_image']['name'];
     $temp_name = $_FILES['project_image']['tmp_name']; 
     $folder = "../uploads/projects/" .$project_image;
      move_uploaded_file($temp_name, $folder); 
      }else{
         $project_image = $project['project_image']; 
         }

    $sql = "UPDATE projects SET

    project_name = '$project_name',
    technologies = '$technologies',
    description = '$description',
    github_link = '$github_link',
    live_demo = '$live_demo',
    project_image = '$project_image'


    WHERE id = '$id'";

    if(mysqli_query($conn, $sql)){
         header("Location: project.php");
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

    <h2>Edit Project Record</h2>

    <form action="" method="POST"  enctype="multipart/form-data">

        <label>Project Name</label><br>
        <input type="text"
               name="project_name" class="form-control" 
               value="<?php echo $project['project_name']; ?>"><br><br>

        <label>Technologies</label><br>
        <input type="text"
               name="technologies" class="form-control" 
               value="<?php echo $project['technologies']; ?>"><br><br>

          <label>Description</label><br>
        <textarea name="description" class="form-control" rows="5" cols="40"  ></textarea><br><br>

          <label>GitHub</label><br>
        <input type="url"
               name="github_link" class="form-control" 
               value="<?php echo $project['github_link']; ?>"><br><br>

         <label>Live Demo</label><br>
        <input type="url"
               name="live_demo" class="form-control" 
               value="<?php echo $project['live_demo']; ?>"><br><br>

         <label>Project Image</label><br>
        <input type="file" name="project_image"  class="form-control" ><br><br>

        <button type="submit" name="update_project" class="btn btn-success">
            Update Project
        </button>

    </form>

</div>
<?php

include "../includes/footer.php";

?>
</body>
</html>