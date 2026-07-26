<?php


require_once "../includes/auth.php";
require_once "../includes/db.php";


include "../includes/header.php";
include "../includes/sidebar.php";


if(isset($_POST['add_project'])){
    $project_name = trim($_POST['project_name']);
    $technologies = trim($_POST['technologies']);
    $description = trim($_POST['description']);
    $github_link = trim($_POST['github_link']);
    $live_demo = trim($_POST['live_demo']);

    $project_image = $_FILES['project_image']['name'];
    $tmp_name = $_FILES['project_image']['tmp_name'];
    $folder = "../uploads/projects/" . $project_image;

if(move_uploaded_file($tmp_name, $folder)){
    echo "Image Uploaded Successfully";;
}else{
     echo "Image Upload Failed";

}

$sql = "INSERT INTO projects (project_name,technologies,description,github_link,live_demo,project_image)
        VALUES('$project_name','$technologies','$description','$github_link','$live_demo','$project_image')";

    if(mysqli_query($conn, $sql)){
        header("Location: project.php");
        exit();
    }else{
        echo "Error: " . mysqli_error($conn);
    }
}


if(isset($_GET['delete'])){

    $id = $_GET['delete'];

    $sql = "DELETE FROM projects WHERE id = '$id'";

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
     <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body>

<div class="container mt-4"> 

<div class="card shadow">
    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Education Management</h4>
    </div>

    <div class="card-body">

    <h2>Project Manegement</h2>

    <form action="" method="POST"  enctype="multipart/form-data">

    <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">Project Name</label>
        <input type="text"
               name="project_name"
               class="form-control">
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Technologies</label>
        <input type="text"
               name="technologies"
               class="form-control">
    </div>

</div>

    <label>Description</label><br>
    <textarea name="description" class="form-control" rows="5" cols="40"  ></textarea><br><br>

    <div class="row">

    <div class="col-md-6 mb-3">
        <label class="form-label">GitHub</label>
        <input type="text"
               name="github"
               class="form-control">
            
    </div>

    <div class="col-md-6 mb-3">
        <label class="form-label">Live Demo</label>
        <input type="text"
               name="live_demo"
               class="form-control">
    </div>

</div>

    <label>Project Image</label><br>
        <input type="file" class="form-control" name="project_image"><br><br>

   <button class="btn btn-success" name="add_project">

           <i class="bi bi-plus-circle"></i>
            Add Project

    </button>


</form>

  </div>
</div>

  <?php

$sql = "SELECT * FROM projects";
$result = mysqli_query($conn, $sql);

?>
<div class="card shadow mt-4">

    <div class="card-header bg-dark text-white">
        <h4 class="mb-0">Education Records</h4>
    </div>

            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-hover align-middle" border="1" cellpadding="10">
                        <thead class="table-dark">
                        <tr>
                            <th>id</th>
                            <th>Project_Name</th>
                            <th>Technologies</th>
                            <th>Description</th>
                            <th>GitHub</th>
                            <th>Live Demo</th>
                            <th>Project Image</th>
                            <th>Action</th>
                        </tr>
                        </thead>

                        <?php while($row = mysqli_fetch_assoc($result)){ ?>

                        <tr>
                            <td><?php echo $row['id']; ?></td>

                            <td><?php echo $row['project_name']; ?></td>

                            <td><?php echo $row['technologies']; ?></td>

                            <td><?php echo $row['description']; ?></td>

                            <td><?php echo $row['github_link']; ?></td>

                            <td><?php echo $row['live_demo']; ?></td>
                            
                            <td><?php echo $row['project_image']; ?></td>
                            
                            

                            <td>
                            <a href="edit-project.php?id=<?php echo $row['id']; ?>"
                                class="btn btn-warning btn-sm">
                                <i class="bi bi-pencil-square"></i> Edit
                            </a>

                                <a href="project.php?delete=<?php echo $row['id']; ?>"
                                class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this record?')">
                                <i class="bi bi-trash"></i> Delete
                                </a>
                            </td>

                        </tr>

                    </table>
                </div>
            </div>

</div>

    <?php } ?>



  <?php
    include "../includes/footer.php";
    ?>
</body>
</html>